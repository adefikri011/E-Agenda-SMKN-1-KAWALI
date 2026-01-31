<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\data\GuruController;
use App\Http\Controllers\data\SiswaController;
use App\Http\Controllers\GuruMapelController;
use App\Http\Controllers\Admin\GuruScheduleController;
use App\Http\Controllers\Admin\RekapAbsensiController;
use App\Http\Controllers\Admin\LihatAgendaController;
use App\Http\Controllers\HakAksesController;
use App\Http\Controllers\data\KelasController;
use App\Http\Controllers\KegiatanSebelumKBMController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\PesanController;
use App\Http\Controllers\RekapController;
use App\Http\Controllers\SekretarisController;
use App\Http\Controllers\data\MapelController;
use App\Http\Controllers\data\WaliKelasController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TemplateController;

Route::get('/', [LandingPageController::class, 'index']);

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard-admin', [HakAksesController::class, 'admin'])->name('dashboard.admin');
    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.index');


    //siswa
    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.index');
    Route::post('/siswa-store', [SiswaController::class, 'store'])->name('siswa.store');
    Route::put('/siswa-update/{id}', [SiswaController::class, 'update'])->name('siswa.update');
    Route::delete('/siswa-delete/{id}', [SiswaController::class, 'destroy'])
        ->name('siswa.delete');
    Route::post('/siswa/import', [SiswaController::class, 'import'])->name('siswa.import');
    Route::get('/siswa/template', [TemplateController::class, 'downloadSiswaTemplate'])->name('template.siswa');

    //kelas
    Route::get('/kelas', [KelasController::class, 'index'])->name('kelas.index');
    Route::post('/kelas-store', [KelasController::class, 'store'])->name('kelas.store');
    Route::put('/kelas-update/{id}', [KelasController::class, 'update'])->name('kelas.update');
    Route::delete('/kelas-delete/{id}', [KelasController::class, 'delete'])
        ->name('kelas.delete');
    Route::post('/kelas/import', [KelasController::class, 'import'])
        ->name('kelas.import');
    // Rute untuk mengunduh template impor Excel untuk Kelas
    Route::get('/kelas/template', [KelasController::class, 'downloadTemplate'])->name('kelas.template');

    //guru
    Route::get('/guru', [GuruController::class, 'index'])->name('guru.index');
    Route::post('/guru-store', [GuruController::class, 'store'])->name('guru.store');
    Route::put('/guru-update/{id}', [GuruController::class, 'update'])->name('guru.update');
    Route::delete('/guru-delete/{id}', [GuruController::class, 'delete'])
        ->name('guru.delete');
    Route::post('/guru/import', [GuruController::class, 'import'])
        ->name('guru.import');
    Route::get('/guru/template', [GuruController::class, 'template'])->name('guru.template');

    /// SEKRETARIS
    Route::get('/sekretaris', [SekretarisController::class, 'index'])->name('sekretaris.index');
    Route::post('/sekretaris-store', [SekretarisController::class, 'store'])->name('sekretaris.store');
    Route::put('/sekretaris-update/{id}', [SekretarisController::class, 'update'])->name('sekretaris.update');
    Route::delete('/sekretaris-delete/{id}', [SekretarisController::class, 'delete'])->name('sekretaris.delete');
    Route::post('/sekretaris/import', [SekretarisController::class, 'import'])->name('sekretaris.import');
    Route::get('/sekretaris/get-siswa-by-kelas/{kelas_id}', [SekretarisController::class, 'getSiswaByKelas']);

    Route::get('/mapel', [MapelController::class, 'index'])->name('mapel.index');

    Route::get('/mapel/create', [MapelController::class, 'create'])->name('mapel.create');

    // Rute untuk mengunduh template impor Excel (harus sebelum route parameter {mapel})
    Route::get('/mapel/template', [MapelController::class, 'downloadTemplate'])->name('mapel.template');

    // Rute untuk mengimpor data mata pelajaran dari file Excel
    Route::post('/mapel/import', [MapelController::class, 'import'])->name('mapel.import');

    Route::post('/mapel', [MapelController::class, 'store'])->name('mapel.store');

    Route::get('/mapel/{mapel}', [MapelController::class, 'show'])->name('mapel.show');

    Route::get('/mapel/{mapel}/edit', [MapelController::class, 'edit'])->name('mapel.edit');

    // Rute untuk memperbarui data mata pelajaran di database (update)
    Route::put('/mapel/{mapel}', [MapelController::class, 'update'])->name('mapel.update');

    // Rute untuk menghapus data mata pelajaran dari database (destroy)
    Route::delete('/mapel/{mapel}', [MapelController::class, 'destroy'])->name('mapel.destroy');

    // Rute untuk mengassign guru ke mata pelajaran tertentu
    Route::post('/mapel/{mapel}/assign-guru', [MapelController::class, 'assignGuru'])->name('mapel.assignGuru');

    // ===== MANAGE JADWAL GURU (ADMIN) =====
    Route::get('/manage-jadwal-guru', [GuruScheduleController::class, 'index'])->name('admin.guru-schedule');
    Route::get('/api/guru-schedules', [GuruScheduleController::class, 'getSchedules']);
    Route::get('/api/guru-schedules/{id}', [GuruScheduleController::class, 'getSchedule']);
    Route::post('/api/guru-schedules', [GuruScheduleController::class, 'store']);
    Route::put('/api/guru-schedules/{id}', [GuruScheduleController::class, 'update']);
    Route::delete('/api/guru-schedules/{id}', [GuruScheduleController::class, 'destroy']);
    Route::get('/jampel-grouped', [GuruScheduleController::class, 'getGroupedByDay']);
    Route::get('/api/guru-schedule/{kelasId}/{mapelId}', [GuruScheduleController::class, 'getScheduleByKelasMapel']);

    // ===== REKAP ABSENSI ADMIN =====
    Route::get('/rekap-absensi', [RekapAbsensiController::class, 'index'])->name('admin.rekap-absensi.index');
    Route::get('/rekap-absensi/detail', [RekapAbsensiController::class, 'detail'])->name('admin.rekap-absensi.detail');
    Route::get('/rekap-absensi/export', [RekapAbsensiController::class, 'exportExcel'])->name('admin.rekap-absensi.export');
    Route::get('/rekap-absensi/export-pdf', [RekapAbsensiController::class, 'exportPDF'])->name('admin.rekap-absensi.export-pdf');

    // ===== LIHAT AGENDA ADMIN =====
    Route::get('/lihat-agenda', [LihatAgendaController::class, 'index'])->name('admin.lihat-agenda.index');
    Route::get('/lihat-agenda/{id}', [LihatAgendaController::class, 'show'])->name('admin.lihat-agenda.show');
    Route::get('/lihat-agenda/export', [LihatAgendaController::class, 'exportExcel'])->name('admin.lihat-agenda.export');
    Route::get('/api/lihat-agenda/statistik', [LihatAgendaController::class, 'getStatistik'])->name('admin.lihat-agenda.statistik');

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
});

