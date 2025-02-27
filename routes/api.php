<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ValidateController;
use App\Http\Controllers\GoogleMapsController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MessengerController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/validateCalculateForm', [ValidateController::class, 'validateCalculateForm'])->name('validateCalculateForm');

Route::get('/distanceDuration', [GoogleMapsController::class, 'distanceDuration'])->name('distanceDuration');
Route::get('/coordinates', [GoogleMapsController::class, 'coordinates'])->name('coordinates');

Route::get('/cars', [CarController::class, 'index'])->name('cars');

Route::apiResource('orders', OrderController::class);
Route::apiResource('messengers', MessengerController::class)->only(['index']);
