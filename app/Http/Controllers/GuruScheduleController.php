<?php

namespace App\Http\Controllers;

use App\Models\GuruMapel;
use App\Models\Guru;
use App\Models\Jampel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GuruScheduleController extends Controller
{
    public function index()
    {
        return view('admin.guru-schedule');
    }

    /**
     * Return JSON list of schedules for frontend
     */
    public function getSchedules()
    {
        $schedules = GuruMapel::with(['guru.user', 'kelas', 'mapel', 'jampel', 'startJampel', 'endJampel'])
            ->orderBy('kelas_id')
            ->orderBy('mapel_id')
            ->get();

        $result = $schedules->map(function ($s) {
            return [
                'id' => $s->id,
                'guru_id' => $s->guru_id,
                'guru_name' => $s->guru?->user?->name ?? ($s->guru->nama ?? 'Guru'),
                'kelas_id' => $s->kelas_id,
                'kelas_name' => $s->kelas?->nama_kelas ?? '-',
                'mapel_id' => $s->mapel_id,
                'mapel_name' => $s->mapel?->nama ?? '-',
                // legacy single jampel
                'jampel_id' => $s->jampel_id,
                'jampel_name' => $s->jampel?->nama_jam,
                'rentang_waktu' => $s->jampel?->rentang_waktu,
                // new start/end
                'start_jampel_id' => $s->start_jampel_id,
                'start_jampel_name' => $s->startJampel?->nama_jam,
                'start_rentang' => $s->startJampel?->rentang_waktu,
                'end_jampel_id' => $s->end_jampel_id,
                'end_jampel_name' => $s->endJampel?->nama_jam,
                'end_rentang' => $s->endJampel?->rentang_waktu,
            ];
        });

        return response()->json($result);
    }

    public function getSchedule($id)
    {
        $s = GuruMapel::with(['guru.user', 'kelas', 'mapel', 'jampel', 'startJampel', 'endJampel'])->findOrFail($id);

        return response()->json([
            'id' => $s->id,
            'guru_id' => $s->guru_id,
            'kelas_id' => $s->kelas_id,
            'mapel_id' => $s->mapel_id,
            'jampel_id' => $s->jampel_id,
            'start_jampel_id' => $s->start_jampel_id,
            'end_jampel_id' => $s->end_jampel_id,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'guru_id' => 'required|exists:guru,id',
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mata_pelajaran,id',
            'start_jampel_id' => 'nullable|exists:jam_pelajaran,id',
            'end_jampel_id' => 'nullable|exists:jam_pelajaran,id',
        ]);

        // prevent duplicate assignment
        $exists = GuruMapel::where('guru_id', $validated['guru_id'])
            ->where('mapel_id', $validated['mapel_id'])
            ->where('kelas_id', $validated['kelas_id'])
            ->exists();

        if ($exists) {
            return response()->json(['success' => false, 'message' => 'Kombinasi sudah ada'], 422);
        }

        // If both start and end provided, ensure end >= start using jam_ke if available, else compare ids
        if (!empty($validated['start_jampel_id']) && !empty($validated['end_jampel_id'])) {
            $start = Jampel::find($validated['start_jampel_id']);
            $end = Jampel::find($validated['end_jampel_id']);
            if ($start && $end) {
                $startOrder = $start->jam_ke ?? $start->id;
                $endOrder = $end->jam_ke ?? $end->id;
                if ($endOrder < $startOrder) {
                    return response()->json(['success' => false, 'message' => 'Jam selesai harus sama atau setelah jam mulai'], 422);
                }
            }
        }

        try {
            $data = [
                'guru_id' => $validated['guru_id'],
                'kelas_id' => $validated['kelas_id'],
                'mapel_id' => $validated['mapel_id'],
                'start_jampel_id' => $validated['start_jampel_id'] ?? null,
                'end_jampel_id' => $validated['end_jampel_id'] ?? null,
            ];

            // maintain legacy jampel_id when single
            if (!empty($validated['start_jampel_id']) && ($validated['start_jampel_id'] == ($validated['end_jampel_id'] ?? null))) {
                $data['jampel_id'] = $validated['start_jampel_id'];
            }

            $gm = GuruMapel::create($data);

            return response()->json(['success' => true, 'id' => $gm->id]);
        } catch (\Exception $e) {
            Log::error('GuruSchedule Store Error', ['message' => $e->getMessage(), 'payload' => $validated]);
            return response()->json(['success' => false, 'message' => 'Gagal menyimpan jadwal'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $s = GuruMapel::findOrFail($id);

        $validated = $request->validate([
            'guru_id' => 'required|exists:guru,id',
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mata_pelajaran,id',
            'start_jampel_id' => 'nullable|exists:jam_pelajaran,id',
            'end_jampel_id' => 'nullable|exists:jam_pelajaran,id',
        ]);

        $exists = GuruMapel::where('id', '!=', $id)
            ->where('guru_id', $validated['guru_id'])
            ->where('mapel_id', $validated['mapel_id'])
            ->where('kelas_id', $validated['kelas_id'])
            ->exists();

        if ($exists) {
            return response()->json(['success' => false, 'message' => 'Kombinasi sudah ada'], 422);
        }

        if (!empty($validated['start_jampel_id']) && !empty($validated['end_jampel_id'])) {
            $start = Jampel::find($validated['start_jampel_id']);
            $end = Jampel::find($validated['end_jampel_id']);
            if ($start && $end) {
                $startOrder = $start->jam_ke ?? $start->id;
                $endOrder = $end->jam_ke ?? $end->id;
                if ($endOrder < $startOrder) {
                    return response()->json(['success' => false, 'message' => 'Jam selesai harus sama atau setelah jam mulai'], 422);
                }
            }
        }

        try {
            $s->update([
                'guru_id' => $validated['guru_id'],
                'kelas_id' => $validated['kelas_id'],
                'mapel_id' => $validated['mapel_id'],
                'start_jampel_id' => $validated['start_jampel_id'] ?? null,
                'end_jampel_id' => $validated['end_jampel_id'] ?? null,
                'jampel_id' => (!empty($validated['start_jampel_id']) && ($validated['start_jampel_id'] == ($validated['end_jampel_id'] ?? null))) ? $validated['start_jampel_id'] : null,
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('GuruSchedule Update Error', ['message' => $e->getMessage(), 'id' => $id]);
            return response()->json(['success' => false, 'message' => 'Gagal memperbarui jadwal'], 500);
        }
    }

    public function destroy($id)
    {
        $s = GuruMapel::findOrFail($id);

        try {
            $s->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('GuruSchedule Delete Error', ['message' => $e->getMessage(), 'id' => $id]);
            return response()->json(['success' => false, 'message' => 'Gagal menghapus jadwal'], 500);
        }
    }
}
