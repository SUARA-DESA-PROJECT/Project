<?php

use Illuminate\Support\Facades\Route;

Route::get('/homepage', function () {
    return view('homepage/homepage');
})->name('homepage');

// route to registrasi
Route::get('/registrasi-masyarakat', function () {
    return view('registrasi/index');
})->name('registrasi-masyarakat');

Route::post('/registrasi', [WargaController::class, 'store'])->name('registrasi.store');

Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
Route::get('/kategori/{nama_kategori}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
Route::put('/kategori/{nama_kategori}', [KategoriController::class, 'update'])->name('kategori.update');
Route::delete('/kategori/{nama_kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');