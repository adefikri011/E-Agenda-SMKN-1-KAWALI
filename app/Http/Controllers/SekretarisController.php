<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SekretarisController extends Controller
{
    public function index(Request $request)
    {
        $kelas = Kelas::all();
        $users = User::all();
        $search = $request->input('search');
        $kelasId = $request->input('kelas_id');

        $sekretaris = User::with('siswa')
            ->where('role', 'sekretaris')
            ->whereHas('siswa')
            ->when($search, function ($query) use ($search) {
                return $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhereHas('siswa', function ($q) use ($search) {
                        $q->where('nis', 'like', '%' . $search . '%')
                          ->orWhere('nama_siswa', 'like', '%' . $search . '%');
                    });
            })
            ->when($kelasId, function ($query) use ($kelasId) {
                return $query->whereHas('siswa', function ($q) use ($kelasId) {
                    $q->where('kelas_id', $kelasId);
                });
            })
            ->paginate(10)
            ->appends($request->query());

        return view('admin.data.sekretaris.index', compact('sekretaris', 'kelas', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'email' => 'required|email|unique:users,email',
        ]);

        // Ambil data siswa
        $siswa = Siswa::find($validated['siswa_id']);

        // Buat user sekretaris
        $user = User::create([
            'name' => $siswa->nama_siswa,
            'email' => $validated['email'],
            'password' => Hash::make('12345678'),
            'role' => 'sekretaris',
        ]);

        // Update siswa dengan user_id
        $siswa->users_id = $user->id;
        $siswa->save();

        return back()->with('success', 'Data sekretaris berhasil ditambahkan!');
    }

    public function delete($id)
    {
        $user = User::where('role', 'sekretaris')->findOrFail($id);

        // Hapus siswa terkait
        Siswa::where('users_id', $user->id)->delete();

        // Hapus user
        $user->delete();

        return back()->with('success', 'Data sekretaris berhasil dihapus!');
    }

    public function update(Request $request, $id)
    {
        $user = User::where('role', 'sekretaris')->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'kelas_id' => 'required|exists:kelas,id',
            'nis' => 'required|numeric|unique:siswa,nis,' . $user->siswa->id,
            'jenkel' => 'required|in:laki-laki,perempuan',
        ]);

        // Update user
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        // Update siswa
        $user->siswa->update([
            'nama_siswa' => $validated['name'],
            'nis' => $validated['nis'],
            'kelas_id' => $validated['kelas_id'],
            'jenkel' => $validated['jenkel'],
        ]);

        return back()->with('success', 'Data sekretaris berhasil diperbarui!');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        try {
            \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\SekretarisImport, $request->file('file'));
            return back()->with('success', 'Data sekretaris berhasil diimpor!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengimpor: ' . $e->getMessage());
        }
    }

    public function getSiswaByKelas($kelas_id)
    {
        $siswa = Siswa::where('kelas_id', $kelas_id)
            ->whereDoesntHave('user') // Hanya siswa yang belum punya akun
            ->get(['id', 'nama_siswa', 'nis', 'jenkel']);

        return response()->json($siswa);
    }
}
