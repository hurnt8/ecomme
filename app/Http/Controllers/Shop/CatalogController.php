<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogController extends Controller
{
    private const SORTS = ['newest', 'price_asc', 'price_desc', 'name_asc'];

    public function index(Request $request): View
    {
        $sort = in_array($request->query('sort'), self::SORTS, true) ? $request->query('sort') : 'newest';

        $query = Product::query()->active()->with(['images', 'category']);

        if ($request->filled('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->string('category')));
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->string('search').'%');
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->float('min_price'));
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->float('max_price'));
        }

        if ($request->filled('size')) {
            $query->whereJsonContains('sizes', $request->string('size')->toString());
        }

        if ($request->filled('color')) {
            $query->whereJsonContains('colors', $request->string('color')->toString());
        }

        if ($request->boolean('in_stock')) {
            $query->inStock();
        }

        if ($request->boolean('is_new')) {
            $query->new();
        }

        if ($request->boolean('on_sale')) {
            $query->onSale();
        }

        /*
         * Cold-season ranges first on the default ordering, so the shop opens on firewood rather
         * than on pools while it is cold outside.
         *
         * Only on the default: a shopper who picks "price ascending" asked for price ascending,
         * and quietly grouping by season first would make the sort look broken. Filtering to one
         * category makes it moot too — every row is then in or out of the season together.
         */
        if ($sort === 'newest' && ! $request->filled('category')) {
            $query->orderByRaw(
                'CASE WHEN category_id IN (SELECT id FROM categories WHERE slug IN (?, ?, ?)) THEN 0 ELSE 1 END',
                Category::coldSeasonSlugs()
            );
        }

        match ($sort) {
            'price_asc' => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'name_asc' => $query->orderBy('name'),
            default => $query->latest(),
        };

        $products = $query->paginate(12)->withQueryString();

        return view('shop.catalog', [
            'products' => $products,
            // withCount so the sidebar can show how many pieces sit behind each category. Empty
            // categories are still listed rather than hidden — the count reading 0 is the signal
            // that the category needs stock.
            'categories' => Category::active()
                ->ordered()
                ->withCount(['products' => fn ($q) => $q->active()])
                ->get(),
            'sizes' => $this->distinctValues('sizes'),
            'colors' => $this->distinctValues('colors'),
            'sort' => $sort,
            'promoBanners' => Banner::active()
                ->whereIn('position', ['shop_new', 'shop_sale'])
                ->orderBy('position')
                ->orderBy('sort_order')
                ->get(),
        ]);
    }

    private function distinctValues(string $column): array
    {
        return Product::query()
            ->active()
            ->whereNotNull($column)
            ->pluck($column)
            ->flatten()
            ->unique()
            ->sort()
            ->values()
            ->all();
    }
}
