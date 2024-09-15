<?php

use App\Http\Controllers\CustomerAddressController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Middleware\CustomerAuth;
use Illuminate\Support\Facades\Route;

Route::prefix('customers')->group(function(){
    Route::post('register', [CustomerAuthController::class, 'register']);
    Route::post('register_otp', [CustomerAuthController::class, 'registerOtp']);
    Route::post('login', [CustomerAuthController::class, 'login']);
    Route::post('forget', [CustomerAuthController::class, 'forget']);
    Route::post('forget_otp', [CustomerAuthController::class, 'forgetOtp']);
    Route::post('reset_password', [CustomerAuthController::class, 'resetPassword']);
    Route::middleware(CustomerAuth::class)->group(function() {
        Route::post('logout', [CustomerAuthController::class, 'logout']);
        Route::put('profile', [CustomerAuthController::class, 'profile']);
        Route::apiResource('addresses', CustomerAddressController::class);
    });
});
