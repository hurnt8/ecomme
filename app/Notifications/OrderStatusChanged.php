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
            ->subject("Votre commande {$this->order->order_number} — {$this->order->status->label()}")
            ->greeting("Bonjour {$this->order->customer_name},")
            ->line("Le statut de votre commande {$this->order->order_number} a été mis à jour : **{$this->order->status->label()}**.")
            ->action('Suivre ma commande', url('/suivi'))
            ->line('Pour suivre votre commande, renseignez son numéro et votre e-mail sur notre page de suivi.');
    }
}
