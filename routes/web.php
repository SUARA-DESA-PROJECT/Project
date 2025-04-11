<?php

use Illuminate\Support\Facades\Route;

Route::get('/homepage', function () {
    return view('homepage/homepage');
});
