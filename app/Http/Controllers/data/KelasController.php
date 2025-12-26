<?php

namespace App\Http\Controllers\data;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\User;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\KelasImport;

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

        Excel::import(new KelasImport, $request->file('file'));

        return back()->with('success', 'Data kelas berhasil diimport!');
    }
}
