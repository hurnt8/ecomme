<?php

namespace App\Services;

class CheckoutService
{
    public function __construct(
        private readonly CartService $cart,
        private readonly ShippingService $shipping,
    ) {}

    /**
     * @return array{subtotal: float, shipping: float, tax: float, total: float, is_eurozone: bool}
     */
    public function summary(?string $countryCode): array
    {
        $subtotal = $this->cart->subtotal();
        $shipping = $this->shipping->calculateShipping($subtotal, $countryCode);
        $tax = $this->shipping->calculateTax($subtotal);

        return [
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'tax' => $tax,
            'total' => round($subtotal + $shipping + $tax, 2),
            'is_eurozone' => $this->shipping->isEurozone($countryCode),
        ];
    }
}
