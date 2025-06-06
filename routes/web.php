<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PengurusLingkunganController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaporanPengurusController;
use App\Http\Controllers\ResponController;
use App\Http\Controllers\RiwayatLaporanPengurusController;
use App\Http\Controllers\KomentarWargaController;
use App\Models\Laporan;
use App\Http\Controllers\ProfilePengurusController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KomentarPengurusController;
use App\Http\Controllers\LogoutController;

// Landing Page Routes
Route::get('/', function () {
    return view('LandingPage.landingpage');
})->name('/');
Route::get('/landingpage', function () {
    return view('LandingPage.landingpage');
})->name('landingpage');

// Authentication Routes
Route::get('/login-masyarakat', [AuthController::class, 'showLoginFormMasyarakat'])->name('login-masyarakat');
Route::post('/loginmasyarakat', [AuthController::class, 'loginMasyarakat'])->name('login.masyarakat');
Route::post('/logout-masyarakat', [AuthController::class, 'logoutMasyarakat'])->name('logout.masyarakat');
Route::get('/login-kepaladesa', [AuthController::class, 'showLoginFormKepdes'])->name('login-kepaladesa');
Route::post('/login-kepaladesa', [AuthController::class, 'loginPengurus'])->name('login.pengurus');
Route::post('/logout-pengurus', [AuthController::class, 'logoutPengurus'])->name('logout.pengurus');
Route::get('/login-admin', [AuthController::class, 'showLoginFormAdmin'])->name('login-admin');
Route::post('/login-admin', [AuthController::class, 'loginAdmin'])->name('login.admin');
Route::post('/logout-admin', [AuthController::class, 'logoutAdmin'])->name('logout.admin');
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

// Admin Routes
Route::middleware(['auth.admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/create', [AdminController::class, 'create'])->name('admin.create');
    Route::post('/admin', [AdminController::class, 'store'])->name('admin.store');
    Route::get('/admin/{admin}', [AdminController::class, 'show'])->name('admin.show');
    Route::get('/admin/{admin}/edit', [AdminController::class, 'edit'])->name('admin.edit');
    Route::put('/admin/{admin}', [AdminController::class, 'update'])->name('admin.update');
    Route::delete('/admin/{admin}', [AdminController::class, 'destroy'])->name('admin.destroy');
});

// Homepage Route
Route::get('/homepage', [HomeController::class, 'index'])->name('homepage');
Route::get('/homepage-warga', [HomeController::class, 'index_warga'])->name('homepage-warga');
Route::get('/peta-persebaran-warga', [HomeController::class, 'petaPersebaranWarga'])->name('peta.persebaran.warga');


// Laporan Routes Warga (RIDWAN)
Route::get('/inputlaporan/create', [LaporanController::class, 'create'])->name('laporan.create');
Route::post('/inputlaporan', [LaporanController::class, 'store'])->name('laporan.store');
Route::get('/input-laporan', [LaporanController::class, 'create'])->name('laporan.create');
Route::get('/laporan', [LaporanController::class, 'index'])->name('inputlaporan.index');
Route::get('/laporan/{laporan}', [LaporanController::class, 'show'])->name('inputlaporan.show');

Route::get('/laporan/{laporan}/edit', [LaporanController::class, 'edit'])->name('inputlaporan.edit');
Route::put('/laporan/{laporan}', [LaporanController::class, 'update'])->name('inputlaporan.update');

Route::delete('/laporan/{laporan}', [LaporanController::class, 'destroy'])->name('inputlaporan.destroy');
Route::get('/report-statistics', [LaporanController::class, 'getReportStatistics'])->name('report.statistics');
Route::get('/riwayat-laporan', [LaporanController::class, 'riwayatLaporan'])->name('riwayat-laporan.index');
Route::get('/report-statistics-warga', [LaporanController::class, 'getReportStatisticsWarga'])->name('report.statistics-warga');
Route::get('/export-pdf', [LaporanController::class, 'exportPDF'])->name('export-pdf');

// Route Laporan Pengurus (JESANO)
Route::get('/inputlaporan/create-pengurus', [LaporanPengurusController::class, 'create'])->name('laporan.create-pengurus');
Route::post('/inputlaporan-pengurus', [LaporanPengurusController::class, 'store'])->name('laporan.store-pengurus');
Route::get('/laporan-pengurus/{laporan}', [LaporanPengurusController::class, 'show'])->name('laporan.show-pengurus');
Route::get('/laporan-pengurus/{laporan}/edit', [LaporanPengurusController::class, 'edit'])->name('laporan.edit-pengurus');
Route::put('/laporan-pengurus/{laporan}', [LaporanPengurusController::class, 'update'])->name('laporan.update-pengurus');
Route::delete('/laporan-pengurus/{laporan}', [LaporanPengurusController::class, 'destroy'])->name('laporan.destroy-pengurus');

// Pengurus Routes
Route::get('/pengurus', [PengurusLingkunganController::class, 'index'])->name('pengurus');
Route::put('/pengurus/{username}', [PengurusLingkunganController::class, 'update'])->name('pengurus.update');
Route::delete('/pengurus/{pengurus}', [PengurusLingkunganController::class, 'destroy'])->name('pengurus.destroy');
Route::post('/pengurus', [PengurusLingkunganController::class, 'store'])->name('pengurus.store');
Route::get('/pengurus/form', function () {
    return view('pengurus.form');
})->name('pengurus.form');

// Registration Routes
Route::get('/registrasi-masyarakat', function () {
    return view('registrasi/index');
})->name('registrasi-masyarakat');
Route::post('/registrasi', [WargaController::class, 'store'])->name('registrasi.store');

// Dashboard Route
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

