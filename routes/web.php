<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('LandingPage.landingpage');
})->name('/');

// route to landing page
Route::get('/landingpage', function () {
    return view('LandingPage.landingpage');
}) -> name('landingpage');

// route to login masyarakat
Route::get('/loginmasyarakat', function () {
    return view('Login.loginmasyarakat');
});

// route to login masyarakat
Route::get('/login-masyarakat', function () {
    return view('Login.loginmasyarakat');
})->name('loginmasyarakat');

// route to login pengurus desa
Route::get('/login-kepala-desa', function () {
    return view('Login.loginpengurus');
})->name('loginpengurus');