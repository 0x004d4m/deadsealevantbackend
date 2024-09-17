<?php

use App\Http\Controllers\HomeController;
use App\Http\Middleware\GuestAuth;
use Illuminate\Support\Facades\Route;

Route::middleware(GuestAuth::class)->group(function () {
    Route::get('home', [HomeController::class, 'index']);
    Route::post('contact_requests', [HomeController::class, 'contactRequest']);
    Route::post('emails', [HomeController::class, 'email']);
    Route::get('products', [HomeController::class, 'products']);
    Route::get('products/{id}', [HomeController::class, 'product']);
});
