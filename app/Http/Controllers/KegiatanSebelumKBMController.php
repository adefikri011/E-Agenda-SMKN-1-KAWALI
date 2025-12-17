<?php

namespace App\Http\Controllers;

use App\Models\KegiatanSebelumKBM;
use Illuminate\Http\Request;

class KegiatanSebelumKBMController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat',
            'kegiatan' => 'required|string',
        ]);

        try {
            // Cek apakah sudah ada kegiatan untuk hari tersebut
            $kegiatan = KegiatanSebelumKBM::updateOrCreate(
                ['hari' => $validated['hari']],
                ['kegiatan' => $validated['kegiatan']]
            );

            return redirect()->back()->with('success', '✅ Kegiatan sebelum KBM berhasil disimpan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', '❌ Gagal menyimpan kegiatan: ' . $e->getMessage());
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
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat',
            'kegiatan' => 'required|string',
        ]);

        try {
            $kegiatan = KegiatanSebelumKBM::findOrFail($id);
            $kegiatan->update($validated);

            return redirect()->back()->with('success', '✅ Kegiatan sebelum KBM berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', '❌ Gagal memperbarui kegiatan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $kegiatan = KegiatanSebelumKBM::findOrFail($id);
            $kegiatan->delete();

            return redirect()->back()->with('success', '✅ Kegiatan sebelum KBM berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', '❌ Gagal menghapus kegiatan: ' . $e->getMessage());
        }
    }
}
