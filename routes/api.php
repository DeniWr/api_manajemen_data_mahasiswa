<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\PengumumanController;

Route::get('/test', function () {
    return response()->json(['message' => 'API is working']);
});

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('jwt.auth')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);

    // Mahasiswa
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);

    // Mahasiswa & Admin
    Route::get('/pengumuman', [PengumumanController::class, 'index']);
    Route::get('/pengumuman/{id}', [PengumumanController::class, 'show']);

    // Admin
    Route::middleware('admin')->group(function () {
        Route::get('/admin/mahasiswa', [AdminController::class, 'index']);
        Route::put('/admin/mahasiswa/{id}/activate', [AdminController::class, 'activate']);
        Route::put('/admin/mahasiswa/{id}/deactivate', [AdminController::class, 'deactivate']);

        Route::post('/admin/pengumuman', [PengumumanController::class, 'store']);
        Route::put('/admin/pengumuman/{id}', [PengumumanController::class, 'update']);
        Route::delete('/admin/pengumuman/{id}', [PengumumanController::class, 'destroy']);
    });
});
