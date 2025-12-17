<?php

namespace App\Http\Controllers\data;

use App\Http\Controllers\Controller;
use App\Imports\SiswaImport;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $kelas_id = $request->input('kelas_id');

        $query = Siswa::with('kelas');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_siswa', 'like', "%$search%")
                  ->orWhere('nis', 'like', "%$search%");
            });
        }

        if ($kelas_id) {
            $query->where('kelas_id', $kelas_id);
        }

        $siswa = $query->paginate(10)->appends($request->except('page'));
        $kelas = Kelas::all();

        return view('admin.data.siswa.index', compact('siswa', 'kelas'));
    }

    // Tambahkan method create
    public function create()
    {
        $kelas = Kelas::all();
        return view('admin.data.siswa.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'nama_siswa' => 'required|string|max:255',
            'nis' => 'required|string|max:50|unique:siswa,nis',
            'jenkel' => 'required|in:laki-laki,perempuan',
        ]);

        // Simpan siswa
        Siswa::create($validated);

        // Perbaiki redirect ke index
        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil ditambahkan!');
    }

    // Tambahkan method edit
    public function edit($id)
    {
        $siswa = Siswa::findOrFail($id);
        $kelas = Kelas::all();
        return view('admin.data.siswa.edit', compact('siswa', 'kelas'));
    }

    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $validated = $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'nama_siswa' => 'required|string|max:255',
            'nis' => 'required|string|max:50|unique:siswa,nis,' . $id,
            'jenkel' => 'required|in:laki-laki,perempuan',
        ]);

        // Update siswa
        $siswa->update($validated);

        // Perbaiki redirect ke index
        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui!');
    }

    // Ubah delete menjadi destroy untuk konsistensi
    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();

        // Perbaiki redirect ke index
        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil dihapus!');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:10240'
        ]);

        Excel::import(new SiswaImport, $request->file('file'));

        return back()->with('success', 'Data siswa berhasil diimport!');
    }
}