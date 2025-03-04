<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ValidateController;
use App\Http\Controllers\GoogleMapsController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\MessengerController;
use App\Http\Controllers\StatusController;
use App\Http\Middleware\IsAdminMiddleware;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/validateCalculateForm', [ValidateController::class, 'validateCalculateForm'])->name('validateCalculateForm');

Route::get('/distanceDuration', [GoogleMapsController::class, 'distanceDuration'])->name('distanceDuration');
Route::get('/coordinates', [GoogleMapsController::class, 'coordinates'])->name('coordinates');

Route::get('/cars', [CarController::class, 'index'])->name('cars');

Route::apiResource('orders', OrderController::class);
Route::apiResource('messengers', MessengerController::class)->only(['index']);


Route::middleware('auth:sanctum')->group(function (){
    Route::get('/user', [UserController::class, 'user'])->name('user');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::apiResource('admin_orders', AdminOrderController::class)->except(['create', 'store'])
        ->parameters([
        'admin_orders' => 'order',
    ])->middleware([IsAdminMiddleware::class]);
    Route::apiResource('statuses', StatusController::class)->only(['index']);
});

Route::post('/login', [AuthController::class, 'authenticate'])->name('login');
