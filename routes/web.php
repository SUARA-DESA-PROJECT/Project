<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaporanController;

// route to Input Laporan
Route::post('/inputlaporan', [LaporanController::class, 'store'])->name('laporan.store');
Route::get('/inputlaporan/create', [LaporanController::class, 'create'])->name('laporan.create');

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PengurusLingkunganController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('LandingPage.landingpage');
})->name('/');

// route to landing page
Route::get('/landingpage', function () {
    return view('LandingPage.landingpage');
}) -> name('landingpage');

// route to login masyarakat
Route::get('/login-masyarakat', [AuthController::class, 'showLoginFormMasyarakat'])->name('login-masyarakat');
Route::post('/loginmasyarakat', [AuthController::class, 'loginMasyarakat'])->name('login.masyarakat');
Route::post('/logout-masyarakat', [AuthController::class, 'logoutMasyarakat'])->name('logout.masyarakat');

// route to login pengurus desa
Route::get('/login-kepaladesa', [AuthController::class, 'showLoginFormKepdes'])->name('login-kepaladesa');
Route::post('/login-kepaladesa', [AuthController::class, 'loginPengurus'])->name('login.pengurus');
Route::post('/logout-pengurus', [AuthController::class, 'logoutPengurus'])->name('logout.pengurus');

// route to homepage
Route::get('/homepage', function () {
    return view('homepage/homepage');
})->name('homepage');

// route to pengurus
Route::get('/pengurus', [PengurusLingkunganController::class, 'index'])->name('pengurus');
Route::put('/pengurus/{username}', [PengurusLingkunganController::class, 'update'])->name('pengurus.update');
Route::delete('/pengurus/{pengurus}', [PengurusLingkunganController::class, 'destroy'])->name('pengurus.destroy');
Route::post('/pengurus', [PengurusLingkunganController::class, 'store'])->name('pengurus.store');

// route to pengurus input form
Route::get('/pengurus/form', function () {
    return view('pengurus.form');
})->name('pengurus.form');

// route to registrasi
Route::get('/registrasi-masyarakat', function () {
    return view('registrasi/index');
})->name('registrasi-masyarakat');

Route::post('/registrasi', [WargaController::class, 'store'])->name('registrasi.store');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
Route::get('/kategori/{nama_kategori}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
Route::put('/kategori/{nama_kategori}', [KategoriController::class, 'update'])->name('kategori.update');
Route::delete('/kategori/{nama_kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
