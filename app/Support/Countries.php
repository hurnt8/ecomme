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
        'FR' => 'Frankreich',
        'BE' => 'Belgien',
        'DE' => 'Deutschland',
        'ES' => 'Spanien',
        'IT' => 'Italien',
        'PT' => 'Portugal',
        'NL' => 'Niederlande',
        'AT' => 'Österreich',
        'IE' => 'Irland',
        'FI' => 'Finnland',
        'GR' => 'Griechenland',
        'LU' => 'Luxemburg',
        'SK' => 'Slowakei',
        'SI' => 'Slowenien',
        'EE' => 'Estland',
        'LV' => 'Lettland',
        'LT' => 'Litauen',
        'HR' => 'Kroatien',
        'CY' => 'Zypern',
        'MT' => 'Malta',
        'CH' => 'Schweiz',
        'GB' => 'Vereinigtes Königreich',
        'NO' => 'Norwegen',
        'SE' => 'Schweden',
        'DK' => 'Dänemark',
        'PL' => 'Polen',
        'CA' => 'Kanada',
        'US' => 'Vereinigte Staaten',
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
