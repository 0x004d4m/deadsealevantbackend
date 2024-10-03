<?php

use App\Http\Controllers\CustomerAddressController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\CustomerOrderController;
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
        Route::post('change_password', [CustomerAuthController::class, 'changePassword']);
        Route::put('profile', [CustomerAuthController::class, 'profile']);
        Route::apiResource('addresses', CustomerAddressController::class);
        Route::get('orders', [CustomerOrderController::class, 'index']);
        Route::post('orders/{order_id}/cart_items/{cart_item_id}', [CustomerOrderController::class, 'review']);
    });
});