Route::middleware(['auth', 'role:guru,walikelas'])->group(function () {
    Route::get('/jadwal-saya', function () {
        return view('guru.jadwal-saya');
    })->name('guru.jadwal-saya');

    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
    Route::get('/absensi/create', [AbsensiController::class, 'create'])->name('absensi.create');
    Route::get('/absensi/{id}/edit', [AbsensiController::class, 'edit'])->name('absensi.edit');
    Route::post('/absensi', [AbsensiController::class, 'store'])->name('absensi.store');
    Route::get('/absensi/{id}', [AbsensiController::class, 'show'])->name('absensi.show');
    Route::put('/absensi/{id}', [AbsensiController::class, 'update'])->name('absensi.update');
    Route::get('/absensi/siswa/{kelas_id}', [AbsensiController::class, 'getSiswaByKelas'])->name('absensi.siswa');
    Route::get('/api/absensi/history', [AbsensiController::class, 'getHistory'])->name('api.absensi.history');
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

    // Legacy tugas route now redirected to Nilai create (teachers give grades here)
    Route::get('/guru/tugas', function () {
        return redirect()->route('nilai.create');
    })->name('guru.tugas.index');
});


Route::middleware(['auth', 'role:sekretaris'])->group(function () {
    Route::get('/dashboard-sekretaris', [HakAksesController::class, 'sekretaris'])->name('dashboard.sekretaris');
});


Route::middleware(['auth', 'role:walikelas'])->group(function () {
    Route::get('/dashboard-walikelas', [HakAksesController::class, 'walikelas'])->name('dashboard.walikelas');

    Route::get('/rekap', [RekapController::class, 'index'])->name('rekap.index');
    Route::get('/api/rekap-data', [RekapController::class, 'getRekapData']);
    Route::get('/rekap/download/{format}', [RekapController::class, 'download'])->name('rekap.download');

});

