<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\BlogPost;
use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * The ranges the homepage promotes while it is cold: wood and pellets to burn, the saws that
     * cut them, and the stoves and outdoor fires they feed. Listed once because three carousels
     * key off it — a spring reshuffle changes this constant, not three separate queries.
     */
    private const COLD_SEASON_CATEGORIES = [
        'bois-chauffage',
        'tronconneuses-elagage',
        'barbecues-fours',
    ];

    /**
     * Cheap discounted items read as clearance next to a pallet of pellets, so the deals carousel
     * skips them. The shop sells machines and fuel by the pallet; a discounted 20 € accessory
     * makes the row look like an end-of-line bin rather than a seasonal offer.
     */
    private const MIN_DEAL_PRICE = 100;

    public function index(): View
    {
        return view('shop.home', [
            'heroBanners' => Banner::active()->forPosition('home_hero')->get(),
            'secondaryBanners' => Banner::active()->forPosition('home_secondary')->take(2)->get(),
            // Most categories have no tile artwork, so each one also brings its latest product
            // (one per category, not one overall) for the carousel to fall back on.
            'categories' => Category::active()->ordered()
                ->withCount(['products' => fn ($query) => $query->active()])
                ->with(['products' => fn ($query) => $query->active()->with('images')->latest()->limit(1)])
                ->get(),
            // Heating gets its own carousel for the cold season. Both ranges are included: wood
            // and pellets to burn, and the stoves and chainsaws that go with them — a customer
            // buying logs in October is the one who also needs a saw and an axe.
            'heatingProducts' => Product::active()->inStock()
                ->whereHas('category', fn ($query) => $query->whereIn('slug', ['bois-chauffage', 'tronconneuses-elagage']))
                ->with(['images', 'category'])
                ->latest()
                ->take(10)
                ->get(),
            'saleProducts' => Product::active()->inStock()->onSale()
                ->where('price', '>=', self::MIN_DEAL_PRICE)
                ->whereHas('category', fn ($query) => $query->whereIn('slug', self::COLD_SEASON_CATEGORIES))
                ->with(['images', 'category'])
                ->latest()
                ->take(10)
                ->get(),
            'bestsellerProducts' => Product::active()->inStock()->bestseller()
                ->whereHas('category', fn ($query) => $query->whereIn('slug', self::COLD_SEASON_CATEGORIES))
                ->with(['images', 'category'])
                ->latest()
                ->take(8)
                ->get(),
            'latestProducts' => Product::active()->inStock()->with(['images', 'category'])->latest()->take(8)->get(),
            'blogPosts' => BlogPost::published()->latest('published_at')->take(6)->get(),
            'bestReviews' => Review::with('product')->where('rating', '>=', 4)->latest()->take(3)->get(),
        ]);
    }
}
