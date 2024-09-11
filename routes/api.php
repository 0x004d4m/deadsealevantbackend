<?php

use App\Http\Controllers\CustomerPaymentMethodController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('languages', [LanguageController::class, 'index']);
Route::get('home', [HomeController::class, 'index']);
Route::post('contact_requests', [HomeController::class, 'contactRequest']);
Route::get('products', [HomeController::class, 'products']);
Route::post('/payment', [PaymentController::class, 'processPayment']);

Route::middleware('auth:api')->group(function () {
    Route::post('/card-details', [CustomerPaymentMethodController::class, 'store']);
    Route::get('/card-details', [CustomerPaymentMethodController::class, 'index']);
    Route::get('/card-details/{id}', [CustomerPaymentMethodController::class, 'show']);
    Route::put('/card-details/{id}', [CustomerPaymentMethodController::class, 'update']);
    Route::delete('/card-details/{id}', [CustomerPaymentMethodController::class, 'destroy']);
});

require 'customer/auth.php';
