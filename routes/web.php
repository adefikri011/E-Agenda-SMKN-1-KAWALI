<?php

use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\HakAksesController;
use App\Http\Controllers\PesanController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

Route::get('/', function () {
    return view('landing_page.index');
});


Route::middleware(['auth', 'role:admin'])->group(function() {
    Route::get('/dashboard-admin', [HakAksesController::class, 'admin'])->name('dashboard.admin');
});

Route::get('/login', [AuthController::class, 'index'])->name('login');

Route::post('/proses-login', [AuthController::class, 'authenticate'])->name('login.proses');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::post('/kirim-pesan' , [PesanController::class , 'kirim'])->name('kirim.pesan');

Route::get('/tes-email', function () {
    Mail::raw('selamat anda telah berhasil menarik tunai sebesar 100.000.000.', function ($message) {
        $message->to('abuubelang@gmail.com')
                ->subject('Rafly Bau Tai');
    });

    return "Email terkirim!";
});
