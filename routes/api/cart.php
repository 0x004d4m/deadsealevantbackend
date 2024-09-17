<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Middleware\CustomerAuth;
use App\Http\Middleware\GuestAuth;
use Illuminate\Support\Facades\Route;

Route::middleware(GuestAuth::class)->group(function () {
    Route::prefix('carts')->group(function () {
        Route::get('/', [CartController::class, 'index']);
        Route::post('/', [CartController::class, 'store']);
        Route::put('/', [CartController::class, 'update']);
    });
});

Route::middleware(CustomerAuth::class)->group(function () {
    Route::prefix('orders')->group(function () {
        Route::post('/', [OrderController::class, 'store']);
    });
});
