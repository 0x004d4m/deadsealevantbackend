<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('home', [HomeController::class, 'index']);
Route::post('contact_requests', [HomeController::class, 'contactRequest']);
Route::post('emails', [HomeController::class, 'email']);
Route::get('products', [HomeController::class, 'products']);
