<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Banner;
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
            'secondaryBanners' => Banner::active()->forPosition('home_secondary')->get(),
            'categories' => Category::active()->ordered()->get(),
            'newProducts' => Product::active()->inStock()->new()->with(['images', 'category'])->latest()->take(8)->get(),
            'bestsellerProducts' => Product::active()->inStock()->bestseller()->with(['images', 'category'])->latest()->take(3)->get(),
            'products' => Product::active()->inStock()->with(['images', 'category'])->latest()->take(6)->get(),
            'bestReviews' => Review::with('product')->where('rating', '>=', 4)->latest()->take(3)->get(),
        ]);
    }
}