Route::middleware(['auth', 'role:guru,sekretaris,walikelas'])->group(function () {
    // Route Agenda
    Route::get('/agenda', [AgendaController::class, 'index'])->name('agenda.index');
    Route::get('/agenda/create', [AgendaController::class, 'create'])->name('agenda.create');
    Route::post('/agenda', [AgendaController::class, 'store'])->name('agenda.store');
    Route::get('/agenda/{id}', [AgendaController::class, 'show'])->whereNumber('id')->name('agenda.show');
    Route::get('/agenda/{id}/edit', [AgendaController::class, 'edit'])->whereNumber('id')->name('agenda.edit');
    Route::put('/agenda/{id}', [AgendaController::class, 'update'])->whereNumber('id')->name('agenda.update');
    Route::delete('/agenda/{id}', [AgendaController::class, 'destroy'])->whereNumber('id')->name('agenda.destroy');
    Route::get('agenda/history', [AgendaController::class, 'history'])->name('agenda.history');


    // Route untuk tanda tangan agenda
    Route::get('/agenda/need-signature', [AgendaController::class, 'needSignature'])->name('agenda.need-signature');
    Route::get('/agenda/{id}/sign-form', [AgendaController::class, 'signForm'])->whereNumber('id')->name('agenda.sign-form');
    Route::post('/agenda/{id}/sign', [AgendaController::class, 'sign'])->whereNumber('id')->name('agenda.sign');

    Route::get('/agenda/rekap', [AgendaController::class, 'rekap'])->name('agenda.rekap');
    Route::get('/agenda/export-pdf', [AgendaController::class, 'exportPdf'])->name('agenda.export-pdf');
    Route::get('/agenda/export-excel', [AgendaController::class, 'exportExcel'])->name('agenda.export-excel');

    // API endpoint untuk mendapatkan mata pelajaran berdasarkan kelas
    Route::get('/agenda/get-mapel-by-kelas/{kelasId}', [AgendaController::class, 'getMapelByKelas'])->name('agenda.get-mapel-by-kelas');

    // NOTE: manual consolidated UI removed; consolidation saved to history (rekap)
    // Route Kegiatan Sebelum KBM
    Route::get('/kegiatan-sebelum-kbm', [KegiatanSebelumKBMController::class, 'index'])->name('kegiatan.index');
    Route::post('/kegiatan-sebelum-kbm', [KegiatanSebelumKBMController::class, 'store'])->name('kegiatan-sebelum-kbm.store');
    Route::get('/kegiatan-sebelum-kbm/{id}/edit', [KegiatanSebelumKBMController::class, 'edit'])->name('kegiatan-sebelum-kbm.edit');
    Route::put('/kegiatan-sebelum-kbm/{id}', [KegiatanSebelumKBMController::class, 'update'])->name('kegiatan-sebelum-kbm.update');
    Route::delete('/kegiatan-sebelum-kbm/{id}', [KegiatanSebelumKBMController::class, 'destroy'])->name('kegiatan-sebelum-kbm.destroy');
    Route::get('/test-mapel', [AgendaController::class, 'testMapel'])->name('agenda.test-mapel');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/api/jampel', [AgendaController::class, 'getJampel']);
    Route::get('/api/agendas/{date}', [AgendaController::class, 'getAgendaByDate']);
    Route::get('/api/agendas/{id}', [AgendaController::class, 'getAgenda']);
    Route::post('/api/agendas', [AgendaController::class, 'storeApi']);
    Route::put('/api/agendas/{id}', [AgendaController::class, 'updateApi']);
    Route::delete('/api/agendas/{id}', [AgendaController::class, 'destroyApi']);

    Route::get('/api/my-schedules', [AgendaController::class, 'getMySchedules']);
    Route::get('/api/schedule-for-agenda/{scheduleId}', [AgendaController::class, 'getScheduleForAgenda']);
    Route::get('/api/validate-schedule/{kelasId}/{mapelId}/{startJampelId}/{endJampelId}', [AgendaController::class, 'validateScheduleForAgenda']);
});

Route::get('/login', [AuthController::class, 'index'])->name('login');

Route::post('/proses-login', [AuthController::class, 'authenticate'])->name('login.proses');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::post('/kirim-pesan', [PesanController::class, 'kirim'])->name('kirim.pesan');

Route::get('/tes-email', function () {
    Mail::raw('selamat anda telah berhasil menarik tunai sebesar 100.000.000.', function ($message) {
        $message->to('abuubelang@gmail.com')
            ->subject('Rafly Bau Tai');
        Route::get('/api/absensi/history', [AbsensiController::class, 'getHistory']);
    });

    return "Email terkirim!";
});



// Quick debug route for local development: render rekap without role middleware
// Only enabled in local environment to avoid exposing in production.
if (app()->environment('local')) {
    Route::get('/agenda/rekap-debug', [AgendaController::class, 'rekap'])->name('agenda.rekap.debug');
}

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/change-password', [ProfileController::class, 'changePasswordForm'])->name('profile.change-password');
    Route::put('/change-password', [ProfileController::class, 'changePassword'])->name('profile.update-password');
});
