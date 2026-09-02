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

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
