<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\Telegram\TelegramMessage;
use Illuminate\Notifications\Notification;

class OrderBookedNotification extends Notification
{
    use Queueable;

    public function __construct(protected Order $order) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['telegram'];
    }

    public function toTelegram($notifiable)
    {
        $user = "";
        if ($this->order->customer) {
            $user = $this->order->customer->first_name . " " . $this->order->customer->last_name;
        }
        if ($this->order->guest) {
            $user = $this->order->guest->first_name . " " . $this->order->guest->last_name;
        }
        return TelegramMessage::create()
            ->to(env('TELEGRAM_ADMIN_CHAT_ID'))  // Send to admin
            ->content("A new order has been booked!\n\n" .
                "Customer: {$user}\n" .
                "Total: {$this->order->total}")
            ->button('View Order', url("/admin/order/{$this->order->id}/show"));
    }
}
