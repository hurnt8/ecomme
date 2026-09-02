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
