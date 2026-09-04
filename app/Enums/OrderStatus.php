<?php

namespace App\Enums;

enum OrderStatus: string
{
    case Pending = 'pending';
    case Processing = 'processing';
    case Shipped = 'shipped';
    case Completed = 'completed';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'En attente',
            self::Processing => 'En préparation',
            self::Shipped => 'Expédiée',
            self::Completed => 'Terminée',
            self::Cancelled => 'Annulée',
        };
    }

    /**
     * What the status means for the customer, shown under each step of the tracking timeline.
     */
    public function description(): string
    {
        return match ($this) {
            self::Pending => 'Nous attendons la réception de votre virement.',
            self::Processing => 'Votre virement est validé, la commande est en cours de préparation.',
            self::Shipped => 'Votre commande a quitté notre atelier.',
            self::Completed => 'Votre commande vous a été livrée.',
            self::Cancelled => 'Cette commande a été annulée. Contactez-nous pour toute question.',
        };
    }

    /**
     * The linear path an order follows, for the customer-facing tracking timeline. Cancelled is
     * deliberately absent: it is a terminal branch off the path, not a step along it, and the
     * tracking view renders it on its own.
     */
    public static function trackingSteps(): array
    {
        return [self::Pending, self::Processing, self::Shipped, self::Completed];
    }

    /**
     * How far along `trackingSteps()` this status sits, or null when it is off that path.
     */
    public function trackingPosition(): ?int
    {
        $index = array_search($this, self::trackingSteps(), true);

        return $index === false ? null : $index;
    }

    /**
     * Statuses that count as "paid" once reached (mirrors the admin transition
     * rule: leaving pending/cancelled for anything else marks the order paid).
     */
    public function isPaid(): bool
    {
        return ! in_array($this, [self::Pending, self::Cancelled], true);
    }

    /**
     * Allowed forward transitions. Completed and cancelled are terminal —
     * an order that shipped or was cancelled by mistake gets fixed by
     * creating a new one, not by rewinding the status.
     */
    public function canTransitionTo(self $next): bool
    {
        if ($next === $this) {
            return true;
        }

        return match ($this) {
            self::Pending => in_array($next, [self::Processing, self::Cancelled], true),
            self::Processing => in_array($next, [self::Shipped, self::Cancelled], true),
            self::Shipped => in_array($next, [self::Completed, self::Cancelled], true),
            self::Completed, self::Cancelled => false,
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
