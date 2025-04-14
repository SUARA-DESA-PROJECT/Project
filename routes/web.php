<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WargaController;

Route::get('/homepage', function () {
    return view('homepage/homepage');
})->name('homepage');

Route::get('/', function () {
    return view('registrasi/index');
});

// Registration route
Route::post('/registrasi', [WargaController::class, 'store'])->name('registrasi.store');
