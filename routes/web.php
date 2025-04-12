<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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