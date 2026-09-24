<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case Supervisor = 'supervisor';
    case Customer = 'customer';

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Administrateur',
            self::Supervisor => 'Superviseur',
            self::Customer => 'Client',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::Admin => 'Accès complet : produits, catégories, bannières, commandes, réglages et utilisateurs.',
            self::Supervisor => 'Accès aux commandes uniquement : consultation et changement de statut.',
            self::Customer => 'Compte client, sans accès au back-office.',
        };
    }

    /**
     * The roles that may reach the back-office at all. Customer is deliberately absent: it is the
     * default for every sign-up, so listing it here would hand the admin area to the whole shop.
     *
     * @return array<int, self>
     */
    public static function staff(): array
    {
        return [self::Admin, self::Supervisor];
    }
}
