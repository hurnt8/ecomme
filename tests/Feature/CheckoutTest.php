<?php

use App\Enums\UserRole;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

function checkoutPayload(): array
{
    return [
        'customer_name' => 'Camille Dupont',
        'customer_email' => 'camille@example.com',
        'address_line1' => '12 rue des Lilas',
        'postal_code' => '75011',
        'city' => 'Paris',
        'country' => 'FR',
    ];
}

it('places an order, decrements stock, and snapshots the order number', function () {
    Mail::fake();
    $product = Product::factory()->create(['price' => 89, 'stock' => 5]);

    $this->post(route('cart.store'), ['product_id' => $product->id, 'quantity' => 2]);

    $this->post(route('checkout.store'), checkoutPayload())
        ->assertRedirect(route('checkout.confirmation'));

    $order = Order::sole();

    expect($order->order_number)->toMatch('/^AM-\d{8}-[A-Z0-9]{4}$/')
        ->and($order->status->value)->toBe('pending')
        ->and($order->items)->toHaveCount(1)
        ->and($order->items->first()->quantity)->toBe(2)
        ->and((float) $order->subtotal)->toBe(178.0)
        ->and($product->fresh()->stock)->toBe(3);
});

it('links the order to the authenticated customer', function () {
    Mail::fake();
    $user = User::factory()->create(['role' => UserRole::Customer]);
    $product = Product::factory()->create(['stock' => 5]);

    $this->actingAs($user)
        ->post(route('cart.store'), ['product_id' => $product->id, 'quantity' => 1]);

    $this->post(route('checkout.store'), checkoutPayload());

    expect(Order::sole()->user_id)->toBe($user->id);
});

it('refuses to place an order when stock ran out after it was added to the cart', function () {
    Mail::fake();
    $product = Product::factory()->create(['stock' => 5]);

    $this->post(route('cart.store'), ['product_id' => $product->id, 'quantity' => 5]);

    // Someone else buys the stock out from under this cart before checkout.
    $product->update(['stock' => 1]);

    $this->post(route('checkout.store'), checkoutPayload())
        ->assertRedirect();

    expect(Order::count())->toBe(0)
        ->and($product->fresh()->stock)->toBe(1);
});

it('rejects checkout with an empty cart', function () {
    $this->get(route('checkout.index'))->assertRedirect(route('cart.index'));
});

it('serves the invoice PDF via a signed link and rejects a tampered one', function () {
    Mail::fake();
    $product = Product::factory()->create(['stock' => 5]);
    $this->post(route('cart.store'), ['product_id' => $product->id, 'quantity' => 1]);
    $this->post(route('checkout.store'), checkoutPayload());
    $order = Order::sole();

    $signedUrl = URL::signedRoute('orders.invoice', ['order' => $order->order_number]);
    $this->get($signedUrl)->assertOk()->assertHeader('content-type', 'application/pdf');

    $tampered = $signedUrl.'&tampered=1';
    $this->get($tampered)->assertForbidden();
});

it('does not serve a receipt for an unpaid order', function () {
    Mail::fake();
    $product = Product::factory()->create(['stock' => 5]);
    $this->post(route('cart.store'), ['product_id' => $product->id, 'quantity' => 1]);
    $this->post(route('checkout.store'), checkoutPayload());
    $order = Order::sole();

    $signedUrl = URL::signedRoute('orders.receipt', ['order' => $order->order_number]);
    $this->get($signedUrl)->assertNotFound();
});
