<?php

use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\data\SiswaController;
use App\Http\Controllers\HakAksesController;
use App\Http\Controllers\data\KelasController;
use App\Http\Controllers\PesanController;
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
    Route::post('/kelas-update/{id}', [KelasController::class, 'update'])->name('kelas.update');
    Route::delete('/kelas-delete/{id}', [KelasController::class, 'delete'])
        ->name('kelas.delete');
    Route::post('/kelas/import', [KelasController::class, 'import'])
        ->name('kelas.import');

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
