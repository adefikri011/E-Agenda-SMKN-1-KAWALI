<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GuruMapel;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Jampel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GuruScheduleController extends Controller
{
    /**
     * Show schedule management page
     */
    public function index()
    {
        return view('admin.guru-schedule', [
            'guru' => Guru::with('user')->get(),
            'kelas' => Kelas::all(),
            'mapel' => MataPelajaran::all(),
            'jampel' => Jampel::orderBy('jam_ke')->get(),
        ]);
    }

    /**
     * Get all schedules (API)
     */
    public function getSchedules()
    {
        $schedules = GuruMapel::with(['guru.user', 'kelas', 'mapel', 'startJampel', 'endJampel'])
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'guru_id' => $item->guru_id,
                    'guru_name' => $item->guru->user->name ?? 'Unknown',
                    'kelas_id' => $item->kelas_id,
                    'kelas_name' => $item->kelas->nama_kelas ?? 'Unknown',
                    'mapel_id' => $item->mapel_id,
                    'mapel_name' => $item->mapel->nama ?? 'Unknown',
                    'hari_tipe' => $item->hari_tipe,
                    'start_jampel_id' => $item->start_jampel_id,
                    'start_jampel_name' => $item->startJampel?->nama_jam,
                    'start_rentang' => $item->startJampel?->rentang_waktu,
                    'end_jampel_id' => $item->end_jampel_id,
                    'end_jampel_name' => $item->endJampel?->nama_jam,
                    'end_rentang' => $item->endJampel?->rentang_waktu,
                ];
            });

        return response()->json($schedules);
    }

    /**
     * Get single schedule (API)
     */
    public function getSchedule($id)
    {
        $schedule = GuruMapel::with(['guru.user', 'kelas', 'mapel', 'startJampel', 'endJampel'])->find($id);

        if (!$schedule) {
            return response()->json(['error' => 'Jadwal tidak ditemukan'], 404);
        }

        return response()->json([
            'id' => $schedule->id,
            'guru_id' => $schedule->guru_id,
            'kelas_id' => $schedule->kelas_id,
            'mapel_id' => $schedule->mapel_id,
            'hari_tipe' => $schedule->hari_tipe,
            'start_jampel_id' => $schedule->start_jampel_id,
            'end_jampel_id' => $schedule->end_jampel_id,
        ]);
    }

    /**
     * Create new schedule (API)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'guru_id' => 'required|exists:guru,id',
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mata_pelajaran,id',
            'hari_tipe' => 'required|in:senin,selasa_rabu_kamis,jumat',
            'start_jampel_id' => 'required|exists:jam_pelajaran,id',
            'end_jampel_id' => 'nullable|exists:jam_pelajaran,id',
        ]);

        // Jika end_jampel_id tidak diisi, gunakan start_jampel_id
        if (empty($validated['end_jampel_id'])) {
            $validated['end_jampel_id'] = $validated['start_jampel_id'];
        }

        // Check for overlapping schedules
        $overlapping = GuruMapel::where('guru_id', $validated['guru_id'])
            ->where(function($query) use ($validated) {
                $query->where(function($q) use ($validated) {
                    $q->where('start_jampel_id', '<=', $validated['end_jampel_id'])
                      ->where('end_jampel_id', '>=', $validated['start_jampel_id']);
                });
            })
            ->exists();

        if ($overlapping) {
            return response()->json([
                'success' => false,
                'message' => 'Guru sudah memiliki jadwal pada jam tersebut!'
            ], 422);
        }

        try {
            $schedule = GuruMapel::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Jadwal berhasil ditambahkan',
                'data' => $schedule
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return response()->json([
                    'success' => false,
                    'message' => 'Jadwal untuk kombinasi guru, kelas, mapel, dan jam ini sudah ada!'
                ], 422);
            }

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update schedule (API)
     */
    public function update(Request $request, $id)
    {
        $schedule = GuruMapel::find($id);

        if (!$schedule) {
            return response()->json(['success' => false, 'message' => 'Jadwal tidak ditemukan'], 404);
        }

        $validated = $request->validate([
            'guru_id' => 'required|exists:guru,id',
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mata_pelajaran,id',
            'hari_tipe' => 'required|in:senin,selasa_rabu_kamis,jumat',
            'start_jampel_id' => 'required|exists:jam_pelajaran,id',
            'end_jampel_id' => 'nullable|exists:jam_pelajaran,id',
        ]);

        // Jika end_jampel_id tidak diisi, gunakan start_jampel_id
        if (empty($validated['end_jampel_id'])) {
            $validated['end_jampel_id'] = $validated['start_jampel_id'];
        }

        // Check for overlapping schedules (excluding current record)
        $overlapping = GuruMapel::where('guru_id', $validated['guru_id'])
            ->where('id', '!=', $id)
            ->where(function($query) use ($validated) {
                $query->where(function($q) use ($validated) {
                    $q->where('start_jampel_id', '<=', $validated['end_jampel_id'])
                      ->where('end_jampel_id', '>=', $validated['start_jampel_id']);
                });
            })
            ->exists();

        if ($overlapping) {
            return response()->json([
                'success' => false,
                'message' => 'Guru sudah memiliki jadwal pada jam tersebut!'
            ], 422);
        }

        try {
            $schedule->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Jadwal berhasil diperbarui',
                'data' => $schedule
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return response()->json([
                    'success' => false,
                    'message' => 'Jadwal untuk kombinasi guru, kelas, mapel, dan jam ini sudah ada!'
                ], 422);
            }

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete schedule (API)
     */
    public function destroy($id)
    {
        $schedule = GuruMapel::find($id);

        if (!$schedule) {
            return response()->json(['success' => false, 'message' => 'Jadwal tidak ditemukan'], 404);
        }

        $schedule->delete();

        return response()->json([
            'success' => true,
            'message' => 'Jadwal berhasil dihapus'
        ]);
    }

    /**
     * Get jampel grouped by day
     */
    public function getGroupedByDay()
    {
        $data = [
            'senin' => Jampel::where('hari_tipe', 'senin')->orderBy('jam_ke')->get(),
            'selasa_rabu_kamis' => Jampel::where('hari_tipe', 'selasa_rabu_kamis')->orderBy('jam_ke')->get(),
            'jumat' => Jampel::where('hari_tipe', 'jumat')->orderBy('jam_ke')->get(),
        ];

        return response()->json($data);
    }

    /**
     * Get schedule by kelas and mapel for current guru (API)
     */
    public function getScheduleByKelasMapel($kelasId, $mapelId)
    {
        try {
            $guru = Guru::where('users_id', auth()->id())->first();

            if (!$guru) {
                return response()->json([
                    'success' => false,
                    'message' => 'Guru tidak ditemukan'
                ], 404);
            }

            $schedule = GuruMapel::with(['startJampel', 'endJampel'])
                ->where('guru_id', $guru->id)
                ->where('kelas_id', $kelasId)
                ->where('mapel_id', $mapelId)
                ->first();

            if (!$schedule) {
                return response()->json([
                    'success' => false,
                    'message' => 'Jadwal tidak ditemukan untuk kombinasi kelas dan mapel ini'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'hari_tipe' => $schedule->hari_tipe,
                    'start_jampel_id' => $schedule->start_jampel_id,
                    'start_jampel_name' => $schedule->startJampel?->nama_jam,
                    'start_rentang' => $schedule->startJampel?->rentang_waktu,
                    'end_jampel_id' => $schedule->end_jampel_id,
                    'end_jampel_name' => $schedule->endJampel?->nama_jam,
                    'end_rentang' => $schedule->endJampel?->rentang_waktu,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk assign schedules (API)
     */
    public function bulkAssign(Request $request)
    {
        try {
            $validated = $request->validate([
                'guru_id' => 'required|exists:guru,id',
                'kelas_id' => 'required|exists:kelas,id',
                'mapel_ids' => 'required|array|min:1',
                'mapel_ids.*' => 'exists:mata_pelajaran,id',
            ]);

            $guruId = $validated['guru_id'];
            $kelasId = $validated['kelas_id'];
            $mapelIds = $validated['mapel_ids'];

            $createdCount = 0;
            $existingCount = 0;

            foreach ($mapelIds as $mapelId) {
                // Check if schedule already exists
                $existing = GuruMapel::where('guru_id', $guruId)
                    ->where('kelas_id', $kelasId)
                    ->where('mapel_id', $mapelId)
                    ->first();

                if ($existing) {
                    $existingCount++;
                    continue;
                }

                // Create new schedule without specific jam (default to null)
                GuruMapel::create([
                    'guru_id' => $guruId,
                    'kelas_id' => $kelasId,
                    'mapel_id' => $mapelId,
                    'hari_tipe' => null,
                    'start_jampel_id' => null,
                    'end_jampel_id' => null,
                ]);

                $createdCount++;
            }

            $message = "Berhasil menambahkan {$createdCount} jadwal";
            if ($existingCount > 0) {
                $message .= " ({$existingCount} sudah ada)";
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'created' => $createdCount,
                'existing' => $existingCount
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
