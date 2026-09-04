<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shop\TrackOrderRequest;
use App\Models\Order;
use Illuminate\View\View;

class OrderTrackingController extends Controller
{
    public function index(): View
    {
        return view('shop.tracking', ['order' => null, 'searched' => false]);
    }

    public function search(TrackOrderRequest $request): View
    {
        // items.product.images so the recap can show a thumbnail per line; the product may since
        // have been deleted, so the view falls back to the name stored on the line.
        $order = Order::with('items.product.images')
            ->where('order_number', strtoupper($request->string('order_number')->trim()->toString()))
            ->where('customer_email', $request->string('email')->trim()->toString())
            ->first();

        return view('shop.tracking', ['order' => $order, 'searched' => true]);
    }
}
