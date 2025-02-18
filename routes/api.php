<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ValidateController;
use App\Http\Controllers\GoogleMapsController;
use App\Http\Controllers\LocaleController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/validateCalculateForm', [ValidateController::class, 'validateCalculateForm'])->name('validateCalculateForm');

Route::get('/distanceDuration', [GoogleMapsController::class, 'distanceDuration'])->name('distanceDuration');
Route::get('/coordinates', [GoogleMapsController::class, 'coordinates'])->name('coordinates');

Route::get('/locale/translations', [LocaleController::class, 'translations'])->name('locale.translations');
Route::post('/locale/{locale}', [LocaleController::class, 'store'])->name('locale.store');
Route::get('/locale/current', [LocaleController::class, 'currentLocale'])->name('locale.current');
