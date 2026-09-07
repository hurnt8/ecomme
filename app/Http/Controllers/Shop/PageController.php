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
        // a range that gets stocked later appears on its own.
        $categories = Category::active()
            ->ordered()
            ->withCount(['products' => fn ($q) => $q->active()])
            ->get();

        // One cover per range, resolved in two small queries. This used to eager load every
        // product with its images and pick one each, which was fair enough when the whole
        // catalogue was nine items; the shop now carries several thousand products and roughly
        // four times as many photographs, so that would drag the entire catalogue into memory to
        // render twelve thumbnails.
        $coverIds = Product::query()
            ->active()
            ->has('images')
            ->selectRaw('MIN(id) as id, category_id')
            ->groupBy('category_id')
            ->pluck('id');

        $covers = Product::query()
            ->whereIn('id', $coverIds)
            ->with('images')
            ->get()
            ->keyBy('category_id');

        return view('shop.pages.about', [
            'productCount' => Product::query()->active()->count(),
            'stockedCategories' => $categories->filter(fn ($c) => $c->products_count > 0),
            'emptyCategories' => $categories->filter(fn ($c) => $c->products_count === 0),
            'covers' => $covers,
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
