<?php

use App\Models\Product;

it('folds a long description behind a "Lire la suite" toggle', function () {
    $product = Product::factory()->create([
        'description' => str_repeat('Moteur quatre temps robuste, démarrage par lanceur et fraises en acier. ', 20),
    ]);

    $this->get(route('product.show', $product->slug))
        ->assertOk()
        ->assertSee('product-description-text', false)
        ->assertSee('Lire la suite');
});

it('shows a short description whole, without the toggle', function () {
    $product = Product::factory()->create(['description' => 'Tondeuse compacte pour petits jardins.']);

    $this->get(route('product.show', $product->slug))
        ->assertOk()
        ->assertSee('Tondeuse compacte pour petits jardins.')
        ->assertDontSee('Lire la suite');
});

it('keeps the excerpt next to the price to a short teaser', function () {
    $product = Product::factory()->create([
        'description' => str_repeat('Moteur quatre temps robuste, démarrage par lanceur et fraises en acier. ', 20),
    ]);

    $html = $this->get(route('product.show', $product->slug))->assertOk()->getContent();

    preg_match('/class="product-summary-excerpt">(.*?)<\/p>/s', $html, $match);

    expect(mb_strlen(html_entity_decode(trim($match[1]))))->toBeLessThanOrEqual(163);
});
