<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WargaController;

<<<<<<< HEAD
Route::get('/homepage', function () {
    return view('homepage/homepage');
=======
<<<<<<< Updated upstream
Route::get('/', function () {
    return view('welcome');
=======
Route::get('/homepage', function () {
    return view('homepage/homepage');
})->name('homepage');

Route::get('/', function () {
    return view('registrasi/index');
>>>>>>> Stashed changes
>>>>>>> fbdb894 (SDP-1 fitur registrasi)
});

// Registration route
Route::post('/registrasi', [WargaController::class, 'store'])->name('registrasi.store');
