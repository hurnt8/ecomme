<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function show(Product $product): View
    {
        abort_unless($product->is_active, 404);

        $product->load(['images', 'category', 'reviews']);

        $distribution = $product->reviews
            ->groupBy('rating')
            ->map->count();

        $related = Product::active()
            ->inStock()
            ->with('images')
            ->where('id', '!=', $product->id)
            ->when($product->category_id, fn ($q) => $q->where('category_id', $product->category_id))
            ->take(3)
            ->get();

        return view('shop.product', [
            'product' => $product,
            'reviewsDistribution' => collect([5, 4, 3, 2, 1])->mapWithKeys(
                fn ($star) => [$star => $distribution[$star] ?? 0]
            ),
            'related' => $related,
        ]);
    }
}
