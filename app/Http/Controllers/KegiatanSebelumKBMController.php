<?php

namespace App\Http\Controllers;

use App\Models\KegiatanSebelumKBM;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class KegiatanSebelumKBMController extends Controller
{
    /**
     * Show the kegiatan sebelum KBM management page
     */
    public function index()
    {
        $days = KegiatanSebelumKBM::getAvailableDays();
        $jurusans = Jurusan::all();

        // Tentukan hari saat ini dengan mapping yang sama seperti di store()
        $englishDay = now()->format('l');
        $map = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Senin',
            'Sunday' => 'Senin',
        ];
        $todayHari = $map[$englishDay] ?? now()->translatedFormat('l');

        // Ambil activities hanya untuk hari hari ini
        $activities = KegiatanSebelumKBM::where('hari', $todayHari)
            ->get()
            ->groupBy('hari');

        return view('kegiatan-sebelum-kbm.index', compact('days', 'activities', 'jurusans', 'todayHari'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kegiatan' => 'required|string',
            'jurusan_id' => 'nullable|exists:jurusan,id',
        ]);

        try {
            // Tentukan hari secara otomatis berdasarkan tanggal saat ini
            // Pastikan nama hari sesuai dengan format bahasa Indonesia yang digunakan di DB
            $englishDay = now()->format('l');
            $map = [
                'Monday' => 'Senin',
                'Tuesday' => 'Selasa',
                'Wednesday' => 'Rabu',
                'Thursday' => 'Kamis',
                'Friday' => 'Jumat',
                'Saturday' => 'Senin',
                'Sunday' => 'Senin',
            ];
            $hari = $map[$englishDay] ?? now()->translatedFormat('l');
            // Cek apakah sudah ada kegiatan untuk kombinasi hari + jurusan
            $key = ['hari' => $hari, 'jurusan_id' => $validated['jurusan_id'] ?? null];
            $kegiatan = KegiatanSebelumKBM::updateOrCreate(
                $key,
                ['kegiatan' => $validated['kegiatan']]
            );

            return redirect()->back()->with('success', 'Kegiatan sebelum KBM berhasil disimpan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan kegiatan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $kegiatan = KegiatanSebelumKBM::findOrFail($id);
        return response()->json($kegiatan);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'kegiatan' => 'required|string',
            'jurusan_id' => 'nullable|exists:jurusan,id',
        ]);

        try {
            $kegiatan = KegiatanSebelumKBM::findOrFail($id);
            $kegiatan->update([
                'kegiatan' => $validated['kegiatan'],
                'jurusan_id' => $validated['jurusan_id'] ?? null,
            ]);

            return redirect()->back()->with('success', ' Kegiatan sebelum KBM berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui kegiatan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $kegiatan = KegiatanSebelumKBM::findOrFail($id);
            $kegiatan->delete();

            return redirect()->back()->with('success', ' Kegiatan sebelum KBM berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus kegiatan: ' . $e->getMessage());
        }
    }
}
