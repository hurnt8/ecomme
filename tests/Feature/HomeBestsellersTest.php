<?php

use App\Models\Product;

it('shows bestseller products on the homepage', function () {
    $bestseller = Product::factory()->create(['name' => 'Fauteuil vedette', 'is_bestseller' => true, 'stock' => 5]);
    $regular = Product::factory()->create(['name' => 'Chaise ordinaire', 'is_bestseller' => false, 'stock' => 5]);

    $response = $this->get(route('home'));

    $response->assertOk()->assertSee($bestseller->name)->assertSee('Meilleures ventes');

    // "Chaise ordinaire" isn't a bestseller, but it can still legitimately appear elsewhere on
    // the homepage (the generic "Nos pièces" selection) — assert it's absent from the
    // bestsellers block specifically rather than from the page as a whole.
    $html = $response->getContent();
    $sectionStart = strpos($html, 'id="fh5co-bestsellers"');
    $sectionEnd = strpos($html, 'id="fh5co-product"');
    $section = substr($html, $sectionStart, $sectionEnd - $sectionStart);

    expect($section)->toContain($bestseller->name)
        ->and($section)->not->toContain($regular->name);
});

it('hides the bestsellers section when no product is flagged', function () {
    Product::factory()->create(['is_bestseller' => false]);

    $this->get(route('home'))->assertOk()->assertDontSee('Meilleures ventes');
});
