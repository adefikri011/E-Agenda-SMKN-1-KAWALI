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
        $jampel = Jampel::all();

        // Ambil parameter dari URL jika ada, dengan nilai default
        $selectedKelas = request()->input('kelas_id');
        $selectedTanggal = request()->input('tanggal', now()->format('Y-m-d'));
        $selectedMapel = request()->input('mapel_id');

        return view('absensi.index', compact(
            'kelas',
            'mapel',
            'jampel',
            'selectedKelas',
            'selectedTanggal',
            'selectedMapel'
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
        $siswa = Siswa::where('kelas_id', $request->kelas_id)->get();

        // Cek apakah absensi sudah ada
        $existingAbsensi = Absensi::where([
            'kelas_id' => $request->kelas_id,
            'mapel_id' => $request->mapel_id,
            'jampel_id' => $request->jampel_id,
            'tanggal' => $tanggal,
            'guru_id' => Auth::id(),
        ])->first();

        if ($existingAbsensi) {
            return redirect()->route('absensi.show', $existingAbsensi->id)
                ->with('info', 'Absensi untuk kelas, mapel, dan tanggal tersebut sudah ada. Menampilkan data yang sudah ada.');
        }

        return view('absensi.create', compact('kelas', 'mapel', 'jampel', 'tanggal', 'siswa', 'pertemuan'));
    }


    public function store(Request $request)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'kelas_id' => 'required|exists:kelas,id',
                'mapel_id' => 'required|exists:mata_pelajaran,id',
                'jampel_id' => 'required|exists:jam_pelajaran,id',
                'tanggal' => 'required|date',
                'pertemuan' => 'required|integer|min:0',
                'absensi.*.siswa_id' => 'required|exists:siswa,id',
                'absensi.*.status' => 'required|in:hadir,izin,sakit,alpha',
            ]);

            $tanggal = Carbon::parse($validated['tanggal'])->format('Y-m-d');

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

            // Check for existing attendance record
            $existingAbsensi = Absensi::where([
                'kelas_id' => $validated['kelas_id'],
                'mapel_id' => $validated['mapel_id'],
                'jampel_id' => $validated['jampel_id'],
                'tanggal' => $tanggal,
                'guru_id' => $guru->id,
            ])->first();

            if ($existingAbsensi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Absensi untuk kelas, mapel, dan tanggal tersebut sudah ada.'
                ], 409); // 409 Conflict status
            }

            // Get the time slot to extract the time value
            $jampel = Jampel::find($validated['jampel_id']);
            if (!$jampel) {
                return response()->json([
                    'success' => false,
                    'message' => 'Jam pelajaran tidak ditemukan'
                ], 404);
            }

            // Use database transaction
            \DB::beginTransaction();

            try {
                // Create main attendance record
                $absensi = Absensi::create([
                    'kelas_id' => $validated['kelas_id'],
                    'mapel_id' => $validated['mapel_id'],
                    'jampel_id' => $validated['jampel_id'],
                    'tanggal' => $tanggal,
                    'guru_id' => $guru->id,
                    'pertemuan' => $validated['pertemuan'],
                    'jam' => $jampel->jam, // Add this line to include the jam value
                ]);

                // Save attendance details for each student
                foreach ($validated['absensi'] as $item) {
                    DetailAbsensi::create([
                        'absensi_id' => $absensi->id,
                        'siswa_id' => $item['siswa_id'],
                        'status' => $item['status'],
                    ]);
                }

                \DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Data absensi berhasil disimpan!',
                    'data' => [
                        'id' => $absensi->id,
                        'tanggal' => $absensi->tanggal,
                    ]
                ], 201);

            } catch (\Exception $e) {
                \DB::rollBack();
                throw $e;
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Absensi store error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server: ' . $e->getMessage()
            ], 500);
        }
    }
    public function show($id)
    {
        $absensi = Absensi::with(['kelas', 'mapel', 'jampel', 'guru', 'detailAbsensi.siswa'])->findOrFail($id);
        return view('absensi.show', compact('absensi'));
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


}
