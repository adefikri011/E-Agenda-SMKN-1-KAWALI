<?php

namespace App\Http\Controllers\data;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\User;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\KelasImport;
use App\Exports\KelasTemplateExport;

class KelasController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Kelas::with('walikelas');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_kelas', 'like', "%$search%")
                  ->orWhereHas('walikelas', function ($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%$search%");
                  });
            });
        }

        $kelas = $query->paginate(9)->appends($request->except('page'));

        // Untuk dropdown wali kelas dan jurusan
        $users = User::whereIn('role', ['guru', 'wali_kelas'])->get();
        $jurusans = Jurusan::all();

        return view('admin.data.kelas.index', compact('kelas', 'users', 'jurusans'));
    }

    public function store(Request $request)
    {
        // Validasi untuk Kelas
        $validated = $request->validate([
            'nama_kelas' => 'required|string|max:255|unique:kelas,nama_kelas',
            'wali_kelas_id' => 'nullable|exists:users,id',
            'jurusan_id' => 'nullable|exists:jurusan,id',
        ]);

        // Create Kelas
        Kelas::create([
            'nama_kelas' => $validated['nama_kelas'],
            'wali_kelas_id' => $validated['wali_kelas_id'],
            'jurusan_id' => $validated['jurusan_id'] ?? null,
        ]);

        return back()->with('success', 'Kelas berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);

        $validated = $request->validate([
            'nama_kelas' => 'required|string|max:255|unique:kelas,nama_kelas,' . $id,
            'wali_kelas_id' => 'nullable|exists:users,id',
            'jurusan_id' => 'nullable|exists:jurusan,id',
        ]);

        $kelas->update([
            'nama_kelas' => $validated['nama_kelas'],
            'wali_kelas_id' => $validated['wali_kelas_id'] ?? null,
            'jurusan_id' => $validated['jurusan_id'] ?? null,
        ]);

        return back()->with('success', 'Kelas berhasil diperbarui!');
    }

    public function delete($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();

        return back()->with('success', 'Kelas berhasil dihapus!');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:10240'
        ]);

        try {
            $import = new KelasImport();
            Excel::import($import, $request->file('file'));

            // Cek ada berapa yang sukses/gagal
            $successCount = $import->successCount ?? 0;
            $failureCount = $import->failureCount ?? count($import->failures());

            if ($successCount > 0) {
                $message = "Import berhasil! {$successCount} kelas ditambahkan.";
                if ($failureCount > 0) {
                    $message .= " ({$failureCount} baris gagal - cek logs)";
                }
                return back()->with('success', $message);
            } else {
                $message = "Tidak ada data yang berhasil diimport.";
                if ($failureCount > 0) {
                    $message .= " {$failureCount} baris gagal validasi - cek format Excel (nama_kelas wajib, jurusan_id opsional dengan ID valid)";
                }
                return back()->with('error', $message);
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error import: ' . $e->getMessage());
        }
    }

    /**
     * Download Excel template for importing kelas
     */
    public function downloadTemplate()
    {
        return Excel::download(new KelasTemplateExport, 'template_kelas.xlsx');
    }
}
