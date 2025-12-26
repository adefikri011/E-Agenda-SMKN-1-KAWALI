<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Jampel;
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\KegiatanSebelumKBM;
use App\Models\GuruMapel;
use App\Models\MataPelajaran;
use App\Traits\CanManageAbsensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AgendaExport;
use Illuminate\Support\Facades\Auth;


class AgendaController extends Controller
{
    use CanManageAbsensi;
    // Mendapatkan daftar kelas yang diampu oleh guru/walikelas
    private function getGuruKelas()
    {
        if (auth()->user()->hasRole('guru') || auth()->user()->hasRole('walikelas')) {
            $guru = $this->getGuruFromUser();
            if ($guru) {
                return GuruMapel::where('guru_id', $guru->id)
                    ->with(['kelas', 'mapel'])
                    ->get()
                    ->unique('kelas_id')
                    ->pluck('kelas');
            }
            return collect();
        } else {
            // Untuk siswa, dapatkan kelas siswa tersebut
            return Kelas::where('id', auth()->user()->siswa->kelas_id)->get();
        }
    }

    // Mendapatkan daftar mata pelajaran yang diampu oleh guru/walikelas di kelas tertentu
    private function getGuruMapel($kelasId)
    {
        if (auth()->user()->hasRole('guru') || auth()->user()->hasRole('walikelas')) {
            $guru = $this->getGuruFromUser();
            if ($guru) {
                return GuruMapel::where('guru_id', $guru->id)
                    ->where('kelas_id', $kelasId)
                    ->with('mapel')
                    ->get()
                    ->pluck('mapel');
            }
            return collect();
        } else {
            // Untuk siswa, dapatkan semua mata pelajaran di kelasnya
            return MataPelajaran::all();
        }
    }

    public function index()
    {
        $jampel = Jampel::all();

        // Get kelas yang diampu oleh guru atau kelas siswa
        $kelas = $this->getGuruKelas();
        $kelasIds = $kelas->pluck('id');

        $kegiatanSebelumKBM = KegiatanSebelumKBM::orderBy('hari')->get();

        // Query berdasarkan role user
        if (auth()->user()->hasRole('guru') || auth()->user()->hasRole('walikelas')) {
            // Guru/Walikelas hanya bisa melihat agenda untuk kelas dan mapel yang diampu
            $agendas = Agenda::with(['kelas', 'jampel', 'user', 'guruTtd'])
                ->whereIn('kelas_id', $kelasIds)
                ->orderBy('tanggal', 'desc')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            // Siswa hanya bisa melihat agenda miliknya sendiri di kelasnya
            $agendas = Agenda::with(['kelas', 'jampel', 'guruTtd'])
                ->where('users_id', auth()->id())
                ->where('kelas_id', auth()->user()->siswa->kelas_id)
                ->orderBy('tanggal', 'desc')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }

        // Ambil 5 agenda terbaru untuk sidebar
        $recentAgendas = Agenda::with(['kelas', 'jampel'])
            ->whereIn('kelas_id', $kelasIds)
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Ambil data siswa tidak hadir (pastikan ini selalu terdefinisi)
        $siswaTidakHadir = collect(); // Default collection kosong

        // Untuk role guru dan walikelas
        if (auth()->user()->hasRole('guru') || auth()->user()->hasRole('walikelas')) {
            $siswaTidakHadir = $this->getSiswaTidakHadir();
        }

        return view('guru.agenda.index', compact('jampel', 'kelas', 'agendas', 'recentAgendas', 'kegiatanSebelumKBM', 'siswaTidakHadir'));
    }

