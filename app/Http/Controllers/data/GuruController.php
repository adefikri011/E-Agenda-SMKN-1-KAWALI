<?php

namespace App\Http\Controllers\data;

use App\Exports\GuruTemplateExport;
use App\Http\Controllers\Controller;
use App\Imports\GuruImport;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Guru::with('user');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%$search%")
                    ->orWhere('nip', 'like', "%$search%")
                    ->orWhereHas('user', function ($u) use ($search) {
                        $u->where('email', 'like', "%$search%");
                    });
            });
        }

        $guru = $query->paginate(10);

        return view('admin.data.guru.index', compact('guru'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nip' => 'required|string|max:50|unique:guru,nip',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
        ]);

        // 1. Buat user
        $user = User::create([
            'name' => $validated['nama'],
            'email' => $validated['email'],
            'password' => Hash::make('12345678'),
            'role' => 'guru',
        ]);

        // 2. Buat data guru
        Guru::create([
            'users_id' => $user->id,
            'nama' => $validated['nama'],
            'nip' => $validated['nip'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
        ]);

        return back()->with('success', 'Guru berhasil ditambahkan!');
    }


    public function update(Request $request, $id)
    {
        $guru = Guru::with('user')->findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $guru->users_id,
            'nip' => 'required|string|max:50|unique:guru,nip,' . $id,
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
        ]);

        // Update user
        $guru->user->update([
            'name' => $validated['nama'],
            'email' => $validated['email'],
        ]);

        // Update data guru
        $guru->update([
            'nama' => $validated['nama'],
            'nip' => $validated['nip'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
        ]);

        return back()->with('success', 'Data guru berhasil diperbarui!');
    }


    public function delete($id)
    {
        $guru = Guru::findOrFail($id);

        // Hapus user
        User::where('id', $guru->users_id)->delete();

        // Hapus guru
        $guru->delete();

        return back()->with('success', 'Data guru berhasil dihapus!');
    }

    public function import(Request $request)
    {
        // Validasi file
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048'
        ]);

        try {
            // Jalankan proses import
            Excel::import(new GuruImport, $request->file('file'));

            return back()->with('success', 'Data Guru berhasil diimport dan Akun User telah dibuat!');

        } catch (\Exception $e) {
            // Return error jika ada masalah (misal format kolom salah)
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function template()
    {
        return Excel::download(new GuruTemplateExport(), 'template_guru.xlsx');
    }
}
