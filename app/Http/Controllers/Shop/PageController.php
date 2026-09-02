<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PageController extends Controller
{
    public function about(): View
    {
        return view('shop.pages.about');
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
