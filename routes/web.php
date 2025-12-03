<?php

use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\HakAksesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing_page.index');
});


Route::middleware(['auth', 'role:admin'])->group(function() {
    Route::get('/dashboard-admin', [HakAksesController::class, 'admin'])->name('dashboard.admin');
});

Route::get('/login', [AuthController::class, 'index'])->name('login');

Route::post('/proses-login', [AuthController::class, 'authenticate'])->name('login.proses');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
