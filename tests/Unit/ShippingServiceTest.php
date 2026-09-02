<?php

use App\Models\Setting;
use App\Services\ShippingService;

beforeEach(function () {
    Setting::current()->update([
        'tax_rate' => 0.20,
        'free_shipping_threshold' => 100,
        'international_shipping_fee' => 25,
    ]);

    $this->shipping = app(ShippingService::class);
});

it('charges the flat base fee below the free-shipping threshold in the eurozone', function () {
    $fee = $this->shipping->calculateShipping(subtotal: 50, countryCode: 'FR');

    expect($fee)->toBe(ShippingService::BASE_SHIPPING_FEE);
});

it('waives the base fee at or above the free-shipping threshold in the eurozone', function () {
    $fee = $this->shipping->calculateShipping(subtotal: 100, countryCode: 'DE');

    expect($fee)->toBe(0.0);
});

it('adds the international fee on top of the base fee outside the eurozone', function () {
    $fee = $this->shipping->calculateShipping(subtotal: 50, countryCode: 'US');

    expect($fee)->toBe(round(ShippingService::BASE_SHIPPING_FEE + 25, 2));
});

it('still charges the international fee outside the eurozone even above the free-shipping threshold', function () {
    $fee = $this->shipping->calculateShipping(subtotal: 150, countryCode: 'US');

    expect($fee)->toBe(25.0);
});

it('treats every eurozone member the same way', function () {
    expect($this->shipping->isEurozone('FR'))->toBeTrue()
        ->and($this->shipping->isEurozone('DE'))->toBeTrue()
        ->and($this->shipping->isEurozone('US'))->toBeFalse()
        ->and($this->shipping->isEurozone('GB'))->toBeFalse()
        ->and($this->shipping->isEurozone(null))->toBeFalse();
});

it('computes tax as a rounded percentage of the subtotal', function () {
    expect($this->shipping->calculateTax(99.99))->toBe(20.0);
});
