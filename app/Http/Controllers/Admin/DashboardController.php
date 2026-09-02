<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'ordersCount' => Order::count(),
            'productsCount' => Product::active()->count(),
            'lowStockProducts' => Product::active()->where('stock', '>', 0)->where('stock', '<=', 5)->orderBy('stock')->take(5)->get(),
        ]);
    }
}
