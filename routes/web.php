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
use App\Http\Controllers\KelompokTaniController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\DokumenPdfController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HargaPorangController;

// Auth
Route::get('/', fn() => view('welcome'))->name('home');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Public registration (Tani Mandiri / Kelompok Tani / BUMDes)
Route::get('/daftar', [PendaftaranController::class, 'showForm'])->name('daftar');
Route::post('/daftar', [PendaftaranController::class, 'store'])->name('daftar.store');
Route::get('/daftar/sukses', [PendaftaranController::class, 'sukses'])->name('daftar.sukses');
Route::redirect('/daftar-kelompok-tani', '/daftar');

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

    // Lifecycle actions (petani klik)
    Route::post('/tanaman/{tanaman}/konfirmasi-tanam', [TanamanController::class, 'konfirmasiTanam'])
        ->name('tanaman.konfirmasi-tanam');
    Route::post('/tanaman/{tanaman}/konfirmasi-panen', [TanamanController::class, 'konfirmasiPanen'])
        ->name('tanaman.konfirmasi-panen');
    Route::post('/tanaman/{tanaman}/tunda-panen', [TanamanController::class, 'tundaPanen'])
        ->name('tanaman.tunda-panen');
    Route::post('/tanaman/{tanaman}/gagal-panen', [TanamanController::class, 'gajalPanen'])
        ->name('tanaman.gagal-panen');

    // Harga Porang
    Route::get('/harga-porang', [HargaPorangController::class, 'index'])->name('harga-porang.index');
    Route::post('/harga-porang', [HargaPorangController::class, 'store'])->name('harga-porang.store');
    Route::delete('/harga-porang/{hargaPorang}', [HargaPorangController::class, 'destroy'])->name('harga-porang.destroy');
    Route::get('/api/harga-porang', [HargaPorangController::class, 'hargaAktifApi'])->name('api.harga-porang');

    // Panen
    Route::resource('panen', PanenController::class);
    Route::get('/api/anggota/{anggota}/tanaman', [PanenController::class, 'getTanamanByAnggota'])
        ->name('api.anggota.tanaman');

    // Dokumen PDF (superadmin only)
    Route::get('/dokumen-pdf', [DokumenPdfController::class, 'index'])->name('dokumen-pdf.index');
    Route::post('/dokumen-pdf', [DokumenPdfController::class, 'store'])->name('dokumen-pdf.store');
    Route::get('/dokumen-pdf/{dokumenPdf}/download', [DokumenPdfController::class, 'download'])->name('dokumen-pdf.download');
    Route::delete('/dokumen-pdf/{dokumenPdf}', [DokumenPdfController::class, 'destroy'])->name('dokumen-pdf.destroy');

    // User management (superadmin only)
    Route::resource('users', UserController::class)->except(['show']);

    // Kelompok Tani
    Route::resource('kelompok-tani', KelompokTaniController::class)
        ->parameters(['kelompok-tani' => 'kelompokTani']);
    Route::patch('/kelompok-tani/{kelompokTani}/approve', [KelompokTaniController::class, 'approve'])
        ->name('kelompok-tani.approve');
    Route::patch('/kelompok-tani/{kelompokTani}/reject', [KelompokTaniController::class, 'reject'])
        ->name('kelompok-tani.reject');

});
