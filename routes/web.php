<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\data\GuruController;
use App\Http\Controllers\data\SiswaController;
use App\Http\Controllers\HakAksesController;
use App\Http\Controllers\data\KelasController;
use App\Http\Controllers\KegiatanSebelumKBMController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\PesanController;
use App\Http\Controllers\SekretarisController;
use App\Http\Controllers\data\MapelController;
use App\Http\Controllers\data\WaliKelasController;
use App\Http\Controllers\GuruMapelController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

Route::get('/', function () {
    return view('landing_page.index');
});


Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard-admin', [HakAksesController::class, 'admin'])->name('dashboard.admin');
    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.index');


    //siswa
    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.index');
    Route::post('/siswa-store', [SiswaController::class, 'store'])->name('siswa.store');
    Route::post('/siswa-update/{id}', [SiswaController::class, 'update'])->name('siswa.update');
    Route::delete('/siswa-delete/{id}', [SiswaController::class, 'delete'])
        ->name('siswa.delete');
    Route::post('/siswa/import', [SiswaController::class, 'import'])->name('siswa.import');

    //kelas
    Route::get('/kelas', [KelasController::class, 'index'])->name('kelas.index');
    Route::post('/kelas-store', [KelasController::class, 'store'])->name('kelas.store');
    Route::put('/kelas-update/{id}', [KelasController::class, 'update'])->name('kelas.update');
    Route::delete('/kelas-delete/{id}', [KelasController::class, 'delete'])
        ->name('kelas.delete');
    Route::post('/kelas/import', [KelasController::class, 'import'])
        ->name('kelas.import');

    //guru
    Route::get('/guru', [GuruController::class, 'index'])->name('guru.index');
    Route::post('/guru-store', [GuruController::class, 'store'])->name('guru.store');
    Route::put('/guru-update/{id}', [GuruController::class, 'update'])->name('guru.update');
    Route::delete('/guru-delete/{id}', [GuruController::class, 'delete'])
        ->name('guru.delete');
    Route::post('/guru/import', [GuruController::class, 'import'])
        ->name('guru.import');

    /// SEKRETARIS
    Route::get('/sekretaris', [SekretarisController::class, 'index'])->name('sekretaris.index');
    Route::post('/sekretaris-store', [SekretarisController::class, 'store'])->name('sekretaris.store');
    Route::put('/sekretaris-update/{id}', [SekretarisController::class, 'update'])->name('sekretaris.update');
    Route::delete('/sekretaris-delete/{id}', [SekretarisController::class, 'delete'])->name('sekretaris.delete');
    Route::post('/sekretaris/import', [SekretarisController::class, 'import'])->name('sekretaris.import');
    Route::get('/sekretaris/get-siswa-by-kelas/{kelas_id}', [SekretarisController::class, 'getSiswaByKelas']);

    // Rute untuk Mata Pelajaran
    // Rute untuk menampilkan daftar semua mata pelajaran (index)
    Route::get('/mapel', [MapelController::class, 'index'])->name('mapel.index');

    // Rute untuk menampilkan form tambah mata pelajaran baru (create)
    Route::get('/mapel/create', [MapelController::class, 'create'])->name('mapel.create');

    // Rute untuk menyimpan data mata pelajaran baru ke database (store)
    Route::post('/mapel', [MapelController::class, 'store'])->name('mapel.store');

    // Rute untuk menampilkan detail satu mata pelajaran (show)
    Route::get('/mapel/{mapel}', [MapelController::class, 'show'])->name('mapel.show');

    // Rute untuk menampilkan form edit mata pelajaran (edit)
    Route::get('/mapel/{mapel}/edit', [MapelController::class, 'edit'])->name('mapel.edit');

    // Rute untuk memperbarui data mata pelajaran di database (update)
    Route::put('/mapel/{mapel}', [MapelController::class, 'update'])->name('mapel.update');

    // Rute untuk menghapus data mata pelajaran dari database (destroy)
    Route::delete('/mapel/{mapel}', [MapelController::class, 'destroy'])->name('mapel.destroy');

    // Rute untuk mengimpor data mata pelajaran dari file Excel
    Route::post('/mapel/import', [MapelController::class, 'import'])->name('mapel.import');

    // Rute untuk mengunduh template impor Excel
    Route::get('/mapel/template', [MapelController::class, 'downloadTemplate'])->name('mapel.template');

    // Rute untuk menugaskan guru ke mata pelajaran tertentu
    Route::post('/mapel/{mapel}/assign-guru', [MapelController::class, 'assignGuru'])->name('mapel.assignGuru');


    // Rute untuk Wali Kelas
    Route::get('/wali-kelas', [WaliKelasController::class, 'index'])->name('wali_kelas.index');
    // Route::get('/wali-kelas/create', ...) -> RUTE INI SUDAH TIDAK DIPERLUKAN
    Route::post('/wali-kelas', [WaliKelasController::class, 'store'])->name('wali_kelas.store');
    Route::put('/wali-kelas/{wali_kelas}', [WaliKelasController::class, 'update'])->name('wali_kelas.update');
    Route::delete('/wali-kelas/{wali_kelas}', [WaliKelasController::class, 'destroy'])->name('wali_kelas.destroy');
    Route::post('/wali-kelas/import', [WaliKelasController::class, 'import'])->name('wali_kelas.import');

    // Rute untuk Guru-Mapel Assignment
    Route::get('/guru-mapel', [GuruMapelController::class, 'index'])->name('guru-mapel.index');
    Route::get('/guru-mapel/create', [GuruMapelController::class, 'create'])->name('guru-mapel.create');
    Route::post('/guru-mapel', [GuruMapelController::class, 'store'])->name('guru-mapel.store');
    Route::get('/guru-mapel/{id}/edit', [GuruMapelController::class, 'edit'])->whereNumber('id')->name('guru-mapel.edit');
    Route::put('/guru-mapel/{id}', [GuruMapelController::class, 'update'])->whereNumber('id')->name('guru-mapel.update');
    Route::delete('/guru-mapel/{id}', [GuruMapelController::class, 'destroy'])->whereNumber('id')->name('guru-mapel.destroy');
    Route::post('/guru-mapel/bulk-assign', [GuruMapelController::class, 'bulkAssign'])->name('guru-mapel.bulk-assign');
    Route::get('/guru-mapel/{kelasId}/{mapelId}/gurus', [GuruMapelController::class, 'getGurusForMapel'])->name('guru-mapel.get-gurus');

});



