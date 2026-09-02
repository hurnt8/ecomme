<?php

namespace App\Services;

use App\Support\Eurozone;

class ShippingService
{
    /**
     * Flat base shipping fee below the free-shipping threshold. Not stored
     * in settings — the reference this schema mirrors hardcodes it too.
     */
    public const BASE_SHIPPING_FEE = 9.99;

    public function __construct(private readonly SettingsService $settings) {}

    public function isEurozone(?string $countryCode): bool
    {
        return Eurozone::includes($countryCode);
    }

    public function calculateShipping(float $subtotal, ?string $countryCode): float
    {
        $settings = $this->settings->current();

        $base = $subtotal >= (float) $settings->free_shipping_threshold ? 0.0 : self::BASE_SHIPPING_FEE;
        $international = $this->isEurozone($countryCode) ? 0.0 : (float) $settings->international_shipping_fee;

        return round($base + $international, 2);
    }

    public function calculateTax(float $subtotal): float
    {
        return round($subtotal * (float) $this->settings->current()->tax_rate, 2);
    }
}
