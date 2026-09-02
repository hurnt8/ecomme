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
        $order = Order::with('items')
            ->where('order_number', strtoupper($request->string('order_number')->trim()->toString()))
            ->where('customer_email', $request->string('email')->trim()->toString())
            ->first();

        return view('shop.tracking', ['order' => $order, 'searched' => true]);
    }
}