Route::middleware(['auth', 'role:guru'])->group(function () {
    Route::get('/dashboard-guru', [HakAksesController::class, 'guru'])->name('dashboard.guru');

    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
    Route::get('/absensi/create', [AbsensiController::class, 'create'])->name('absensi.create');
    Route::post('/absensi', [AbsensiController::class, 'store'])->name('absensi.store');
    Route::get('/absensi/{id}', [AbsensiController::class, 'show'])->name('absensi.show');
    Route::put('/absensi/{id}', [AbsensiController::class, 'update'])->name('absensi.update');
    Route::get('/absensi/siswa/{kelas_id}', [AbsensiController::class, 'getSiswaByKelas'])->name('absensi.siswa');
    Route::get('/agenda/siswa-tidak-hadir', [AgendaController::class, 'getSiswaTidakHadirJson'])->name('agenda.siswa-tidak-hadir');
    Route::get('/agenda/{id}/detail', [AgendaController::class, 'getDetail'])->name('agenda.detail');

    //Nilai
    Route::get('/nilai', [NilaiController::class, 'index'])->name('nilai.index');
    Route::get('/nilai/create', [NilaiController::class, 'create'])->name('nilai.create');
    Route::post('/nilai', [NilaiController::class, 'store'])->name('nilai.store');
    Route::get('/nilai/{id}', [NilaiController::class, 'show'])->name('nilai.show');
    Route::get('/nilai/{id}/edit', [NilaiController::class, 'edit'])->name('nilai.edit');
    Route::put('/nilai/{id}', [NilaiController::class, 'update'])->name('nilai.update');
    Route::delete('/nilai/{id}', [NilaiController::class, 'destroy'])->name('nilai.destroy');
});


