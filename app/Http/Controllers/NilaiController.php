<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NilaiController extends Controller
{
    public function index()
    {
        $user_id = Auth::id();
        $guru = Guru::where('users_id', $user_id)->first();

        if (!$guru) {
            return redirect()->back()->with('error', 'Data guru tidak ditemukan');
        }

        $nilai = Nilai::where('guru_id', $guru->id)
            ->with(['siswa', 'mapel', 'kelas'])
            ->latest()
            ->get();

        return view('nilai.index', compact('nilai'));
    }

    public function create()
    {
        $user_id = Auth::id();
        $guru = Guru::where('users_id', $user_id)->first();

        if (!$guru) {
            return redirect()->back()->with('error', 'Data guru tidak ditemukan');
        }

        // Ambil kelas dan mapel yang diajar oleh guru ini
        $kelas = Kelas::whereHas('guruMapel', function ($query) use ($guru) {
            $query->where('guru_id', $guru->id);
        })->get();

        $mapel = MataPelajaran::whereHas('guruMapel', function ($query) use ($guru) {
            $query->where('guru_id', $guru->id);
        })->get();

        $jenisNilai = ['tugas', 'uts', 'uas'];

        return view('nilai.create', compact('kelas', 'mapel', 'jenisNilai'));
    }

    public function store(Request $request)
    {
        // Support both single and batch submission
        $user_id = Auth::id();
        $guru = Guru::where('users_id', $user_id)->first();

        if (!$guru) {
            return response()->json([
                'success' => false,
                'message' => 'Data guru tidak ditemukan'
            ], 404);
        }

        // Batch mode: grades[] array
        if ($request->has('grades') && is_array($request->grades)) {
            $request->validate([
                'kelas_id' => 'required|exists:kelas,id',
                'mapel_id' => 'required|exists:mata_pelajaran,id',
                // accept both legacy 'tugas_harian' and canonical 'tugas' (DB enum uses 'tugas')
                'jenis' => 'required|in:tugas,tugas_harian,uts,uas',
                'grades' => 'required|array|min:1',
                'grades.*.siswa_id' => 'required|exists:siswa,id',
                'grades.*.nilai' => 'nullable|integer|min:0|max:100',
                'grades.*.keterangan' => 'nullable|string',
            ]);

            $created = 0;
            foreach ($request->grades as $g) {
                // Skip rows where nilai is not provided (allow partial input)
                if (!isset($g['nilai']) || $g['nilai'] === null || $g['nilai'] === '') {
                    continue;
                }

                // normalize jenis to DB enum value
                $jenisToStore = ($request->jenis === 'tugas_harian') ? 'tugas' : $request->jenis;

                Nilai::create([
                    'siswa_id' => $g['siswa_id'],
                    'guru_id' => $guru->id,
                    'mapel_id' => $request->mapel_id,
                    'kelas_id' => $request->kelas_id,
                    'jenis' => $jenisToStore,
                    'nilai' => $g['nilai'],
                    'keterangan' => $g['keterangan'] ?? null,
                ]);
                $created++;
            }

            if ($created === 0) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Tidak ada nilai yang diinput. Silakan isi minimal satu nilai.'
                    ], 422);
                }

                return redirect()->back()->with('warning', 'Tidak ada nilai yang diinput. Silakan isi minimal satu nilai.');
            }

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => "Berhasil menyimpan {$created} nilai.",
                    'saved' => $created,
                ]);
            }

            return redirect()->route('nilai.index')->with('success', "Berhasil menyimpan {$created} nilai.");
        }

        // Single record fallback (API compatibility)
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mata_pelajaran,id',
            'jenis' => 'required|in:tugas,tugas_harian,uts,uas',
            'nilai' => 'required|integer|min:0|max:100',
            'keterangan' => 'nullable|string',
        ]);

        $jenisToStore = ($request->jenis === 'tugas_harian') ? 'tugas' : $request->jenis;

        Nilai::create([
            'siswa_id' => $request->siswa_id,
            'guru_id' => $guru->id,
            'mapel_id' => $request->mapel_id,
            'kelas_id' => $request->kelas_id,
            'jenis' => $jenisToStore,
            'nilai' => $request->nilai,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('nilai.index')->with('success', 'Data nilai berhasil disimpan!');
    }

    public function show($id)
    {
        $nilai = Nilai::with(['siswa', 'guru', 'mapel', 'kelas'])->findOrFail($id);
        return view('nilai.show', compact('nilai'));
    }

    public function edit($id)
    {
        $nilai = Nilai::findOrFail($id);

        $user_id = Auth::id();
        $guru = Guru::where('users_id', $user_id)->first();

        if (!$guru) {
            return redirect()->back()->with('error', 'Data guru tidak ditemukan');
        }

        // Ambil kelas dan mapel yang diajar oleh guru ini
        $kelas = Kelas::whereHas('guruMapel', function ($query) use ($guru) {
            $query->where('guru_id', $guru->id);
        })->get();

        $mapel = MataPelajaran::whereHas('guruMapel', function ($query) use ($guru) {
            $query->where('guru_id', $guru->id);
        })->get();

        $jenisNilai = ['tugas', 'uts', 'uas'];

        return view('nilai.edit', compact('nilai', 'kelas', 'mapel', 'jenisNilai'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mata_pelajaran,id',
            'jenis' => 'required|in:tugas,tugas_harian,uts,uas',
            'nilai' => 'required|integer|min:0|max:100',
            'keterangan' => 'nullable|string',
        ]);

        $jenisToStore = ($request->jenis === 'tugas_harian') ? 'tugas' : $request->jenis;

        $nilai = Nilai::findOrFail($id);
        $nilai->update([
            'kelas_id' => $request->kelas_id,
            'mapel_id' => $request->mapel_id,
            'jenis' => $jenisToStore,
            'nilai' => $request->nilai,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('nilai.index')
            ->with('success', 'Data nilai berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $nilai = Nilai::findOrFail($id);
        $nilai->delete();

        return redirect()->route('nilai.index')
            ->with('success', 'Data nilai berhasil dihapus!');
    }
}
