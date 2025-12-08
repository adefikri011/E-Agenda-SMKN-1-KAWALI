<?php

namespace App\Http\Controllers\data;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Guru::with('user'); // relasi ke user

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%$search%")
                  ->orWhere('nip', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
            });
        }

        $guru = $query->paginate(10);

        return view('admin.data.guru.index', compact('guru'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'nip'           => 'required|string|max:50|unique:guru,nip',
            'nik'           => 'nullable|string|max:50',
            'tempat_lahir'  => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|string|max:20',
            'alamat'        => 'nullable|string|max:255',
            'no_hp'         => 'nullable|string|max:20',
        ]);

        // 1. Buat akun user
        $user = User::create([
            'name'     => $validated['nama'],
            'email'    => $validated['email'],
            'password' => Hash::make('12345678'),
            'role'     => 'guru',
        ]);

        // 2. Buat data guru
        Guru::create([
            'users_id'      => $user->id,
            'nama'          => $validated['nama'],
            'nik'           => $validated['nik'] ?? null,
            'nip'           => $validated['nip'],
            'email'         => $validated['email'],
            'tempat_lahir'  => $validated['tempat_lahir'] ?? null,
            'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
            'jenis_kelamin' => $validated['jenis_kelamin'] ?? null,
            'alamat'        => $validated['alamat'] ?? null,
            'no_hp'         => $validated['no_hp'] ?? null,
        ]);

        return back()->with('success', 'Guru berhasil ditambahkan!');
    }


    public function update(Request $request, $id)
    {
        $guru = Guru::with('user')->findOrFail($id);

        $validated = $request->validate([
            'nama'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email,' . $guru->users_id,
            'nip'           => 'required|string|max:50|unique:guru,nip,' . $id,
            'nik'           => 'nullable|string|max:50',
            'tempat_lahir'  => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|string|max:20',
            'alamat'        => 'nullable|string|max:255',
            'no_hp'         => 'nullable|string|max:20',
        ]);

        // Update tabel user
        $guru->user->update([
            'name'  => $validated['nama'],
            'email' => $validated['email'],
        ]);

        // Update tabel guru
        $guru->update([
            'nama'          => $validated['nama'],
            'nik'           => $validated['nik'] ?? null,
            'nip'           => $validated['nip'],
            'email'         => $validated['email'],
            'tempat_lahir'  => $validated['tempat_lahir'] ?? null,
            'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
            'jenis_kelamin' => $validated['jenis_kelamin'] ?? null,
            'alamat'        => $validated['alamat'] ?? null,
            'no_hp'         => $validated['no_hp'] ?? null,
        ]);

        return back()->with('success', 'Data guru berhasil diperbarui!');
    }


    public function delete($id)
    {
        $guru = Guru::findOrFail($id);

        // hapus user juga
        User::where('id', $guru->users_id)->delete();

        // hapus guru
        $guru->delete();

        return back()->with('success', 'Data guru berhasil dihapus!');
    }
}