Route::middleware(['auth', 'role:sekretaris'])->group(function () {
    Route::get('/dashboard-sekretaris', [HakAksesController::class, 'sekretaris']);
});

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


Route::middleware(['auth', 'role:guru,sekretaris,walikelas'])->group(function () {
    // Route Agenda
    Route::get('/agenda', [AgendaController::class, 'index'])->name('agenda.index');
    Route::get('/agenda/create', [AgendaController::class, 'create'])->name('agenda.create');
    Route::post('/agenda', [AgendaController::class, 'store'])->name('agenda.store');
    Route::get('/agenda/{id}', [AgendaController::class, 'show'])->whereNumber('id')->name('agenda.show');
    Route::get('/agenda/{id}/edit', [AgendaController::class, 'edit'])->whereNumber('id')->name('agenda.edit');
    Route::put('/agenda/{id}', [AgendaController::class, 'update'])->whereNumber('id')->name('agenda.update');
    Route::delete('/agenda/{id}', [AgendaController::class, 'destroy'])->whereNumber('id')->name('agenda.destroy');

    // Route untuk tanda tangan agenda
    Route::get('/agenda/need-signature', [AgendaController::class, 'needSignature'])->name('agenda.need-signature');
    Route::get('/agenda/{id}/sign-form', [AgendaController::class, 'signForm'])->whereNumber('id')->name('agenda.sign-form');
    Route::post('/agenda/{id}/sign', [AgendaController::class, 'sign'])->whereNumber('id')->name('agenda.sign');

    // Route untuk rekap agenda
    Route::get('/agenda/rekap', [AgendaController::class, 'rekap'])->name('agenda.rekap');
    Route::get('/agenda/export-pdf', [AgendaController::class, 'exportPdf'])->name('agenda.export-pdf');
    Route::get('/agenda/export-excel', [AgendaController::class, 'exportExcel'])->name('agenda.export-excel');

    // API endpoint untuk mendapatkan mata pelajaran berdasarkan kelas
    Route::get('/agenda/get-mapel-by-kelas/{kelasId}', [AgendaController::class, 'getMapelByKelas'])->name('agenda.get-mapel-by-kelas');

    // Route Kegiatan Sebelum KBM
    Route::post('/kegiatan-sebelum-kbm', [KegiatanSebelumKBMController::class, 'store'])->name('kegiatan-sebelum-kbm.store');
    Route::get('/kegiatan-sebelum-kbm/{id}/edit', [KegiatanSebelumKBMController::class, 'edit'])->name('kegiatan-sebelum-kbm.edit');
    Route::put('/kegiatan-sebelum-kbm/{id}', [KegiatanSebelumKBMController::class, 'update'])->name('kegiatan-sebelum-kbm.update');
    Route::delete('/kegiatan-sebelum-kbm/{id}', [KegiatanSebelumKBMController::class, 'destroy'])->name('kegiatan-sebelum-kbm.destroy');
    Route::get('/test-mapel', [AgendaController::class, 'testMapel'])->name('agenda.test-mapel');
});

Route::get('/login', [AuthController::class, 'index'])->name('login');

Route::post('/proses-login', [AuthController::class, 'authenticate'])->name('login.proses');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::post('/kirim-pesan', [PesanController::class, 'kirim'])->name('kirim.pesan');

Route::get('/tes-email', function () {
    Mail::raw('selamat anda telah berhasil menarik tunai sebesar 100.000.000.', function ($message) {
        $message->to('abuubelang@gmail.com')
            ->subject('Rafly Bau Tai');
    });

    return "Email terkirim!";
});



// Quick debug route for local development: render rekap without role middleware
// Only enabled in local environment to avoid exposing in production.
if (app()->environment('local')) {
    Route::get('/agenda/rekap-debug', [AgendaController::class, 'rekap'])->name('agenda.rekap.debug');
}
