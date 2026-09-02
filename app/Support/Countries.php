<?php

namespace App\Support;

class Countries
{
    /**
     * ISO 3166-1 alpha-2 code => French display name, for the checkout
     * country selector. Not exhaustive — the countries this shop actually
     * ships to (eurozone, plus common non-eurozone destinations).
     */
    public const LIST = [
        'FR' => 'France',
        'BE' => 'Belgique',
        'DE' => 'Allemagne',
        'ES' => 'Espagne',
        'IT' => 'Italie',
        'PT' => 'Portugal',
        'NL' => 'Pays-Bas',
        'AT' => 'Autriche',
        'IE' => 'Irlande',
        'FI' => 'Finlande',
        'GR' => 'Grèce',
        'LU' => 'Luxembourg',
        'SK' => 'Slovaquie',
        'SI' => 'Slovénie',
        'EE' => 'Estonie',
        'LV' => 'Lettonie',
        'LT' => 'Lituanie',
        'HR' => 'Croatie',
        'CY' => 'Chypre',
        'MT' => 'Malte',
        'CH' => 'Suisse',
        'GB' => 'Royaume-Uni',
        'NO' => 'Norvège',
        'SE' => 'Suède',
        'DK' => 'Danemark',
        'PL' => 'Pologne',
        'CA' => 'Canada',
        'US' => 'États-Unis',
    ];

    public static function label(?string $code): ?string
    {
        return self::LIST[strtoupper((string) $code)] ?? null;
    }

    /**
     * French display names of the eurozone countries in {@see self::LIST},
     * for informational copy (e.g. the shipping page).
     *
     * @return array<int, string>
     */
    public static function eurozoneLabels(): array
    {
        return collect(Eurozone::COUNTRY_CODES)
            ->map(fn (string $code) => self::label($code) ?? $code)
            ->sort()
            ->values()
            ->all();
    }
}
