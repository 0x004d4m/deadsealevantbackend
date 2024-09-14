<?php

use App\Http\Controllers\CartController;
use App\Http\Middleware\GuestAuth;
use Illuminate\Support\Facades\Route;

Route::middleware(GuestAuth::class)->group(function () {
    Route::prefix('carts')->group(function () {
        Route::get('/', [CartController::class, 'index']);
        Route::post('/', [CartController::class, 'store']);
        Route::put('/', [CartController::class, 'update']);
        Route::delete('/{id}', [CartController::class, 'destroy']);
    });
});
