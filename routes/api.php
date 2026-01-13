<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\GuruScheduleController;

Route::get('/test', function () {
    return response()->json([
        'status' => true,
        'message' => 'API berhasil diakses'
    ]);
});

// Guru Schedule API routes
Route::prefix('guru-schedules')->group(function () {
    Route::post('bulk-assign', [GuruScheduleController::class, 'bulkAssign']);
    Route::get('/', [GuruScheduleController::class, 'getSchedules']);
    Route::get('/{id}', [GuruScheduleController::class, 'getSchedule']);
    Route::post('/', [GuruScheduleController::class, 'store']);
    Route::put('/{id}', [GuruScheduleController::class, 'update']);
    Route::delete('/{id}', [GuruScheduleController::class, 'destroy']);
    Route::get('grouped/day', [GuruScheduleController::class, 'getGroupedByDay']);
    Route::get('by-kelas-mapel/{kelasId}/{mapelId}', [GuruScheduleController::class, 'getScheduleByKelasMapel']);
});
