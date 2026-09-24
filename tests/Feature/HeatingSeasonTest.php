<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;

/**
 * Winter layout: heating leads the homepage and the category list. These assertions are what a
 * spring reshuffle has to deliberately update — they fail loudly rather than letting the cold
 * season quietly outlive itself.
 */
function heatingProduct(string $categorySlug, string $name): Product
{
    // firstOrCreate, not create: several products in one test share a range, and the slug column
    // is unique — a second call would otherwise blow up on the constraint.
    $category = Category::query()->firstOrCreate(
        ['slug' => $categorySlug],
        Category::factory()->make(['slug' => $categorySlug, 'is_active' => true])->getAttributes(),
    );

    $product = Product::factory()->create([
        'category_id' => $category->id,
        'name' => $name,
        'is_active' => true,
        'stock' => 12,
    ]);

    ProductImage::query()->create(['product_id' => $product->id, 'path' => 'products/test.jpg']);

    return $product;
}

it('gives heating its own carousel above the deals', function () {
    heatingProduct('bois-chauffage', 'Bûches de chêne 50 cm');

    // A discounted product of its own, so the deals carousel actually renders: without one the
    // section is absent, strpos() returns false, and the comparison below silently reads it as 0.
    // It has to be an in-season range above MIN_DEAL_PRICE, or the carousel filters it straight
    // back out. onSale() keys off compare_at_price being above price, not a sale_price column.
    $onSale = heatingProduct('barbecues-fours', 'Brasero soldé');
    $onSale->update(['price' => 250, 'compare_at_price' => 400]);

    $response = $this->get('/')->assertOk();

    $response->assertSee('La saison du chauffage au bois');
    $response->assertSee('Bûches de chêne 50 cm');

    // Position matters more than presence: the whole point is that heating is seen first.
    $html = $response->getContent();
    $heating = strpos($html, 'La saison du chauffage au bois');
    $deals = strpos($html, 'Nos offres du jour');

    expect($deals)->not->toBeFalse()
        ->and($heating)->not->toBeFalse()
        ->and($heating)->toBeLessThan($deals);
});

it('includes chainsaws alongside the wood', function () {
    heatingProduct('bois-chauffage', 'Granulés premium');
    heatingProduct('tronconneuses-elagage', 'Tronçonneuse thermique 45 cm');

    $this->get('/')
        ->assertOk()
        ->assertSee('Granulés premium')
        ->assertSee('Tronçonneuse thermique 45 cm');
});

it('leaves the heating carousel out when nothing is in stock', function () {
    $category = Category::factory()->create(['slug' => 'bois-chauffage', 'is_active' => true]);
    $product = Product::factory()->create([
        'category_id' => $category->id,
        'is_active' => true,
        'stock' => 0,
    ]);
    ProductImage::query()->create(['product_id' => $product->id, 'path' => 'products/test.jpg']);

    $this->get('/')
        ->assertOk()
        ->assertDontSee('La saison du chauffage au bois');
});

it('links the carousel through to the wood category', function () {
    heatingProduct('bois-chauffage', 'Bûches compressées');

    $this->get('/')
        ->assertOk()
        ->assertSee('category=bois-chauffage', escape: false);
});

/**
 * Reads one carousel's slice of the homepage. Asserting against the whole page would prove
 * nothing here: a product excluded from the deals row still shows up under "Nouveaux produits",
 * so assertDontSee() on the full response fails for the right product in the wrong place.
 */
function carouselSection(string $html, string $heading, string ...$nextMarkers): string
{
    $start = strpos($html, $heading);
    expect($start)->not->toBeFalse("section '$heading' absente de la page");

    // Several candidate end markers, because a carousel is omitted entirely when it has nothing
    // to show: cutting at "Meilleures ventes" alone swallows the rest of the page whenever no
    // bestseller is flagged, and the slice then wrongly includes "Nouveaux produits".
    $end = strlen($html);
    foreach ($nextMarkers as $marker) {
        $found = strpos($html, $marker, $start);
        if ($found !== false && $found < $end) {
            $end = $found;
        }
    }

    return substr($html, $start, $end - $start);
}

it('keeps out-of-season ranges out of the deals carousel', function () {
    $pool = heatingProduct('bois-chauffage', 'Palette de granulés');
    $pool->update(['price' => 280, 'compare_at_price' => 350]);

    $summer = heatingProduct('piscines', 'Piscine tubulaire soldée');
    $summer->update(['price' => 519, 'compare_at_price' => 700]);

    $deals = carouselSection($this->get('/')->assertOk()->getContent(), 'Nos offres du jour', 'id="fh5co-bestsellers"', 'id="fh5co-product"');

    expect($deals)->toContain('Palette de granulés')
        ->and($deals)->not->toContain('Piscine tubulaire soldée');
});

it('keeps cheap discounted items out of the deals carousel', function () {
    $cheap = heatingProduct('bois-chauffage', 'Allume-feu soldé');
    $cheap->update(['price' => 12, 'compare_at_price' => 20]);

    $proper = heatingProduct('bois-chauffage', 'Palette de bûches');
    $proper->update(['price' => 280, 'compare_at_price' => 350]);

    $deals = carouselSection($this->get('/')->assertOk()->getContent(), 'Nos offres du jour', 'id="fh5co-bestsellers"', 'id="fh5co-product"');

    expect($deals)->toContain('Palette de bûches')
        ->and($deals)->not->toContain('Allume-feu soldé');
});

it('limits the bestsellers carousel to cold-season ranges', function () {
    $wood = heatingProduct('bois-chauffage', 'Bûches densifiées');
    $wood->update(['is_bestseller' => true]);

    $mower = heatingProduct('tondeuses', 'Tondeuse à gazon vedette');
    $mower->update(['is_bestseller' => true]);

    $best = carouselSection($this->get('/')->assertOk()->getContent(), 'Meilleures ventes', 'id="fh5co-product"');

    expect($best)->toContain('Bûches densifiées')
        ->and($best)->not->toContain('Tondeuse à gazon vedette');
});

it('orders the shop categories for the cold season', function () {
    foreach (['piscines' => 11, 'tondeuses' => 8, 'barbecues-fours' => 1, 'bois-chauffage' => 0] as $slug => $order) {
        Category::factory()->create(['slug' => $slug, 'sort_order' => $order, 'is_active' => true]);
    }

    $ordered = Category::query()->active()->ordered()->pluck('slug')->all();

    expect($ordered[0])->toBe('bois-chauffage')
        ->and($ordered[1])->toBe('barbecues-fours')
        ->and(array_search('piscines', $ordered, true))
        ->toBeGreaterThan(array_search('tondeuses', $ordered, true));
});
