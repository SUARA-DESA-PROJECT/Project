<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaporanController;

Route::get('/', function () {
    return view('homepage/homepage');
});

Route::get('/inputlaporan/create', [LaporanController::class, 'create'])->name('laporan.create');
Route::post('/inputlaporan', [LaporanController::class, 'store'])->name('laporan.store');

// Route::get('/input-laporan', [LaporanController::class, 'create'])->name('laporan.create');
// Route::post('/input-laporan', [LaporanController::class, 'store'])->name('laporan.store');
// Route::get('/laporan', [LaporanController::class, 'index'])->name('inputlaporan.index');
// Route::get('/laporan/{laporan}', [LaporanController::class, 'show'])->name('inputlaporan.show');
// Route::get('/laporan/{laporan}/edit', [LaporanController::class, 'edit'])->name('inputlaporan.edit');
// Route::put('/laporan/{laporan}', [LaporanController::class, 'update'])->name('inputlaporan.update');
// Route::delete('/laporan/{laporan}', [LaporanController::class, 'destroy'])->name('inputlaporan.destroy');