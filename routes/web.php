<?php

use App\Http\Controllers\auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing_page.index');
});




Route::get('/login' , [AuthController::class , 'login'])->name('login.index');
Route::post('/proses-login' , [AuthController::class , 'authenticate'])->name('login.proses');
