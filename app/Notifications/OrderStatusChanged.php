<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusChanged extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public readonly Order $order) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Ihre Bestellung {$this->order->order_number} — {$this->order->status->label()}")
            ->greeting("Guten Tag {$this->order->customer_name},")
            ->line("Der Status Ihrer Bestellung {$this->order->order_number} wurde aktualisiert: **{$this->order->status->label()}**.")
            ->action('Bestellung verfolgen', route('tracking.index'))
            ->line('Geben Sie auf unserer Seite zur Sendungsverfolgung Ihre Bestellnummer und Ihre E-Mail-Adresse ein.')
            // Without this, Laravel falls back to its own English "Regards,".
            ->salutation('Mit freundlichen Grüßen,');
    }
}
