<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PengurusLingkunganController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;

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

// Homepage Route
Route::get('/homepage', [HomeController::class, 'index'])->name('homepage');
Route::get('/homepage-warga', [HomeController::class, 'index_warga'])->name('homepage-warga');

// route to Input Laporan
Route::post('/inputlaporan', [LaporanController::class, 'store'])->name('laporan.store');
Route::get('/inputlaporan/create', [LaporanController::class, 'create'])->name('laporan.create');

// Laporan Routes
Route::get('/inputlaporan/create', [LaporanController::class, 'create'])->name('laporan.create');
Route::post('/inputlaporan', [LaporanController::class, 'store'])->name('laporan.store');
Route::get('/input-laporan', [LaporanController::class, 'create'])->name('laporan.create');
Route::post('/input-laporan', [LaporanController::class, 'store'])->name('laporan.store');
Route::get('/laporan', [LaporanController::class, 'index'])->name('inputlaporan.index');
Route::get('/laporan/{laporan}', [LaporanController::class, 'show'])->name('inputlaporan.show');
Route::get('/laporan/{laporan}/edit', [LaporanController::class, 'edit'])->name('inputlaporan.edit');
Route::put('/laporan/{laporan}', [LaporanController::class, 'update'])->name('inputlaporan.update');
Route::delete('/laporan/{laporan}', [LaporanController::class, 'destroy'])->name('inputlaporan.destroy');
Route::get('/report-statistics', [LaporanController::class, 'getReportStatistics'])->name('report.statistics');

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

// Kategori Routes
Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
Route::get('/kategori/{nama_kategori}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
Route::put('/kategori/{nama_kategori}', [KategoriController::class, 'update'])->name('kategori.update');
Route::delete('/kategori/{nama_kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');


// Verifikasi Laporan Routes
Route::get('/verifikasilap', [LaporanController::class, 'indexVerifikasi'])->name('verifikasilap.index');
Route::post('/laporan/update-status', [App\Http\Controllers\LaporanController::class, 'updateStatus']);