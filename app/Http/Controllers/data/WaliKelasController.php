<?php

namespace App\Http\Controllers\data;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel; // Tambahkan ini untuk import
use App\Imports\WaliKelasImport; // Tambahkan ini untuk import

class WaliKelasController extends Controller
{
  /**
 * Display a listing of the resource.
 * Menampilkan daftar guru yang ditugaskan sebagai wali kelas.
 */
public function index(Request $request)
{
    // Query untuk mengambil user yang role-nya 'walikelas' dan memiliki relasi kelasAsWali
    $query = User::where('role', 'walikelas')->has('kelasAsWali')->with('kelasAsWali', 'guru');

    // Filter berdasarkan pencarian (nama atau NIP guru)
    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->whereHas('guru', function($q) use ($search) {
            $q->where('nama', 'like', '%' . $search . '%')
              ->orWhere('nip', 'like', '%' . $search . '%');
        });
    }

    // Dapatkan data wali kelas dengan paginasi
    $waliKelas = $query->paginate(10);

    // --- LOGIKA UNTUK MODAL TAMBAH (VERSI YANG BENAR DAN SEDERHANA) ---
    // 1. Ambil semua ID user yang sudah menjadi wali kelas
    $assignedWaliKelasIds = Kelas::whereNotNull('wali_kelas_id')->pluck('wali_kelas_id');

    // 2. Cari semua guru yang users_id-nya TIDAK ADA dalam daftar di atas
    $guruAvailable = Guru::whereNotIn('users_id', $assignedWaliKelasIds)->get();

    // 3. Ambil semua kelas yang BELUM memiliki wali kelas
    $kelasAvailable = Kelas::whereNull('wali_kelas_id')->get();
    // --- AKHIR LOGIKA MODAL ---

    return view('admin.data.wali_kelas.index', compact('waliKelas', 'guruAvailable', 'kelasAvailable'));
}

    /**
 * Store a newly created resource in storage.
 * Menyimpan penugasan wali kelas dari modal di halaman index.
 */
public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'guru_id' => 'required|exists:guru,id',
        'kelas_id' => 'required|exists:kelas,id',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    $guru = Guru::find($request->guru_id);
    $kelas = Kelas::find($request->kelas_id);

    // Update tabel kelas dengan ID user dari guru yang dipilih
    $kelas->wali_kelas_id = $guru->users_id;
    $kelas->save();

    // --- TAMBAHKAN BAGIAN INI ---
    // Cari user berdasarkan users_id dari model Guru
    $user = User::find($guru->users_id);

    // Jika user ditemukan, ubah rolenya menjadi 'walikelas'
    if ($user) {
        $user->role = 'walikelas';
        $user->save();
    }
    // --- AKHIR BAGIAN TAMBAHAN ---

    return redirect()->route('wali_kelas.index')
        ->with('success', 'Wali kelas berhasil ditugaskan dan role user telah diperbarui.');
}

    /**
     * Show the form for editing the specified resource.
     * Menampilkan form untuk mengubah penugasan wali kelas.
     */
    public function edit(string $id) // PERBAIKAN: 'function string' diubah menjadi 'function edit'
    {
        // Temukan user yang merupakan wali kelas
        $user = User::findOrFail($id);
        $user->load('kelasAsWali', 'guru');

        // Ambil semua guru yang tersedia (kecuali guru ini sendiri)
        $guruAvailable = Guru::where('id', '!=', $user->guru->id)
            ->whereDoesntHave('user', function($query) {
                $query->whereHas('kelasAsWali');
            })->get();

        // Ambil semua kelas yang tersedia (kecuali kelas ini sendiri)
        $kelasAvailable = Kelas::where('id', '!=', $user->kelasAsWali->id)
            ->whereNull('wali_kelas_id')->get();

        return view('admin.data.wali_kelas.edit', compact('user', 'guruAvailable', 'kelasAvailable'));
    }

    /**
     * Update the specified resource in storage.
     * Memperbarui penugasan wali kelas.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'guru_id' => 'required|exists:guru,id',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Hapus penugasan lama
        $oldUser = User::findOrFail($id);
        $oldKelas = $oldUser->kelasAsWali;
        if ($oldKelas) {
            $oldKelas->wali_kelas_id = null;
            $oldKelas->save();
        }

        // Buat penugasan baru
        $newGuru = Guru::find($request->guru_id);
        $newKelas = Kelas::find($request->kelas_id);
        $newKelas->wali_kelas_id = $newGuru->users_id;
        $newKelas->save();

        return redirect()->route('wali_kelas.index')
            ->with('success', 'Penugasan wali kelas berhasil diperbarui');
    }

    /**
 * Remove the specified resource from storage.
 * Mencabut penugasan wali kelas.
 */
public function destroy(string $id)
{
    $user = User::findOrFail($id);
    $kelas = $user->kelasAsWali;

    if ($kelas) {
        // Hapus penugasan wali kelas
        $kelas->wali_kelas_id = null;
        $kelas->save();

        // --- TAMBAHKAN BAGIAN INI ---
        // Kembalikan role user ke 'guru'
        if ($user->role === 'walikelas') { // Pastikan hanya mengubah jika role-nya walikelas
            $user->role = 'guru';
            $user->save();
        }
        // --- AKHIR BAGIAN TAMBAHAN ---
    }

    return redirect()->route('wali_kelas.index')
        ->with('success', 'Penugasan wali kelas berhasil dicabut dan role user telah dikembalikan.');
}

    /**
     * Import data wali kelas dari Excel
     */
    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx,xls|max:10240', // Maksimal 10MB
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            Excel::import(new WaliKelasImport, $request->file('file'));

            return redirect()->route('wali_kelas.index')
                ->with('success', 'Data wali kelas berhasil diimpor');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage());
        }
    }
}
