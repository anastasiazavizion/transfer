<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ValidateController;
use App\Http\Controllers\GoogleMapsController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/validateCalculateForm', [ValidateController::class, 'validateCalculateForm'])->name('validateCalculateForm');

Route::get('/distanceDuration', [GoogleMapsController::class, 'distanceDuration'])->name('distanceDuration');
