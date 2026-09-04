<?php

use App\Models\Product;
use App\Models\Setting;

/** Places a real order and lands on the confirmation page. */
function placeOrder(array $overrides = []): void
{
    $product = Product::factory()->create(['price' => 200, 'stock' => 5] + $overrides);

    test()->post(route('cart.store'), ['product_id' => $product->id, 'quantity' => 1]);
    test()->post(route('checkout.store'), [
        'customer_name' => 'Marie-Christine de Bourbon-Parme',
        'customer_email' => 'marie@example.com',
        'address_line1' => '4 rue des Lilas',
        'postal_code' => '75011',
        'city' => 'Paris',
        'country' => 'FR',
    ]);
}

it('shows the order number as a copyable payment reference', function () {
    placeOrder();

    $response = $this->get(route('checkout.confirmation'))->assertOk();

    // The number is the transfer reference, so it gets its own callout rather than only
    // appearing inside a sentence.
    $response->assertSee('Numéro de commande')
        ->assertSee('confirmation-reference', false)
        ->assertSee('AM-');
});

it('lists the ordered lines with their totals, without a table', function () {
    placeOrder(['name' => 'Fauteuil béton']);

    $this->get(route('checkout.confirmation'))
        ->assertOk()
        ->assertSee('Fauteuil béton')
        ->assertSee('checkout-items', false)
        ->assertDontSee('<table', false);
});

it('says the delivery is free rather than showing 0.00', function () {
    Setting::current()->update(['free_shipping_threshold' => 150]);
    placeOrder(['price' => 400]);

    $this->get(route('checkout.confirmation'))
        ->assertOk()
        ->assertSee('Offerte');
});

it('shows the bank details needed to pay', function () {
    Setting::current()->update([
        'bank_iban' => 'FR76 3000 4000 0100 0012 3456 789',
        'bank_name' => 'Banque Populaire',
    ]);
    placeOrder();

    $this->get(route('checkout.confirmation'))
        ->assertOk()
        ->assertSee('FR76 3000 4000 0100 0012 3456 789')
        ->assertSee('Banque Populaire');
});

it('redirects home when there is no order in the session', function () {
    $this->get(route('checkout.confirmation'))->assertRedirect(route('home'));
});
