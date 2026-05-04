<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\BumdesController;
use App\Http\Controllers\LahanController;
use App\Http\Controllers\TanamanController;
use App\Http\Controllers\PanenController;
use App\Http\Controllers\KoperasiController;

// Auth
Route::get('/', fn() => redirect()->route('login'));
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Koperasi (single record)
    Route::get('/koperasi', [KoperasiController::class, 'index'])->name('koperasi.index');
    Route::get('/koperasi/edit', [KoperasiController::class, 'edit'])->name('koperasi.edit');
    Route::put('/koperasi', [KoperasiController::class, 'update'])->name('koperasi.update');

    // BUMDes — parameter eksplisit supaya route model binding cocok
    Route::resource('bumdes', BumdesController::class)
        ->parameters(['bumdes' => 'bumdes']);

    // Anggota/Petani — parameter eksplisit
    Route::resource('anggota', AnggotaController::class)
        ->parameters(['anggota' => 'anggota']);
    Route::patch('/anggota/{anggota}/approve', [AnggotaController::class, 'approve'])
        ->name('anggota.approve');

    // Lahan
    Route::resource('lahan', LahanController::class);

    // Tanaman
    Route::resource('tanaman', TanamanController::class);
    Route::get('/api/anggota/{anggota}/lahan', [TanamanController::class, 'getLahanByAnggota'])
        ->name('api.anggota.lahan');

    // Panen
    Route::resource('panen', PanenController::class);
    Route::get('/api/anggota/{anggota}/tanaman', [PanenController::class, 'getTanamanByAnggota'])
        ->name('api.anggota.tanaman');

});
