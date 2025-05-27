<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\RegionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::get('/locations', [LocationController::class, 'index']);
Route::get('/laporans', [LaporanController::class, 'getLaporanData']);
Route::get('/regions-geojson', [RegionController::class, 'getRegionsGeoJson']);