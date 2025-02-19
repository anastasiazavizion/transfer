<?php

use App\Http\Controllers\LocaleController;
use Illuminate\Support\Facades\Route;

Route::get('/locale/translations', [LocaleController::class, 'translations'])->name('locale.translations');
Route::post('/locale/{locale}', [LocaleController::class, 'store'])->name('locale.store');
Route::get('/locale/current', [LocaleController::class, 'currentLocale'])->name('locale.current');

Route::get('{any}', function () {
    return view('app');
})->where('any', '.*');
