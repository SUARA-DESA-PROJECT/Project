<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// route to landing page
Route::get('/landingpage', function () {
    return view('LandingPage.landingpage');
});
