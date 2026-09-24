<?php

use App\Models\Category;
use App\Models\Product;

/**
 * The bestsellers carousel is scoped to the cold-season ranges, so both fixtures have to sit in
 * one of them — a bestseller filed under any other category is filtered out before it reaches
 * the homepage, and this test would fail for a reason that has nothing to do with what it checks.
 */
function seasonalCategory(): Category
{
    return Category::query()->firstOrCreate(
        ['slug' => 'bois-chauffage'],
        Category::factory()->make(['slug' => 'bois-chauffage', 'is_active' => true])->getAttributes(),
    );
}

it('shows bestseller products on the homepage', function () {
    $category = seasonalCategory();

    $bestseller = Product::factory()->create(['category_id' => $category->id, 'name' => 'Fauteuil vedette', 'is_bestseller' => true, 'stock' => 5]);
    $regular = Product::factory()->create(['category_id' => $category->id, 'name' => 'Chaise ordinaire', 'is_bestseller' => false, 'stock' => 5]);

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