// Kategori Routes (VETA)
Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
Route::get('/kategori/{nama_kategori}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
Route::put('/kategori/{nama_kategori}', [KategoriController::class, 'update'])->name('kategori.update');
Route::delete('/kategori/{nama_kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

// Verifikasi Laporan Routes
Route::get('/verifikasilap', [LaporanController::class, 'indexVerifikasi'])->name('verifikasilap.index');
Route::put('/verifikasilap/{id_laporan}/verify', [LaporanController::class, 'verify'])->name('verifikasilap.verify');
Route::put('/verifikasilap/{id_laporan}/unverify', [LaporanController::class, 'unverify'])->name('verifikasilap.unverify');
Route::post('/laporan/update-status', [LaporanController::class, 'updateStatus']);
Route::put('/verifikasilap/{id}/reject', [LaporanController::class, 'reject'])->name('verifikasilap.reject');

// Verifikasi Akun routes
Route::get('/verifikasi-akun', [WargaController::class, 'verifikasiIndex'])->name('warga.verifikasi');
Route::put('/verifikasi-akun/{username}/verify', [WargaController::class, 'verifyWarga'])->name('warga.verify');
Route::put('/verifikasi-akun/{username}/unverify', [WargaController::class, 'unverifyWarga'])->name('warga.unverify');

// Respon Laporan Routes
Route::get('/respon-laporan', [ResponController::class, 'index'])->name('respon.index');
Route::get('/respon-laporan/{id}/edit', [ResponController::class, 'edit'])->name('respon.edit');
Route::put('/respon-laporan/{id}', [ResponController::class, 'update'])->name('respon.update');
Route::get('/test-respon-edit/{laporan}', function($laporan) {dd('Test route working', $laporan);})->name('test.respon');

// Profile routes
Route::get('/profile/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile/update', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

// Komentar Routes
// Komentar Warga Routes
Route::get('/forum-diskusi', [KomentarWargaController::class, 'index'])->name('komentar.index');
Route::post('/komentar', [KomentarWargaController::class, 'store'])->name('komentar.store');
Route::get('/komentar/{komentar}/edit', [KomentarWargaController::class, 'edit'])->name('komentar.edit');
Route::put('/komentar/{komentar}', [KomentarWargaController::class, 'update'])->name('komentar.update');
Route::delete('/komentar/{komentar}', [KomentarWargaController::class, 'destroy'])->name('komentar.destroy');

// Pengurus Laporan Routes
Route::prefix('pengurus')->group(function () {
    Route::get('/riwayat-laporan', [LaporanPengurusController::class, 'index'])->name('laporanpengurus.index');
    Route::get('/riwayat-laporan/{id}/edit', [LaporanPengurusController::class, 'edit'])->name('laporanpengurus.edit');
    Route::put('/riwayat-laporan/{id}', [LaporanPengurusController::class, 'update'])->name('laporanpengurus.update');
    Route::delete('/riwayat-laporan/{id}', [LaporanPengurusController::class, 'destroy'])->name('laporanpengurus.destroy');

    // Kelola Laporan Pengurus Routes
    Route::get('/kelola-laporan', [RiwayatLaporanPengurusController::class, 'index'])->name('pengurus.kelola-laporan.index');
    Route::get('/kelola-laporan/{id}/edit', [RiwayatLaporanPengurusController::class, 'edit'])->name('pengurus.kelola-laporan.edit');
    Route::put('/kelola-laporan/{id}', [RiwayatLaporanPengurusController::class, 'update'])->name('pengurus.kelola-laporan.update');
    Route::delete('/kelola-laporan/{id}', [RiwayatLaporanPengurusController::class, 'destroy'])->name('pengurus.kelola-laporan.destroy');
});

// Riwayat Laporan Pengurus Routes
Route::prefix('pengurus')->group(function () {
    Route::get('/riwayat-laporan-saya', [RiwayatLaporanPengurusController::class, 'index'])
        ->name('pengurus.riwayat.index');
    Route::get('/riwayat-laporan-saya/{id}/edit', [RiwayatLaporanPengurusController::class, 'edit'])
        ->name('pengurus.riwayat.edit');
    Route::put('/riwayat-laporan-saya/{id}', [RiwayatLaporanPengurusController::class, 'update'])
        ->name('pengurus.riwayat.update');
    Route::delete('/riwayat-laporan-saya/{id}', [RiwayatLaporanPengurusController::class, 'destroy'])
        ->name('pengurus.riwayat.destroy');
    Route::get('/export-pdf', [LaporanPengurusController::class, 'exportPDF'])->name('export-pdf');
});

// Profile Pengurus Routes
Route::get('/profile-pengurus/edit', [ProfilePengurusController::class, 'edit'])->name('profile-pengurus.edit');
Route::put('/profile-pengurus/update', [ProfilePengurusController::class, 'update'])->name('profile-pengurus.update');

// Komentar Pengurus Routes
Route::get('/komentarpengurus', [KomentarPengurusController::class, 'index'])->name('komentarpengurus.index');
Route::post('/komentarpengurus', [KomentarPengurusController::class, 'store'])->name('komentarpengurus.store');
Route::get('/komentarpengurus/{komentar}/edit', [KomentarPengurusController::class, 'edit'])->name('komentarpengurus.edit');
Route::put('/komentarpengurus/{komentar}', [KomentarPengurusController::class, 'update'])->name('komentarpengurus.update');
Route::delete('/komentarpengurus/{komentar}', [KomentarPengurusController::class, 'destroy'])->name('komentarpengurus.destroy');

// Tambahkan routes baru
Route::get('/respon/{id}/edit-rejection', [ResponController::class, 'editRejection'])->name('respon.editRejection');
Route::put('/respon/{id}/update-rejection', [ResponController::class, 'updateRejection'])->name('respon.updateRejection');