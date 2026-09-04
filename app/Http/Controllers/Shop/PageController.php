<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class PageController extends Controller
{
    public function about(): View
    {
        // Counted rather than written into the copy: the page used to advertise "+10 ans
        // d'expérience" and five universes including one with nothing in it. Reading the figures
        // off the catalogue means the page cannot claim more than the shop actually carries, and
        // a range that gets stocked later (Bois & Chauffage) appears on its own.
        $categories = Category::active()
            ->ordered()
            ->withCount(['products' => fn ($q) => $q->active()])
            // Only nine products in total, so eager loading them whole to pick one image each is
            // cheaper than a per-category lookup.
            ->with(['products' => fn ($q) => $q->active()->with('images')])
            ->get();

        return view('shop.pages.about', [
            'productCount' => Product::query()->active()->count(),
            'stockedCategories' => $categories->filter(fn ($c) => $c->products_count > 0),
            'emptyCategories' => $categories->filter(fn ($c) => $c->products_count === 0),
        ]);
    }

    public function careers(): View
    {
        return view('shop.pages.careers');
    }

    public function press(): View
    {
        return view('shop.pages.press');
    }

    public function help(): View
    {
        return view('shop.pages.help');
    }

    public function legalNotice(): View
    {
        return view('shop.pages.legal-notice');
    }

    public function privacy(): View
    {
        return view('shop.pages.privacy');
    }

    public function cookies(): View
    {
        return view('shop.pages.cookies');
    }

    public function accessibility(): View
    {
        return view('shop.pages.accessibility');
    }

    public function shipping(): View
    {
        return view('shop.pages.shipping');
    }

    public function returns(): View
    {
        return view('shop.pages.returns');
    }

    public function paymentMethods(): View
    {
        return view('shop.pages.payment-methods');
    }

    public function terms(): View
    {
        return view('shop.pages.terms');
    }
}
