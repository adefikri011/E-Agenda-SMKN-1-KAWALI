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
 * Display the dashboard for the currently logged-in wali kelas.
 */
public function dashboard()
{
    // Mendapatkan user yang sedang login
    $user = Auth::user();

    // Mendapatkan kelas yang diampu oleh wali kelas ini
    $kelas = Kelas::where('wali_kelas_id', $user->id)->first();

    // Jika tidak ada kelas yang diampu, tampilkan pesan error atau redirect
    if (!$kelas) {
        return redirect()->route('home')->with('error', 'Anda belum ditugaskan sebagai wali kelas.');
    }

    // Mendapatkan jumlah siswa di kelas tersebut
    $jumlahSiswa = $kelas->siswa()->count();

    // Mendapatkan jumlah mata pelajaran di kelas tersebut
    $jumlahMapel = $kelas->mataPelajaran()->count();

    // Data kehadiran (sesuaikan dengan model kehadiran Anda)
    // Jika Anda punya model Kehadiran, Anda bisa query seperti ini:
    // $kehadiranHariIni = Kehadiran::where('kelas_id', $kelas->id)
    //                             ->whereDate('created_at', now()->today())
    //                             ->where('status', 'hadir')
    //                             ->count();

    // Untuk contoh, kita gunakan data dinamis sederhana:
    $kehadiranHariIni = $jumlahSiswa > 0 ? $jumlahSiswa - 2 : 0; // Sebagian besar siswa hadir
    $kehadiranIzin = $jumlahSiswa > 0 ? 1 : 0; // 1 siswa izin
    $kehadiranSakit = 0; // Tidak ada yang sakit
    $kehadiranAlpha = $jumlahSiswa > 0 ? 1 : 0; // 1 siswa alpha

    // Menghitung jumlah siswa yang tidak hadir
    $siswaTidakHadir = $jumlahSiswa - $kehadiranHariIni;

    // Kirim data ke view
    return view('wali_kelas.dashboard', compact(
        'user',
        'kelas',
        'jumlahSiswa',
        'jumlahMapel',
        'kehadiranHariIni',
        'kehadiranIzin',
        'kehadiranSakit',
        'kehadiranAlpha',
        'siswaTidakHadir'
    ));


}
    /**
     * Display a listing of the resource.
     * Menampilkan daftar guru yang ditugaskan sebagai wali kelas.
     * Juga menyediakan data untuk modal Tambah Wali Kelas.
     */
    public function index(Request $request)
    {
        // Query untuk mengambil user yang role-nya 'guru' dan memiliki relasi kelasAsWali
        $query = User::where('role', 'guru')->has('kelasAsWali')->with('kelasAsWali', 'guru');



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

        // --- LOGIKA UNTUK MODAL TAMBAH ---
        // Ambil semua guru yang BELUM menjadi wali kelas
        $guruAvailable = Guru::whereDoesntHave('user', function ($query) {
            $query->whereHas('kelasAsWali');
        })->get();

        // Ambil semua kelas yang BELUM memiliki wali kelas
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

        return redirect()->route('wali_kelas.index')
            ->with('success', 'Wali kelas berhasil ditugaskan');
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
            $kelas->wali_kelas_id = null;
            $kelas->save();
        }

        return redirect()->route('wali_kelas.index')
            ->with('success', 'Penugasan wali kelas berhasil dicabut');
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
