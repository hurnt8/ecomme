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
            'saleProducts' => Product::active()->inStock()->onSale()->with(['images', 'category'])->latest()->take(10)->get(),
            'bestsellerProducts' => Product::active()->inStock()->bestseller()->with(['images', 'category'])->latest()->take(8)->get(),
            'latestProducts' => Product::active()->inStock()->with(['images', 'category'])->latest()->take(8)->get(),
            'blogPosts' => BlogPost::published()->latest('published_at')->take(6)->get(),
            'bestReviews' => Review::with('product')->where('rating', '>=', 4)->latest()->take(3)->get(),
        ]);
    }
}
