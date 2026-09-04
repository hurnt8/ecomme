<?php

use App\Models\Product;
use App\Models\Setting;
use App\Services\CartService;

it('shows a line, its total and a way to remove it', function () {
    $product = Product::factory()->create(['name' => 'Fauteuil béton', 'price' => 350, 'stock' => 10]);

    $this->post(route('cart.store'), ['product_id' => $product->id, 'quantity' => 2]);

    $this->get(route('cart.index'))
        ->assertOk()
        ->assertSee($product->name)
        ->assertSee('700')
        // The table this replaced pushed both of these off a phone screen entirely.
        ->assertSee('cart-line-remove', false)
        ->assertSee('cart-line-total', false);
});

it('removes a line from the cart', function () {
    $product = Product::factory()->create(['stock' => 10]);
    $this->post(route('cart.store'), ['product_id' => $product->id, 'quantity' => 1]);

    $key = app(CartService::class)->items()->first()->key;

    $this->delete(route('cart.destroy', $key))->assertRedirect();

    $this->get(route('cart.index'))->assertOk()->assertSee('Votre panier est vide');
});

it('tells the shopper how much more is needed for free shipping', function () {
    Setting::current()->update(['free_shipping_threshold' => 150]);
    $product = Product::factory()->create(['price' => 90, 'stock' => 10]);

    $this->post(route('cart.store'), ['product_id' => $product->id, 'quantity' => 1]);

    $this->get(route('cart.index'))
        ->assertOk()
        ->assertSee('pour la livraison offerte')
        ->assertSee('60');
});

it('confirms free shipping once the threshold is reached', function () {
    Setting::current()->update(['free_shipping_threshold' => 150]);
    $product = Product::factory()->create(['price' => 200, 'stock' => 10]);

    $this->post(route('cart.store'), ['product_id' => $product->id, 'quantity' => 1]);

    $this->get(route('cart.index'))
        ->assertOk()
        ->assertSee('Livraison offerte')
        ->assertDontSee('pour la livraison offerte');
});
