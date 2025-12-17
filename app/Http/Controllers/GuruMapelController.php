<?php

namespace App\Http\Controllers;

use App\Models\GuruMapel;
use App\Models\Guru;
use App\Models\MataPelajaran;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GuruMapelController extends Controller
{
    /**
     * Display listing of guru-mapel assignments
     */
    public function index()
    {
        $guruMapels = GuruMapel::with(['guru', 'mapel', 'kelas'])
            ->orderBy('kelas_id')
            ->orderBy('mapel_id')
            ->paginate(15);

        $gurus = Guru::all();
        $mapels = MataPelajaran::all();
        $kelas = Kelas::all();

        return view('admin.guru-mapel.index', compact('guruMapels', 'gurus', 'mapels', 'kelas'));
    }

    /**
     * Show form untuk assign guru ke mapel
     */
    public function create()
    {
        $gurus = Guru::orderBy('nama')->get();
        $mapels = MataPelajaran::orderBy('nama')->get();
        $kelas = Kelas::orderBy('nama_kelas')->get();

        return view('admin.guru-mapel.create', compact('gurus', 'mapels', 'kelas'));
    }

    /**
     * Store assignment
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'guru_id' => 'required|exists:guru,id',
            'mapel_id' => 'required|exists:mata_pelajaran,id',
            'kelas_id' => 'required|exists:kelas,id',
        ], [
            'guru_id.required' => 'Guru harus dipilih',
            'mapel_id.required' => 'Mata pelajaran harus dipilih',
            'kelas_id.required' => 'Kelas harus dipilih',
        ]);

        // Cek duplikasi
        $exists = GuruMapel::where('guru_id', $validated['guru_id'])
            ->where('mapel_id', $validated['mapel_id'])
            ->where('kelas_id', $validated['kelas_id'])
            ->exists();

        if ($exists) {
            return back()->withInput()->with('error', '❌ Kombinasi guru, mata pelajaran, dan kelas ini sudah ada.');
        }

        try {
            GuruMapel::create($validated);

            return redirect()->route('guru-mapel.index')
                ->with('success', '✅ Penugasan guru berhasil ditambahkan!');
        } catch (\Exception $e) {
            Log::error('GuruMapel Store Error', [
                'message' => $e->getMessage(),
                'guru_id' => $validated['guru_id'],
                'mapel_id' => $validated['mapel_id'],
                'kelas_id' => $validated['kelas_id']
            ]);

            return back()->withInput()->with('error', '❌ Gagal menambahkan penugasan: ' . $e->getMessage());
        }
    }

    /**
     * Edit form
     */
    public function edit($id)
    {
        $guruMapel = GuruMapel::findOrFail($id);
        $gurus = Guru::orderBy('nama')->get();
        $mapels = MataPelajaran::orderBy('nama')->get();
        $kelas = Kelas::orderBy('nama_kelas')->get();

        return view('admin.guru-mapel.edit', compact('guruMapel', 'gurus', 'mapels', 'kelas'));
    }

    /**
     * Update assignment
     */
    public function update(Request $request, $id)
    {
        $guruMapel = GuruMapel::findOrFail($id);

        $validated = $request->validate([
            'guru_id' => 'required|exists:guru,id',
            'mapel_id' => 'required|exists:mata_pelajaran,id',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        // Cek duplikasi (exclude current record)
        $exists = GuruMapel::where('id', '!=', $id)
            ->where('guru_id', $validated['guru_id'])
            ->where('mapel_id', $validated['mapel_id'])
            ->where('kelas_id', $validated['kelas_id'])
            ->exists();

        if ($exists) {
            return back()->withInput()->with('error', '❌ Kombinasi guru, mata pelajaran, dan kelas ini sudah ada.');
        }

        try {
            $guruMapel->update($validated);

            return redirect()->route('guru-mapel.index')
                ->with('success', '✅ Penugasan guru berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('GuruMapel Update Error', [
                'message' => $e->getMessage(),
                'id' => $id
            ]);

            return back()->withInput()->with('error', '❌ Gagal memperbarui penugasan: ' . $e->getMessage());
        }
    }

    /**
     * Delete assignment
     */
    public function destroy($id)
    {
        $guruMapel = GuruMapel::findOrFail($id);

        try {
            $guru = $guruMapel->guru->nama;
            $mapel = $guruMapel->mapel->nama;
            $kelas = $guruMapel->kelas->nama_kelas;

            $guruMapel->delete();

            return back()->with('success', "✅ Penugasan $guru mengajar $mapel di $kelas berhasil dihapus!");
        } catch (\Exception $e) {
            Log::error('GuruMapel Delete Error', [
                'message' => $e->getMessage(),
                'id' => $id
            ]);

            return back()->with('error', '❌ Gagal menghapus penugasan: ' . $e->getMessage());
        }
    }

    /**
     * Bulk assign guru ke multiple mapel di kelas
     */
    public function bulkAssign(Request $request)
    {
        $validated = $request->validate([
            'guru_id' => 'required|exists:guru,id',
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_ids' => 'required|array|min:1',
            'mapel_ids.*' => 'exists:mata_pelajaran,id',
        ]);

        try {
            $created = 0;
            $skipped = 0;

            foreach ($validated['mapel_ids'] as $mapel_id) {
                $exists = GuruMapel::where('guru_id', $validated['guru_id'])
                    ->where('mapel_id', $mapel_id)
                    ->where('kelas_id', $validated['kelas_id'])
                    ->exists();

                if (!$exists) {
                    GuruMapel::create([
                        'guru_id' => $validated['guru_id'],
                        'mapel_id' => $mapel_id,
                        'kelas_id' => $validated['kelas_id']
                    ]);
                    $created++;
                } else {
                    $skipped++;
                }
            }

            $message = "✅ $created penugasan berhasil ditambahkan";
            if ($skipped > 0) {
                $message .= " ($skipped sudah ada sebelumnya)";
            }

            return back()->with('success', $message);
        } catch (\Exception $e) {
            Log::error('GuruMapel Bulk Assign Error', [
                'message' => $e->getMessage(),
                'validated' => $validated
            ]);

            return back()->with('error', '❌ Gagal bulk assign: ' . $e->getMessage());
        }
    }

    /**
     * Get gurus untuk mapel tertentu di kelas
     */
    public function getGurusForMapel($kelasId, $mapelId)
    {
        $gurus = GuruMapel::where('kelas_id', $kelasId)
            ->where('mapel_id', $mapelId)
            ->with('guru')
            ->get()
            ->pluck('guru');

        return response()->json($gurus);
    }
}