    public function create()
    {
        // Tentukan hari saat ini
        $englishDay = now()->format('l');
        $dayMap = [
            'Monday' => 'senin',
            'Tuesday' => 'selasa_rabu_kamis',
            'Wednesday' => 'selasa_rabu_kamis',
            'Thursday' => 'selasa_rabu_kamis',
            'Friday' => 'jumat',
            'Saturday' => 'senin',
            'Sunday' => 'senin',
        ];
        $todayHariTipe = $dayMap[$englishDay] ?? 'senin';

        // Ambil jampel hanya untuk hari hari ini
        $jampel = Jampel::where('hari_tipe', $todayHariTipe)
            ->orderBy('jam_ke')
            ->get();

        // Get kelas yang diampu oleh guru atau kelas siswa
        $kelas = $this->getGuruKelas();
        $kelasIds = $kelas->pluck('id');

        $kegiatanSebelumKBM = KegiatanSebelumKBM::orderBy('hari')->get();

        // Ambil 5 agenda terbaru untuk sidebar
        $recentAgendas = Agenda::with(['kelas', 'jampel'])
            ->whereIn('kelas_id', $kelasIds)
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('guru.agenda.create', compact('jampel', 'kelas', 'recentAgendas', 'kegiatanSebelumKBM'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'start_jampel_id' => 'required|exists:jam_pelajaran,id',
            'end_jampel_id' => 'required|exists:jam_pelajaran,id',
            'kelas_id' => 'required|exists:kelas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'guru_id' => 'required|exists:guru,id',
            'materi' => 'required|string|max:500',
            'kegiatan' => 'required|string',
            'catatan' => 'nullable|string',
        ]);

        // Cek hak akses kelas untuk guru/walikelas
        if (auth()->user()->hasRole('guru') || auth()->user()->hasRole('walikelas')) {
            $guru = $this->getGuruFromUser();
            $allowed = $guru ? GuruMapel::where('guru_id', $guru->id)
                ->where('kelas_id', $validated['kelas_id'])
                ->exists() : false;

            if (!$allowed) {
                return back()->withInput()->with('error', '❌ Anda tidak memiliki akses ke kelas ini.');
            }
        }

        // Cek apakah kombinasi kelas, mapel, dan guru valid
        $guruMapel = GuruMapel::where('kelas_id', $validated['kelas_id'])
            ->where('mapel_id', $validated['mata_pelajaran_id'])
            ->where('guru_id', $validated['guru_id'])
            ->first();

        if (!$guruMapel) {
            return back()->withInput()->with('error', '❌ Kombinasi kelas, mata pelajaran, dan guru tidak valid.');
        }

        // Ambil data mata pelajaran
        $mapel = MataPelajaran::find($validated['mata_pelajaran_id']);
        if (!$mapel) {
            return back()->withInput()->with('error', '❌ Mata pelajaran tidak ditemukan.');
        }

        // Siapkan data untuk disimpan
        $data = [
            'tanggal' => $validated['tanggal'],
            'start_jampel_id' => $validated['start_jampel_id'],
            'end_jampel_id' => $validated['end_jampel_id'],
            'kelas_id' => $validated['kelas_id'],
            'mata_pelajaran' => $mapel->nama, // Simpan nama mapel
            'materi' => $validated['materi'],
            'kegiatan' => $validated['kegiatan'],
            'catatan' => $validated['catatan'] ?? null,
            'users_id' => auth()->id(),
            'pembuat' => (auth()->user()->hasRole('guru') || auth()->user()->hasRole('walikelas')) ? 'guru' : 'siswa',
        ];

        // Status tanda tangan
        if ($data['pembuat'] === 'guru') {
            $request->validate([
                'tanda_tangan' => 'required|string|min:50',
            ]);

            $data['status_ttd'] = 'sudah';
            $data['sudah_ttd'] = true;
            $data['guru_ttd_id'] = auth()->id();
            $data['waktu_ttd'] = now();
            $data['tanda_tangan'] = $request->tanda_tangan;
        } else {
            $data['status_ttd'] = 'belum';
            $data['sudah_ttd'] = false;
            $data['guru_ttd_id'] = null;
            $data['waktu_ttd'] = null;
            $data['tanda_tangan'] = null;
        }

        try {
            Agenda::create($data);
            return redirect()->route('agenda.index')
                ->with('success', '✅ Agenda berhasil disimpan!');
        } catch (\Exception $e) {
            Log::error('Agenda Store Error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', '❌ Gagal menyimpan agenda: ' . $e->getMessage());
        }
    }


    public function show($id)
    {
        $agenda = Agenda::with(['kelas', 'jampel', 'user', 'guruTtd'])->findOrFail($id);

        // Cek apakah user berhak melihat agenda ini
        if (auth()->user()->hasRole('guru') || auth()->user()->hasRole('walikelas')) {
            // Guru/Walikelas hanya bisa melihat agenda untuk kelas yang diampu
            $guru = $this->getGuruFromUser();
            $guruKelas = $guru ? GuruMapel::where('guru_id', $guru->id)
                ->where('kelas_id', $agenda->kelas_id)
                ->exists() : false;

            if (!$guruKelas) {
                abort(403, 'Unauthorized action.');
            }
        } else {
            // Siswa hanya bisa melihat agenda miliknya sendiri di kelasnya
            if ($agenda->users_id != auth()->id() || $agenda->kelas_id != auth()->user()->siswa->kelas_id) {
                abort(403, 'Unauthorized action.');
            }
        }

        return view('guru.agenda.show', compact('agenda'));
    }

    public function edit($id)
    {
        $agenda = Agenda::findOrFail($id);

        // Cek apakah user berhak mengedit agenda ini
        if (auth()->user()->hasRole('guru') || auth()->user()->hasRole('walikelas')) {
            // Guru/Walikelas hanya bisa mengedit agenda untuk kelas yang diampu
            $guru = $this->getGuruFromUser();
            $guruKelas = $guru ? GuruMapel::where('guru_id', $guru->id)
                ->where('kelas_id', $agenda->kelas_id)
                ->exists() : false;

            if (!$guruKelas) {
                abort(403, 'Unauthorized action.');
            }
        } else {
            // Siswa hanya bisa mengedit agenda miliknya sendiri di kelasnya
            if ($agenda->users_id != auth()->id() || $agenda->kelas_id != auth()->user()->siswa->kelas_id) {
                abort(403, 'Unauthorized action.');
            }
        }

        $jampel = Jampel::all();

        // Get kelas yang diampu oleh guru atau kelas siswa
        $kelas = $this->getGuruKelas();

        return view('guru.agenda.edit', compact('agenda', 'jampel', 'kelas'));
    }

