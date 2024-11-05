<?php

use App\Models\Order;
use App\Notifications\TestNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // Notification::route('telegram', env('TELEGRAM_ADMIN_CHAT_ID'))
    // ->notify(new TestNotification()); Bb197310!@#
    // return view('welcome');
    return view('mail.order', [
        'Order' => Order::get()->last()
    ]);
});
