<?php

use App\Models\Product;
use App\Services\CartService;

beforeEach(function () {
    $this->cart = app(CartService::class);
});

it('adds a product to an empty cart', function () {
    $product = Product::factory()->create(['price' => 50, 'stock' => 10]);

    $added = $this->cart->add($product, 2);

    expect($added)->toBeTrue()
        ->and($this->cart->count())->toBe(2)
        ->and($this->cart->subtotal())->toBe(100.0);
});

it('accumulates quantity when the same product/color/size is added again', function () {
    $product = Product::factory()->create(['price' => 20, 'stock' => 10]);

    $this->cart->add($product, 1, color: 'Noir', size: 'M');
    $this->cart->add($product, 2, color: 'Noir', size: 'M');

    expect($this->cart->count())->toBe(3);
});

it('keeps different colors/sizes of the same product as separate lines', function () {
    $product = Product::factory()->create(['price' => 20, 'stock' => 10]);

    $this->cart->add($product, 1, color: 'Noir', size: null);
    $this->cart->add($product, 1, color: 'Blanc', size: null);

    expect($this->cart->items())->toHaveCount(2);
});

it('caps the added quantity at available stock', function () {
    $product = Product::factory()->create(['stock' => 3]);

    $this->cart->add($product, 10);

    expect($this->cart->count())->toBe(3);
});

it('refuses to add an inactive product', function () {
    $product = Product::factory()->inactive()->create(['stock' => 10]);

    $added = $this->cart->add($product, 1);

    expect($added)->toBeFalse()
        ->and($this->cart->isEmpty())->toBeTrue();
});

it('refuses to add an out-of-stock product', function () {
    $product = Product::factory()->outOfStock()->create();

    $added = $this->cart->add($product, 1);

    expect($added)->toBeFalse();
});

it('updates a line quantity, capped at stock, and removes it at zero', function () {
    $product = Product::factory()->create(['stock' => 5]);
    $this->cart->add($product, 1);
    $key = $this->cart->items()->first()->key;

    $this->cart->updateQuantity($key, 5);
    expect($this->cart->count())->toBe(5);

    $this->cart->updateQuantity($key, 99);
    expect($this->cart->count())->toBe(5);

    $this->cart->updateQuantity($key, 0);
    expect($this->cart->isEmpty())->toBeTrue();
});

it('removes a line', function () {
    $product = Product::factory()->create(['stock' => 5]);
    $this->cart->add($product, 1);
    $key = $this->cart->items()->first()->key;

    $this->cart->remove($key);

    expect($this->cart->isEmpty())->toBeTrue();
});

it('flags a line as capped when stock drops below the cart quantity after it was added', function () {
    $product = Product::factory()->create(['stock' => 5]);
    $this->cart->add($product, 5);

    $product->update(['stock' => 2]);

    $item = $this->cart->items()->first();

    expect($item->quantity)->toBe(2)
        ->and($item->wasCapped)->toBeTrue()
        ->and($this->cart->hasAdjustments())->toBeTrue();
});

it('prunes a line for a product that became inactive', function () {
    $product = Product::factory()->create(['stock' => 5]);
    $this->cart->add($product, 1);

    $product->update(['is_active' => false]);

    expect($this->cart->items())->toHaveCount(0);
});

it('sums the subtotal across multiple lines', function () {
    $a = Product::factory()->create(['price' => 30, 'stock' => 10]);
    $b = Product::factory()->create(['price' => 45.5, 'stock' => 10]);

    $this->cart->add($a, 2);
    $this->cart->add($b, 1);

    expect($this->cart->subtotal())->toBe(105.5);
});

it('empties the cart on clear', function () {
    $product = Product::factory()->create(['stock' => 5]);
    $this->cart->add($product, 1);

    $this->cart->clear();

    expect($this->cart->isEmpty())->toBeTrue();
});