    public function update(Request $request, $id)
    {
        $agenda = Agenda::findOrFail($id);

        // Cek apakah user berhak mengupdate agenda ini
        if (auth()->user()->hasRole('guru') || auth()->user()->hasRole('walikelas')) {
            // Guru/Walikelas hanya bisa mengupdate agenda untuk kelas yang diampu
            $guru = $this->getGuruFromUser();
            $guruKelas = $guru ? GuruMapel::where('guru_id', $guru->id)
                ->where('kelas_id', $agenda->kelas_id)
                ->exists() : false;

            if (!$guruKelas) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', '❌ Anda tidak memiliki akses untuk mengupdate agenda ini.');
            }
        } else {
            // Siswa hanya bisa mengupdate agenda miliknya sendiri di kelasnya
            if ($agenda->users_id != auth()->id() || $agenda->kelas_id != auth()->user()->siswa->kelas_id) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', '❌ Anda tidak memiliki akses untuk mengupdate agenda ini.');
            }
        }

        // Validasi input
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'start_jampel_id' => 'required|exists:jam_pelajaran,id',
            'end_jampel_id' => 'required|exists:jam_pelajaran,id',
            'kelas_id' => 'required|exists:kelas,id',
            'mata_pelajaran' => 'required|string|max:255',
            'materi' => 'required|string|max:500',
            'kegiatan' => 'required|string',
            'catatan' => 'nullable|string',
        ]);

        // Jika pembuat adalah guru, validasi tanda tangan
        if ($agenda->pembuat === 'guru') {
            $request->validate([
                'tanda_tangan' => 'required|string|min:50',
            ]);
            $validated['tanda_tangan'] = $request->tanda_tangan;
            // Keep legacy column in sync if present
            $validated['sudah_ttd'] = true;
            $validated['ditandatangani_oleh'] = $agenda->guru_ttd_id ?? null;
        }

        try {
            $agenda->update($validated);

            return redirect()->route('agenda.index')->with('success', '✅ Agenda berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Agenda Update Error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'agenda_id' => $id
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', '❌ Gagal memperbarui agenda: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $agenda = Agenda::findOrFail($id);

        // Cek apakah user berhak menghapus agenda ini
        if (auth()->user()->hasRole('guru') || auth()->user()->hasRole('walikelas')) {
            // Guru/Walikelas hanya bisa menghapus agenda untuk kelas yang diampu
            $guru = $this->getGuruFromUser();
            $guruKelas = $guru ? GuruMapel::where('guru_id', $guru->id)
                ->where('kelas_id', $agenda->kelas_id)
                ->exists() : false;

            if (!$guruKelas) {
                return redirect()->back()
                    ->with('error', '❌ Anda tidak memiliki akses untuk menghapus agenda ini.');
            }
        } else {
            // Siswa hanya bisa menghapus agenda miliknya sendiri di kelasnya
            if ($agenda->users_id != auth()->id() || $agenda->kelas_id != auth()->user()->siswa->kelas_id) {
                return redirect()->back()
                    ->with('error', '❌ Anda tidak memiliki akses untuk menghapus agenda ini.');
            }
        }

        try {
            $agenda->delete();

            return redirect()->route('agenda.index')->with('success', '✅ Agenda berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error('Agenda Delete Error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'agenda_id' => $id
            ]);

            return redirect()->route('agenda.index')->with('error', '❌ Gagal menghapus agenda: ' . $e->getMessage());
        }
    }

    // Metode untuk menampilkan agenda yang perlu ditandatangani oleh guru
    public function needSignature()
    {
        // Hanya guru yang bisa mengakses
        if (!auth()->user()->hasRole('guru')) {
            abort(403, 'Unauthorized action.');
        }

        // Get kelas yang diampu oleh guru
        $kelasIds = GuruMapel::where('guru_id', auth()->user()->guru->id)
            ->pluck('kelas_id');

        // Ambil agenda yang belum ditandatangani untuk kelas yang diampu
        $agendas = Agenda::where('status_ttd', 'belum')
            ->whereIn('kelas_id', $kelasIds)
            ->with(['user', 'kelas', 'jampel'])
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('guru.agenda.need-signature', compact('agendas'));
    }

    public function signForm($id)
    {
        // Hanya guru dan walikelas yang bisa mengakses
        if (!auth()->user()->hasRole('guru') && !auth()->user()->hasRole('walikelas')) {
            abort(403, 'Unauthorized action.');
        }

        $agenda = Agenda::with(['user', 'kelas', 'jampel'])->findOrFail($id);

        // Cek apakah guru/walikelas berhak menandatangani agenda ini
        $guru = $this->getGuruFromUser();
        $guruKelas = $guru ? GuruMapel::where('guru_id', $guru->id)
            ->where('kelas_id', $agenda->kelas_id)
            ->exists() : false;

        if (!$guruKelas) {
            return redirect()->route('agenda.need-signature')
                ->with('error', 'Anda tidak memiliki akses untuk menandatangani agenda di kelas ini.');
        }

        // Pastikan agenda belum ditandatangani
        if ($agenda->status_ttd) {
            return redirect()->route('agenda.need-signature')
                ->with('error', 'Agenda ini sudah ditandatangani.');
        }

        // Ambil data siswa tidak hadir untuk agenda ini
        // Cari mata pelajaran berdasarkan nama di agenda
        $mapel = \App\Models\MataPelajaran::where('nama', $agenda->mata_pelajaran)->first();

        $siswaTidakHadir = collect();

        if ($mapel) {
            // Cari absensi untuk tanggal, kelas, dan mata pelajaran yang sama
            $absensi = \App\Models\Absensi::where('tanggal', $agenda->tanggal)
                ->where('kelas_id', $agenda->kelas_id)
                ->where('mapel_id', $mapel->id)
                ->first();

            if ($absensi) {
                // Jika ada absensi, ambil data siswa tidak hadir
                $siswaTidakHadir = \App\Models\DetailAbsensi::where('absensi_id', $absensi->id)
                    ->whereIn('status', ['alpha', 'sakit', 'izin'])
                    ->with('siswa')
                    ->get()
                    ->map(function ($item) {
                        return [
                            'id' => $item->siswa->id,
                            'nama' => $item->siswa->nama_siswa,
                            'nis' => $item->siswa->nis,
                            'status' => $item->status,
                        ];
                    });
            }
        }

        // Jika tidak ada data absensi atau tidak ada siswa tidak hadir, ambil semua siswa di kelas tersebut
        if ($siswaTidakHadir->isEmpty()) {
            $siswaTidakHadir = \App\Models\Siswa::where('kelas_id', $agenda->kelas_id)
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'nama' => $item->nama_siswa,
                        'nis' => $item->nis,
                        'status' => 'belum_input', // Status khusus untuk menandakan belum ada absensi
                    ];
                });
        }

        // Debug: Tampilkan jumlah siswa tidak hadir
        \Log::info('Siswa tidak hadir for agenda ' . $id, [
            'count' => $siswaTidakHadir->count(),
            'data' => $siswaTidakHadir->toArray()
        ]);

        return view('guru.agenda.sign-form', compact('agenda', 'siswaTidakHadir'));
    }

    public function sign(Request $request, $id)
    {
        // Hanya guru dan walikelas yang bisa mengakses
        if (!auth()->user()->hasRole('guru') && !auth()->user()->hasRole('walikelas')) {
            abort(403, 'Unauthorized action.');
        }

        $agenda = Agenda::findOrFail($id);

        // Cek apakah guru/walikelas berhak menandatangani agenda ini
        $guru = $this->getGuruFromUser();
        $guruKelas = $guru ? GuruMapel::where('guru_id', $guru->id)
            ->where('kelas_id', $agenda->kelas_id)
            ->exists() : false;

        if (!$guruKelas) {
            return redirect()->route('agenda.need-signature')
                ->with('error', 'Anda tidak memiliki akses untuk menandatangani agenda di kelas ini.');
        }

        // Pastikan agenda belum ditandatangani
        if ($agenda->status_ttd === 'sudah') {
            return redirect()->route('agenda.need-signature')
                ->with('error', 'Agenda ini sudah ditandatangani.');
        }

        // Validasi tanda tangan
        $request->validate([
            'tanda_tangan' => 'required|string|min:50',
        ]);

        try {
            // Debug log
            Log::info('Before signing agenda', [
                'agenda_id' => $agenda->id,
                'status_ttd_before' => $agenda->status_ttd,
                'guru_ttd_id_before' => $agenda->guru_ttd_id,
                'waktu_ttd_before' => $agenda->waktu_ttd,
                'signature_length' => strlen($request->tanda_tangan)
            ]);

            // Update agenda dengan tanda tangan
            $agenda->tanda_tangan = $request->tanda_tangan;
            $agenda->status_ttd = 'sudah'; // Pastikan ini diset sebagai 'sudah'
            $agenda->guru_ttd_id = auth()->id();
            $agenda->waktu_ttd = now();
            $agenda->save();

            // Debug log
            Log::info('After signing agenda', [
                'agenda_id' => $agenda->id,
                'status_ttd_after' => $agenda->status_ttd,
                'guru_ttd_id_after' => $agenda->guru_ttd_id,
                'waktu_ttd_after' => $agenda->waktu_ttd
            ]);

            return redirect()->route('agenda.index')
                ->with('success', 'Agenda berhasil ditandatangani!');
        } catch (\Exception $e) {
            Log::error('Agenda Sign Error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'agenda_id' => $id
            ]);

            return redirect()->back()
                ->with('error', ' Gagal menandatangani agenda: ' . $e->getMessage());
        }
    }

    // Metode untuk rekap agenda
    public function rekap(Request $request)
    {
        // Query dasar
        $query = Agenda::with(['user', 'guruTtd', 'kelas', 'jampel']);

        // Filter berdasarkan role
        if (auth()->user()->hasRole('guru') || auth()->user()->hasRole('walikelas')) {
            // Guru/Walikelas hanya bisa melihat agenda untuk kelas yang diampu
            $guru = $this->getGuruFromUser();
            if ($guru) {
                $kelasIds = GuruMapel::where('guru_id', $guru->id)
                    ->pluck('kelas_id');
                $query->whereIn('kelas_id', $kelasIds);
            }
        } elseif (auth()->user()->hasRole('siswa')) {
            // Siswa hanya bisa melihat agenda miliknya sendiri di kelasnya
            $query->where('users_id', auth()->id())
                ->where('kelas_id', auth()->user()->siswa->kelas_id);
        }

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('tanggal', [
                $request->tanggal_mulai,
                $request->tanggal_selesai
            ]);
        } elseif ($request->filled('tanggal')) {
            $query->where('tanggal', $request->tanggal);
        }

        // Filter berdasarkan kelas
        if ($request->filled('kelas_id')) {
            // Untuk guru/walikelas, pastikan kelas yang dipilih adalah kelas yang diampu
            if (auth()->user()->hasRole('guru') || auth()->user()->hasRole('walikelas')) {
                $guru = $this->getGuruFromUser();
                $kelasIds = $guru ? GuruMapel::where('guru_id', $guru->id)
                    ->pluck('kelas_id') : collect();

                if (!in_array($request->kelas_id, $kelasIds->toArray())) {
                    return redirect()->back()
                        ->with('error', '❌ Anda tidak memiliki akses ke kelas tersebut.');
                }
            }

            $query->where('kelas_id', $request->kelas_id);
        }

        // Filter berdasarkan mata pelajaran
        if ($request->filled('mata_pelajaran')) {
            $query->where('mata_pelajaran', 'like', '%' . $request->mata_pelajaran . '%');
        }

        // Filter berdasarkan status tanda tangan
        if ($request->filled('status_ttd')) {
            $query->where('status_ttd', $request->status_ttd);
        }

        // Urutkan dan paginasi
        $agendas = $query->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Data untuk filter
        if (auth()->user()->hasRole('guru') || auth()->user()->hasRole('walikelas')) {
            $guru = $this->getGuruFromUser();
            $kelas = $guru ? Kelas::whereIn('id', GuruMapel::where('guru_id', $guru->id)->pluck('kelas_id'))->get() : collect();
        } else {
            $kelas = Kelas::where('id', auth()->user()->siswa->kelas_id)->get();
        }

        return view('guru.agenda.rekap', compact('agendas', 'kelas'));
    }

    public function exportPdf(Request $request)
    {
        // Query dasar
        $query = Agenda::with(['user', 'guruTtd', 'kelas', 'jampel']);

        // Filter berdasarkan role
        if (auth()->user()->hasRole('guru') || auth()->user()->hasRole('walikelas')) {
            // Guru/Walikelas hanya bisa melihat agenda untuk kelas yang diampu
            $guru = $this->getGuruFromUser();
            if ($guru) {
                $kelasIds = GuruMapel::where('guru_id', $guru->id)
                    ->pluck('kelas_id');
                $query->whereIn('kelas_id', $kelasIds);
            }
        } elseif (auth()->user()->hasRole('siswa')) {
            // Siswa hanya bisa melihat agenda miliknya sendiri di kelasnya
            $query->where('users_id', auth()->id())
                ->where('kelas_id', auth()->user()->siswa->kelas_id);
        }

        // Terapkan filter yang sama dengan method rekap
        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('tanggal', [
                $request->tanggal_mulai,
                $request->tanggal_selesai
            ]);
        } elseif ($request->filled('tanggal')) {
            $query->where('tanggal', $request->tanggal);
        }

        if ($request->filled('kelas_id')) {
            if (auth()->user()->hasRole('guru') || auth()->user()->hasRole('walikelas')) {
                $guru = $this->getGuruFromUser();
                $kelasIds = $guru ? GuruMapel::where('guru_id', $guru->id)
                    ->pluck('kelas_id') : collect();

                if (!in_array($request->kelas_id, $kelasIds->toArray())) {
                    return redirect()->back()
                        ->with('error', '❌ Anda tidak memiliki akses ke kelas tersebut.');
                }
            }
            $query->where('kelas_id', $request->kelas_id);
        }

        if ($request->filled('mata_pelajaran')) {
            $query->where('mata_pelajaran', 'like', '%' . $request->mata_pelajaran . '%');
        }

        if ($request->filled('status_ttd')) {
            $query->where('status_ttd', $request->status_ttd);
        }

        $agendas = $query->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        $pdf = PDF::loadView('guru.agenda.export-pdf', compact('agendas', 'request'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('rekap-agenda-' . date('Y-m-d') . '.pdf');
    }


  public function getDetail($id)
{
    try {
        $agenda = Agenda::with(['kelas', 'jampel', 'user', 'guruTtd'])->findOrFail($id);

        // Cek apakah user berhak melihat agenda ini
        if (auth()->user()->hasRole('guru')) {
            // Guru hanya bisa melihat agenda untuk kelas yang diampu
            $guruKelas = GuruMapel::where('guru_id', auth()->user()->guru->id)
                ->where('kelas_id', $agenda->kelas_id)
                ->exists();

            if (!$guruKelas) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
        } else {
            // Siswa hanya bisa melihat agenda miliknya sendiri di kelasnya
            if ($agenda->users_id != auth()->id() || $agenda->kelas_id != auth()->user()->siswa->kelas_id) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
        }

        // Ambil tanggal hari ini
        $today = now()->format('Y-m-d');

        // Ambil data siswa tidak hadir untuk kelas ini hari ini
        $siswaTidakHadir = \App\Models\DetailAbsensi::whereHas('absensi', function($query) use ($agenda, $today) {
                $query->where('tanggal', $today)
                      ->where('kelas_id', $agenda->kelas_id);
            })
            ->whereIn('status', ['sakit', 'izin', 'alpha'])
            ->with(['siswa', 'absensi'])
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->siswa->id,
                    'nama' => $item->siswa->nama_siswa,
                    'nis' => $item->siswa->nis,
                    'status' => $item->status,
                    'keterangan' => $item->keterangan ?? '-',
                    'mapel' => $item->absensi->mapel->nama ?? '-'
                ];
            });

        // Jika tidak ada data absensi untuk hari ini, ambil semua siswa di kelas tersebut
        if ($siswaTidakHadir->isEmpty()) {
            $siswaTidakHadir = \App\Models\Siswa::where('kelas_id', $agenda->kelas_id)
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'nama' => $item->nama_siswa,
                        'nis' => $item->nis,
                        'status' => 'belum_input', // Status khusus untuk menandakan belum ada absensi
                        'keterangan' => '-',
                        'mapel' => '-'
                    ];
                });
        }

        return response()->json([
            'id' => $agenda->id,
            'tanggal' => \Carbon\Carbon::parse($agenda->tanggal)->format('d/m/Y'),
            'jam' => $agenda->jampel->nama_jam,
            'kelas' => $agenda->kelas->nama_kelas,
            'kelas_id' => $agenda->kelas_id,
            'mata_pelajaran' => $agenda->mata_pelajaran,
            'materi' => $agenda->materi,
            'kegiatan' => $agenda->kegiatan,
            'catatan' => $agenda->catatan ?? 'Tidak ada catatan',
            'tanda_tangan' => $agenda->tanda_tangan ? asset('storage/' . $agenda->tanda_tangan) : '',
            'created_at' => $agenda->created_at->format('d/m/Y H:i'),
            'siswa_tidak_hadir' => $siswaTidakHadir,
            'ada_absensi_hari_ini' => \App\Models\Absensi::where('tanggal', $today)
                ->where('kelas_id', $agenda->kelas_id)
                ->exists()
        ]);
    } catch (\Exception $e) {
        return response()->json(['message' => $e->getMessage()], 500);
    }
}

    // Implementasi method exportExcel
    public function exportExcel(Request $request)
    {
        // Query dasar
        $query = Agenda::with(['user', 'guruTtd', 'kelas', 'jampel']);

        // Filter berdasarkan role
        if (auth()->user()->hasRole('guru') || auth()->user()->hasRole('walikelas')) {
            // Guru/Walikelas hanya bisa melihat agenda untuk kelas yang diampu
            $guru = $this->getGuruFromUser();
            if ($guru) {
                $kelasIds = GuruMapel::where('guru_id', $guru->id)
                    ->pluck('kelas_id');
                $query->whereIn('kelas_id', $kelasIds);
            }
        } elseif (auth()->user()->hasRole('siswa')) {
            // Siswa hanya bisa melihat agenda miliknya sendiri di kelasnya
            $query->where('users_id', auth()->id())
                ->where('kelas_id', auth()->user()->siswa->kelas_id);
        }

        // Terapkan filter yang sama dengan method rekap
        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('tanggal', [
                $request->tanggal_mulai,
                $request->tanggal_selesai
            ]);
        } elseif ($request->filled('tanggal')) {
            $query->where('tanggal', $request->tanggal);
        }

        if ($request->filled('kelas_id')) {
            if (auth()->user()->hasRole('guru') || auth()->user()->hasRole('walikelas')) {
                $guru = $this->getGuruFromUser();
                $kelasIds = $guru ? GuruMapel::where('guru_id', $guru->id)
                    ->pluck('kelas_id') : collect();

                if (!in_array($request->kelas_id, $kelasIds->toArray())) {
                    return redirect()->back()
                        ->with('error', '❌ Anda tidak memiliki akses ke kelas tersebut.');
                }
            }
            $query->where('kelas_id', $request->kelas_id);
        }

        if ($request->filled('mata_pelajaran')) {
            $query->where('mata_pelajaran', 'like', '%' . $request->mata_pelajaran . '%');
        }

        if ($request->filled('status_ttd')) {
            $query->where('status_ttd', $request->status_ttd);
        }

        $agendas = $query->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return Excel::download(new AgendaExport($agendas), 'rekap-agenda-' . date('Y-m-d') . '.xlsx');
    }




    public function getMapelByKelas($kelasId)
    {
        try {
            if (auth()->user()->hasRole('guru')) {
                // Guru hanya bisa melihat mata pelajaran yang diampu di kelas tertentu
                $guruMapels = GuruMapel::where('guru_id', auth()->user()->guru->id)
                    ->where('kelas_id', $kelasId)
                    ->with(['mapel', 'guru'])
                    ->get();

                // Group by mapel dan return semua guru per mapel
                $mapels = $guruMapels->groupBy('mapel_id')->map(function ($group) {
                    $mapel = $group->first()->mapel;
                    $gurus = $group->map(function ($item) {
                        return [
                            'guru_id' => $item->guru->id,
                            'guru_nama' => $item->guru->nama
                        ];
                    })->values();

                    return [
                        'id' => $mapel->id,
                        'nama' => $mapel->nama,
                        'kode' => $mapel->kode,
                        'kelompok' => $mapel->kelompok,
                        'gurus' => $gurus,
                        'guru_count' => count($gurus)
                    ];
                })->values();
            } else {
                // Siswa bisa melihat semua mata pelajaran di kelasnya
                if ($kelasId != auth()->user()->siswa->kelas_id) {
                    return response()->json(['error' => 'Unauthorized'], 403);
                }

                // Untuk siswa, ambil semua mata pelajaran dengan guru yang mengajar
                $guruMapels = GuruMapel::where('kelas_id', $kelasId)
                    ->with(['mapel', 'guru'])
                    ->get();

                // Group by mapel dan return semua guru per mapel
                $mapels = $guruMapels->groupBy('mapel_id')->map(function ($group) {
                    $mapel = $group->first()->mapel;
                    $gurus = $group->map(function ($item) {
                        return [
                            'guru_id' => $item->guru->id,
                            'guru_nama' => $item->guru->nama
                        ];
                    })->values();

                    return [
                        'id' => $mapel->id,
                        'nama' => $mapel->nama,
                        'kode' => $mapel->kode,
                        'kelompok' => $mapel->kelompok,
                        'gurus' => $gurus,
                        'guru_count' => count($gurus)
                    ];
                })->values();
            }

            return response()->json($mapels);
        } catch (\Exception $e) {
            \Log::error('Error getting mapel by kelas', [
                'kelas_id' => $kelasId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Tambahkan method ini di AgendaController
    private function getSiswaTidakHadir()
    {
        // Untuk role guru dan walikelas
        if (!auth()->user()->hasRole('guru') && !auth()->user()->hasRole('walikelas')) {
            return collect();
        }

        // Ambil kelas yang diampu oleh guru/walikelas
        $guru = $this->getGuruFromUser();
        if (!$guru) {
            return collect();
        }

        $kelasIds = GuruMapel::where('guru_id', $guru->id)
            ->pluck('kelas_id');

        // Ambil tanggal hari ini
        $today = now()->format('Y-m-d');

        // Ambil data siswa yang tidak hadir (status alpha) hari ini
        $siswaTidakHadir = \App\Models\DetailAbsensi::whereHas('absensi', function ($query) use ($today, $kelasIds) {
            $query->where('tanggal', $today)
                ->whereIn('kelas_id', $kelasIds);
        })
            ->where('status', 'alpha')
            ->with(['siswa', 'absensi.kelas', 'absensi.mapel'])
            ->get()
            ->groupBy('absensi.kelas_id')
            ->map(function ($items, $kelasId) {
                return [
                    'kelas' => $items->first()->absensi->kelas,
                    'siswa' => $items->map(function ($item) {
                        return [
                            'id' => $item->siswa->id,
                            'nama' => $item->siswa->nama_siswa,
                            'nis' => $item->siswa->nis,
                            'mapel' => $item->absensi->mapel->nama,
                            'jam' => $item->absensi->jampel->nama_jam
                        ];
                    })
                ];
            });

        return $siswaTidakHadir;
    }
    // API: Get all jampel
    public function getJampel()
    {
        $jampel = Jampel::all();
        return response()->json($jampel);
    }

    // API: Get agendas by date
    public function getAgendaByDate($date)
    {
        $guru = Guru::where('users_id', auth()->id())->first();
        if (!$guru) {
            return response()->json([]);
        }

        $agendas = Agenda::where('tanggal', $date)
            ->whereHas('guruMapel', function ($q) use ($guru) {
                $q->where('guru_id', $guru->id);
            })
            ->with(['kelas', 'mapel'])
            ->get()
            ->map(fn($a) => [
                'id' => $a->id,
                'kelas_id' => $a->kelas_id,
                'mapel_id' => $a->mapel_id ?? null,
                'materi' => $a->materi ?? $a->mata_pelajaran,
                'kegiatan' => $a->kegiatan,
                'catatan' => $a->catatan,
                'kelas_name' => $a->kelas->nama_kelas,
                'mapel_name' => $a->mapel->nama ?? $a->mata_pelajaran
            ]);

        return response()->json($agendas);
    }

    // API: Get single agenda
    public function getAgenda($id)
    {
        $agenda = Agenda::findOrFail($id);
        return response()->json($agenda);
    }

    // API: Store agenda
    public function storeApi(Request $request)
    {
        $validated = $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mata_pelajaran,id',
            'jampel_id' => 'required|exists:jam_pelajaran,id',
            'tanggal' => 'required|date',
            'materi' => 'required|string',
            'kegiatan' => 'required|string',
            'catatan' => 'nullable|string'
        ]);

        $guru = Guru::where('users_id', auth()->id())->first();

        // Check if guru teaches this class-mapel
        $guruMapel = GuruMapel::where('guru_id', $guru->id)
            ->where('kelas_id', $validated['kelas_id'])
            ->where('mapel_id', $validated['mapel_id'])
            ->firstOrFail();

        $mapel = MataPelajaran::find($validated['mapel_id']);

        $agenda = Agenda::create([
            'kelas_id' => $validated['kelas_id'],
            'jampel_id' => $validated['jampel_id'] ?? 1,
            'mata_pelajaran' => $mapel->nama,
            'materi' => $validated['materi'],
            'kegiatan' => $validated['kegiatan'],
            'catatan' => $validated['catatan'],
            'tanggal' => $validated['tanggal'],
            'users_id' => auth()->id(),
            'pembuat' => 'guru',
            'status_ttd' => 'belum',
            'sudah_ttd' => false
        ]);

        return response()->json(['success' => true, 'data' => $agenda]);
    }

    // API: Update agenda
    public function updateApi(Request $request, $id)
    {
        $agenda = Agenda::findOrFail($id);

        $validated = $request->validate([
            'materi' => 'required|string',
            'kegiatan' => 'required|string',
            'catatan' => 'nullable|string'
        ]);

        $agenda->update($validated);

        return response()->json(['success' => true, 'data' => $agenda]);
    }

    // API: Delete agenda
    public function destroyApi($id)
    {
        $agenda = Agenda::findOrFail($id);
        $agenda->delete();

        return response()->json(['success' => true]);
    }
    // API: Get my schedules (untuk guru view jadwal mereka)
    public function getMySchedules()
    {
        try {
            $guru = Guru::where('users_id', auth()->id())->first();

            if (!$guru) {
                return response()->json([]);
            }

            $schedules = GuruMapel::where('guru_id', $guru->id)
                ->with(['kelas', 'mapel', 'startJampel', 'endJampel'])
                ->get()
                ->map(function($item) {
                    // Ambil info jam mulai dan selesai
                    $startJampel = $item->startJampel;
                    $endJampel = $item->endJampel;

                    // Buat display name untuk jampel
                    $jampelDisplay = '';
                    if ($startJampel && $endJampel) {
                        $jampelDisplay = "Jam {$startJampel->jam_ke} - Jam {$endJampel->jam_ke}";
                    } elseif ($startJampel) {
                        $jampelDisplay = "Jam {$startJampel->jam_ke}";
                    }

                    // Cek apakah ada absensi untuk hari ini
                    $today = now()->format('Y-m-d');
                    $absensiHariIni = \App\Models\Absensi::where('kelas_id', $item->kelas_id)
                        ->where('mapel_id', $item->mapel_id)
                        ->where('tanggal', $today)
                        ->first();

                    // Hitung jumlah siswa dan absensi jika ada
                    $totalSiswa = 0;
                    $siswaTidakHadir = 0;

                    if ($absensiHariIni) {
                        // Ambil total siswa di kelas
                        $totalSiswa = \App\Models\Siswa::where('kelas_id', $item->kelas_id)->count();

                        // Hitung siswa tidak hadir (alpha, sakit, izin)
                        $siswaTidakHadir = \App\Models\DetailAbsensi::where('absensi_id', $absensiHariIni->id)
                            ->whereIn('status', ['alpha', 'sakit', 'izin'])
                            ->count();
                    }

                    return [
                        'id' => $item->id,
                        'kelas_id' => $item->kelas_id,
                        'kelas_name' => $item->kelas?->nama_kelas ?? 'Unknown',
                        'mapel_id' => $item->mapel_id,
                        'mapel_name' => $item->mapel?->nama ?? 'Unknown',
                        'jampel_name' => $jampelDisplay,
                        'start_jampel_id' => $item->start_jampel_id,
                        'end_jampel_id' => $item->end_jampel_id,
                        'hari_tipe' => $item->hari_tipe,
                        // Data absensi
                        'has_absensi_today' => $absensiHariIni ? true : false,
                        'total_siswa' => $totalSiswa,
                        'siswa_tidak_hadir' => $siswaTidakHadir,
                        'siswa_hadir' => $totalSiswa - $siswaTidakHadir,
                        'absensi_id' => $absensiHariIni?->id,
                    ];
                });

            return response()->json($schedules);
        } catch (\Exception $e) {
            \Log::error('Error in getMySchedules', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Get schedule details for agenda input (validate schedule data)
     */
    public function validateScheduleForAgenda($kelasId, $mapelId, $startJampelId, $endJampelId)
    {
        try {
            $guru = Guru::where('users_id', auth()->id())->first();

            if (!$guru) {
                return response()->json([
                    'valid' => false,
                    'message' => 'Guru tidak ditemukan'
                ], 404);
            }

            // Cari jadwal yang sesuai dengan parameter
            $schedule = GuruMapel::where('guru_id', $guru->id)
                ->where('kelas_id', $kelasId)
                ->where('mapel_id', $mapelId)
                ->with(['kelas', 'mapel', 'startJampel', 'endJampel'])
                ->first();

            if (!$schedule) {
                return response()->json([
                    'valid' => false,
                    'message' => 'Jadwal tidak sesuai dengan yang Anda ajar'
                ], 404);
            }

            // Validasi jam pelajaran
            if ($schedule->start_jampel_id != $startJampelId || $schedule->end_jampel_id != $endJampelId) {
                return response()->json([
                    'valid' => false,
                    'message' => 'Jam pelajaran tidak sesuai dengan jadwal admin',
                    'correct_schedule' => [
                        'start_jampel_id' => $schedule->start_jampel_id,
                        'end_jampel_id' => $schedule->end_jampel_id,
                        'start_jampel_name' => $schedule->startJampel?->nama_jam,
                        'end_jampel_name' => $schedule->endJampel?->nama_jam,
                    ]
                ], 422);
            }

            return response()->json([
                'valid' => true,
                'message' => 'Jadwal sesuai',
                'schedule' => [
                    'id' => $schedule->id,
                    'kelas_id' => $schedule->kelas_id,
                    'kelas_name' => $schedule->kelas?->nama_kelas,
                    'mapel_id' => $schedule->mapel_id,
                    'mapel_name' => $schedule->mapel?->nama,
                    'start_jampel_id' => $schedule->start_jampel_id,
                    'end_jampel_id' => $schedule->end_jampel_id,
                    'hari_tipe' => $schedule->hari_tipe,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'valid' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
