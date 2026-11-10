<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\KendaraanDinasController;
use App\Http\Controllers\Api\V1\PegawaiController;
use App\Http\Controllers\Api\V1\PerangkatDaerahController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('auth/login', [AuthController::class, 'login'])
        ->middleware(['throttle:login', 'throttle:login-ip'])
        ->name('auth.login');

    Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {
        Route::post('auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
        Route::get('auth/me', [AuthController::class, 'me'])->name('auth.me');

        Route::apiResource('perangkat-daerah', PerangkatDaerahController::class)
            ->parameters(['perangkat-daerah' => 'perangkatDaerah']);

        Route::apiResource('pegawai', PegawaiController::class);
        Route::post('pegawai/{pegawai}/akun', [PegawaiController::class, 'createAccount'])
            ->middleware('admin')
            ->name('pegawai.akun.store');

        Route::apiResource('kendaraan-dinas', KendaraanDinasController::class)
            ->parameters(['kendaraan-dinas' => 'kendaraanDinas']);

        Route::middleware('admin')->group(function () {
            Route::apiResource('users', UserController::class)
                ->only(['index', 'store', 'show', 'update']);
            Route::put('users/{user}/status', [UserController::class, 'updateStatus'])
                ->name('users.status');
            Route::post('users/{user}/reset-password', [UserController::class, 'resetPassword'])
                ->name('users.reset-password');
        });
    });
});
