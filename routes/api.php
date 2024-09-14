<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CustomerPaymentMethodController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PaymentController;
use App\Http\Middleware\CustomerAuth;
use App\Http\Middleware\GuestAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('languages', [LanguageController::class, 'index']);
Route::get('home', [HomeController::class, 'index']);
Route::post('contact_requests', [HomeController::class, 'contactRequest']);
Route::post('emails', [HomeController::class, 'email']);
Route::get('products', [HomeController::class, 'products']);

require 'customer/auth.php';

Route::middleware(GuestAuth::class)->group(function () {
    Route::prefix('carts')->group(function () {
        Route::get('/', [CartController::class, 'index']);
        Route::post('/', [CartController::class, 'store']);
        Route::put('/', [CartController::class, 'update']);
        Route::delete('/{id}', [CartController::class, 'destroy']);
    });
});
