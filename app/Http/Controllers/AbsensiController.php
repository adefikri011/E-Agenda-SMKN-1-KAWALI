<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Jampel;
use App\Models\Absensi;
use App\Models\DetailAbsensi;
use App\Models\Siswa;
use App\Models\GuruMapel;
use App\Models\Guru;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{

    public function index()
    {
        $user_id = Auth::id();

        // Cari guru berdasarkan users_id yang login
        $guru = Guru::where('users_id', $user_id)->first();

        if (!$guru) {
            return redirect()->back()->with('error', 'Data guru tidak ditemukan');
        }

        // Ambil guru_mapel yang diajar oleh guru ini
        $guruMapel = GuruMapel::where('guru_id', $guru->id)->get();

        $kelas_ids = $guruMapel->pluck('kelas_id')->unique();
        $mapel_ids = $guruMapel->pluck('mapel_id')->unique();

        $kelas = Kelas::whereIn('id', $kelas_ids)->get();
        $mapel = MataPelajaran::whereIn('id', $mapel_ids)->get();

        return view('absensi.index', compact(
            'kelas',
            'mapel'
        ));
    }

    public function getSiswaByKelas($kelas_id)
    {
        try {
            // Verify the class exists and belongs to the current teacher
            $user_id = Auth::id();
            $guru = Guru::where('users_id', $user_id)->first();

            if (!$guru) {
                return response()->json([
                    'error' => 'Data guru tidak ditemukan'
                ], 404);
            }

            // Check if this teacher teaches this class
            $teachesClass = GuruMapel::where('guru_id', $guru->id)
                ->where('kelas_id', $kelas_id)
                ->exists();

            if (!$teachesClass) {
                return response()->json([
                    'error' => 'Anda tidak mengajar kelas ini'
                ], 403);
            }

            $siswa = Siswa::where('kelas_id', $kelas_id)->get();
            return response()->json($siswa);
        } catch (\Exception $e) {
            \Log::error('Error getting students: ' . $e->getMessage());
            return response()->json([
                'error' => 'Gagal memuat data siswa: ' . $e->getMessage()
            ], 500);
        }
    }

        public function create(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mata_pelajaran,id',
            'jampel_id' => 'required|exists:jam_pelajaran,id',
            'tanggal' => 'required|date',
            'pertemuan' => 'required|integer|min:0',
        ]);

        $kelas = Kelas::findOrFail($request->kelas_id);
        $mapel = MataPelajaran::findOrFail($request->mapel_id);
        $jampel = Jampel::findOrFail($request->jampel_id);
        $tanggal = Carbon::parse($request->tanggal)->format('Y-m-d');
        $pertemuan = $request->pertemuan;
        $siswa = Siswa::where('kelas_id', $request->kelas_id)->get();

        // Tentukan jam berdasarkan jampel
        $jam = '00:00';
        if (!empty($jampel->rentang_waktu)) {
            $jam = $jampel->rentang_waktu;
        } else {
            $startTime = $jampel->jam_mulai ? (is_string($jampel->jam_mulai) ? $jampel->jam_mulai : $jampel->jam_mulai->format('H:i')) : null;
            $endTime = $jampel->jam_selesai ? (is_string($jampel->jam_selesai) ? $jampel->jam_selesai : $jampel->jam_selesai->format('H:i')) : null;
            if ($startTime && $endTime) {
                $jam = $startTime . ' - ' . $endTime;
            } elseif ($startTime) {
                $jam = $startTime;
            }
        }

        // --- PERBAIKAN DI SINI (Bagian Create) ---

        // Ambil data guru yang sedang login
        $guru = Guru::where('users_id', Auth::id())->first();

        // Cek apakah absensi sudah ada
        // PENTING: 'guru_id' di sini harus pakai $guru->users_id agar cocok dengan foreign key ke tabel users
        $guru_id_for_db = $guru ? $guru->users_id : Auth::id();

        $existingAbsensi = Absensi::where([
            'kelas_id' => $request->kelas_id,
            'mapel_id' => $request->mapel_id,
            'jampel_id' => $request->jampel_id,
            'tanggal' => $tanggal,
            'guru_id' => $guru_id_for_db, // Menggunakan users_id
        ])->first();

        // ------------------------------------------

        if ($existingAbsensi) {
            return redirect()->route('absensi.show', $existingAbsensi->id)
                ->with('info', 'Absensi untuk kelas, mapel, dan tanggal tersebut sudah ada. Menampilkan data yang sudah ada.');
        }

        return view('absensi.create', compact('kelas', 'mapel', 'jampel', 'tanggal', 'siswa', 'pertemuan', 'jam'));
    }


    public function store(Request $request)
    {
        try {
            // Validate the request - support both jampel_id and start/end jampel_id
            $validated = $request->validate([
                'kelas_id' => 'required|exists:kelas,id',
                'mapel_id' => 'required|exists:mata_pelajaran,id',
                'jampel_id' => 'nullable|integer',
                'start_jampel_id' => 'nullable|integer',
                'end_jampel_id' => 'nullable|integer',
                'tanggal' => 'required|date',
                'pertemuan' => 'required|integer|min:0',
                'absensi.*.siswa_id' => 'required|exists:siswa,id',
                'absensi.*.status' => 'required|in:hadir,izin,sakit,alpha',
            ]);

            // Prioritize start/end jampel, fallback to jampel_id
            $startJampelId = $validated['start_jampel_id'] ?? null;
            $endJampelId = $validated['end_jampel_id'] ?? null;

            // Jika hanya jampel_id yang ada
            if (!$startJampelId && !$endJampelId && !empty($validated['jampel_id'])) {
                $startJampelId = $validated['jampel_id'];
                $endJampelId = $validated['jampel_id'];
            }

            // Jika semua kosong, gunakan default
            if (!$startJampelId && !$endJampelId) {
                $defaultJampel = \App\Models\Jampel::first();
                $startJampelId = $defaultJampel ? $defaultJampel->id : 1;
                $endJampelId = $defaultJampel ? $defaultJampel->id : 1;
            }

            // For backward compatibility, set jampel_id sebagai start jampel
            $validated['jampel_id'] = $startJampelId;
            $validated['start_jampel_id'] = $startJampelId;
            $validated['end_jampel_id'] = $endJampelId;

            $tanggal = Carbon::parse($validated['tanggal'])->format('Y-m-d');

            // Ensure pertemuan is at least 1 (avoid saving 0)
            $pertemuan = isset($validated['pertemuan']) ? intval($validated['pertemuan']) : 1;
            if ($pertemuan <= 0) {
                $pertemuan = 1;
            }
            $validated['pertemuan'] = $pertemuan;

            // Get the current user's associated guru
            $user_id = Auth::id();
            $guru = Guru::where('users_id', $user_id)->first();

            if (!$guru) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data guru tidak ditemukan'
                ], 404);
            }

            // Verify teacher teaches this class and subject
            $teachesClass = GuruMapel::where('guru_id', $guru->id)
                ->where('kelas_id', $validated['kelas_id'])
                ->where('mapel_id', $validated['mapel_id'])
                ->exists();

            if (!$teachesClass) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak mengajar mata pelajaran ini di kelas tersebut'
                ], 403);
            }

            // --- PERBAIKAN DI SINI (Bagian Store - Cek Duplikasi) ---

            // Tentukan ID Guru yang akan disimpan ke DB (Harus users_id)
            $guru_id_for_db = $guru->users_id;

            // Check for existing attendance record
            $existingAbsensi = Absensi::where([
                'kelas_id' => $validated['kelas_id'],
                'mapel_id' => $validated['mapel_id'],
                'jampel_id' => $validated['jampel_id'],
                'tanggal' => $tanggal,
                'guru_id' => $guru_id_for_db, // PENTING: Ganti $guru->id dengan $guru_id_for_db
            ])->first();

            // --------------------------------------------------------

            if ($existingAbsensi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Absensi untuk kelas, mapel, dan tanggal tersebut sudah ada.'
                ], 409); // 409 Conflict status
            }

            // Determine jam value based on provided start/end jampel or single jampel
            $jamValue = '00:00';
            // Prefer start/end range if provided
            if (!empty($validated['start_jampel_id']) && !empty($validated['end_jampel_id'])) {
                $startJ = Jampel::find($validated['start_jampel_id']);
                $endJ = Jampel::find($validated['end_jampel_id']);
                if ($startJ && $endJ) {
                    // Use jam_mulai of start and jam_selesai of end (formatted H:i)
                    $startTime = $startJ->jam_mulai ? (is_string($startJ->jam_mulai) ? $startJ->jam_mulai : $startJ->jam_mulai->format('H:i')) : null;
                    $endTime = $endJ->jam_selesai ? (is_string($endJ->jam_selesai) ? $endJ->jam_selesai : $endJ->jam_selesai->format('H:i')) : null;
                    if ($startTime && $endTime) {
                        $jamValue = $startTime . ' - ' . $endTime;
                    } elseif ($startJ->rentang_waktu) {
                        $jamValue = $startJ->rentang_waktu;
                    }
                }
            }

            // Fallback to single jampel if range not available
            if ($jamValue === '00:00' && !empty($validated['jampel_id'])) {
                $singleJ = Jampel::find($validated['jampel_id']);
                if ($singleJ) {
                    if (!empty($singleJ->rentang_waktu)) {
                        $jamValue = $singleJ->rentang_waktu;
                    } else {
                        $startTime = $singleJ->jam_mulai ? (is_string($singleJ->jam_mulai) ? $singleJ->jam_mulai : $singleJ->jam_mulai->format('H:i')) : null;
                        $endTime = $singleJ->jam_selesai ? (is_string($singleJ->jam_selesai) ? $singleJ->jam_selesai : $singleJ->jam_selesai->format('H:i')) : null;
                        if ($startTime && $endTime) {
                            $jamValue = $startTime . ' - ' . $endTime;
                        } elseif ($startTime) {
                            $jamValue = $startTime;
                        }
                    }
                }
            }

            // Use database transaction
            \DB::beginTransaction();

            try {
                // Create main attendance record
                // --- PERBAIKAN DI SINI (Bagian Store - Simpan Data) ---
                $absensi = Absensi::create([
                    'kelas_id' => $validated['kelas_id'],
                    'mapel_id' => $validated['mapel_id'],
                    'jampel_id' => $validated['jampel_id'],
                    'start_jampel_id' => $validated['start_jampel_id'],
                    'end_jampel_id' => $validated['end_jampel_id'],
                    'tanggal' => $tanggal,
                    'guru_id' => $guru_id_for_db, // PENTING: Ganti $guru->id dengan $guru_id_for_db
                    'pertemuan' => $validated['pertemuan'],
                    'jam' => $jamValue, // Use default if jampel not found
                ]);
                // ----------------------------------------------------

                // Save attendance details for each student
                foreach ($validated['absensi'] as $item) {
                    DetailAbsensi::create([
                        'absensi_id' => $absensi->id,
                        'siswa_id' => $item['siswa_id'],
                        'status' => $item['status'],
                    ]);
                }

                \DB::commit();

                // If request expects JSON (API), return JSON response
                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Data absensi berhasil disimpan!',
                        'data' => [
                            'id' => $absensi->id,
                            'tanggal' => $absensi->tanggal,
                        ]
                    ], 201);
                }

                // For web requests, redirect to absensi index
                return redirect()->route('absensi.index')
                    ->with('success', 'Data absensi berhasil disimpan!');

            } catch (\Exception $e) {
                \DB::rollBack();
                throw $e;
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $e->errors()
                ], 422);
            }

            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Absensi store error: ' . $e->getMessage());
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan server: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Terjadi kesalahan server: ' . $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $absensi = Absensi::with(['kelas', 'mapel', 'jampel', 'guru', 'detailAbsensi.siswa'])->findOrFail($id);
        return view('absensi.show', compact('absensi'));
    }

    public function edit($id)
    {
        $absensi = Absensi::with(['kelas', 'mapel', 'jampel', 'guru', 'detailAbsensi.siswa'])->findOrFail($id);

        // Prepare siswa list from detailAbsensi for editing
        $siswa = $absensi->detailAbsensi->map(function ($d) {
            return (object) [
                'id' => $d->siswa->id,
                'nis' => $d->siswa->nis,
                'nama_siswa' => $d->siswa->nama_siswa,
                'detail_id' => $d->id,
                'status' => $d->status,
            ];
        });

        $kelas = $absensi->kelas;
        $mapel = $absensi->mapel;
        $jampel = $absensi->jampel;
        $tanggal = $absensi->tanggal;
        $pertemuan = $absensi->pertemuan ?? 1;

        // Determine jam display
        $jam = $absensi->jam ?? ($jampel?->rentang_waktu ?? ($jampel?->jam_mulai ? ($jampel->jam_mulai instanceof \Carbon\Carbon ? $jampel->jam_mulai->format('H:i') : $jampel->jam_mulai) : '00:00'));

        return view('absensi.edit', compact('absensi', 'kelas', 'mapel', 'jampel', 'tanggal', 'siswa', 'pertemuan', 'jam'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'absensi.*.id' => 'required|exists:detail_absensi,id',
            'absensi.*.status' => 'required|in:hadir,izin,sakit,alpha',
        ]);

        foreach ($request->absensi as $item) {
            $detail = DetailAbsensi::find($item['id']);
            $detail->status = $item['status'];
            $detail->save();
        }

        return redirect()->route('absensi.show', $id)
            ->with('success', 'Data absensi berhasil diperbarui!');
    }

    /**
     * Get history absensi untuk API
     */
    public function getHistory(Request $request)
    {
        try {
            $user_id = Auth::id();

            // Cari guru berdasarkan users_id yang login
            $guru = Guru::where('users_id', $user_id)->first();

            if (!$guru) {
                return response()->json([], 200);
            }

            // Get filter parameters
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $kelasId = $request->input('kelas_id');
            $mapelId = $request->input('mapel_id');

            // Validasi tanggal
            if (!$startDate || !$endDate) {
                return response()->json([], 200);
            }

            // Ambil guru_mapel yang diajar oleh guru ini
            $guruMapelQuery = GuruMapel::where('guru_id', $guru->id);

            if ($kelasId) {
                $guruMapelQuery->where('kelas_id', $kelasId);
            }

            if ($mapelId) {
                $guruMapelQuery->where('mapel_id', $mapelId);
            }

            $guruMapel = $guruMapelQuery->get();

            if ($guruMapel->isEmpty()) {
                return response()->json([], 200);
            }

            $kelas_ids = $guruMapel->pluck('kelas_id')->unique();
            $mapel_ids = $guruMapel->pluck('mapel_id')->unique();

            // Query detail absensi dengan relasi
            $query = DetailAbsensi::with([
                'absensi' => function ($q) {
                    $q->with(['kelas', 'mapel']);
                },
                'siswa'
            ])
            ->whereHas('absensi', function ($q) use ($kelas_ids, $mapel_ids, $startDate, $endDate) {
                $q->whereIn('kelas_id', $kelas_ids)
                  ->whereIn('mapel_id', $mapel_ids)
                  ->whereDate('tanggal', '>=', $startDate)
                  ->whereDate('tanggal', '<=', $endDate);
            })
            ->orderBy('created_at', 'desc');

            $detailAbsensi = $query->get();

            // Format response
            $result = $detailAbsensi->map(function ($item) {
                return [
                    'id' => $item->id,
                    'siswa_id' => $item->siswa_id,
                    'tanggal' => $item->absensi->tanggal,
                    'kelas' => [
                        'id' => $item->absensi->kelas->id,
                        'nama_kelas' => $item->absensi->kelas->nama_kelas
                    ],
                    'mapel' => [
                        'id' => $item->absensi->mapel->id,
                        'nama' => $item->absensi->mapel->nama
                    ],
                    'siswa' => [
                        'id' => $item->siswa->id,
                        'nama_siswa' => $item->siswa->nama_siswa,
                        'nis' => $item->siswa->nis
                    ],
                    'status' => $item->status
                ];
            });

            return response()->json($result);
        } catch (\Exception $e) {
            \Log::error('Error getting history: ' . $e->getMessage());
            return response()->json([], 200);
        }
    }

}
