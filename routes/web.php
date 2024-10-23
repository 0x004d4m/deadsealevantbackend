<?php

use App\Models\Order;
use App\Notifications\OrderBookedNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    Notification::route('telegram', env('TELEGRAM_ADMIN_CHAT_ID'))
    ->notify(new OrderBookedNotification());
    return view('welcome');
});
