<?php

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\Product;

function trackableOrder(OrderStatus $status = OrderStatus::Pending): Order
{
    $order = Order::factory()->create([
        'customer_email' => 'camille@example.com',
        'status' => $status,
        'subtotal' => 350,
        'shipping' => 0,
        'total' => 420,
    ]);

    $product = Product::factory()->create(['name' => 'Fauteuil béton']);
    $order->items()->create([
        'product_id' => $product->id,
        'product_name' => $product->name,
        'unit_price' => 350,
        'quantity' => 1,
    ]);

    return $order;
}

it('marks the steps before the current status as done and the rest as upcoming', function () {
    $order = trackableOrder(OrderStatus::Shipped);

    $html = $this->post(route('tracking.search'), [
        'order_number' => $order->order_number,
        'email' => 'camille@example.com',
    ])->assertOk()->getContent();

    $timeline = substr($html, strpos($html, 'tracking-timeline'), 1600);

    // Pending and Processing behind it, Shipped current, Completed still to come.
    expect(substr_count($timeline, 'is-done'))->toBe(2)
        ->and(substr_count($timeline, 'is-current'))->toBe(1);
});

it('shows a cancelled order outside the timeline', function () {
    $order = trackableOrder(OrderStatus::Cancelled);

    $this->post(route('tracking.search'), [
        'order_number' => $order->order_number,
        'email' => 'camille@example.com',
    ])
        ->assertOk()
        ->assertSee('Annulée')
        ->assertSee('tracking-cancelled', false)
        ->assertDontSee('tracking-timeline', false);
});

it('lists the ordered lines without a table', function () {
    $order = trackableOrder();

    $this->post(route('tracking.search'), [
        'order_number' => $order->order_number,
        'email' => 'camille@example.com',
    ])
        ->assertOk()
        ->assertSee('Fauteuil béton')
        ->assertSee('checkout-items', false)
        ->assertDontSee('<table', false);
});

it('matches the order number case-insensitively but still requires the right email', function () {
    $order = trackableOrder();

    $this->post(route('tracking.search'), [
        'order_number' => strtolower($order->order_number),
        'email' => 'camille@example.com',
    ])->assertOk()->assertSee($order->order_number);

    $this->post(route('tracking.search'), [
        'order_number' => $order->order_number,
        'email' => 'someone.else@example.com',
    ])->assertOk()->assertSee('Aucune commande trouvée');
});

it('places each status correctly on the tracking path', function () {
    expect(OrderStatus::Pending->trackingPosition())->toBe(0)
        ->and(OrderStatus::Processing->trackingPosition())->toBe(1)
        ->and(OrderStatus::Shipped->trackingPosition())->toBe(2)
        ->and(OrderStatus::Completed->trackingPosition())->toBe(3)
        // Cancelled is a branch off the path, not a step along it.
        ->and(OrderStatus::Cancelled->trackingPosition())->toBeNull();
});
