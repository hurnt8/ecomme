<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $paidOrders = Order::whereNotNull('paid_at');

        $revenueTotal = (clone $paidOrders)->sum('total');
        $revenueThisMonth = (clone $paidOrders)->whereDate('paid_at', '>=', now()->startOfMonth())->sum('total');
        $paidOrdersCount = (clone $paidOrders)->count();
        $averageOrderValue = $paidOrdersCount > 0 ? $revenueTotal / $paidOrdersCount : 0;

        $revenueByDay = (clone $paidOrders)
            ->whereDate('paid_at', '>=', now()->subDays(13)->startOfDay())
            ->selectRaw('DATE(paid_at) as date, SUM(total) as total')
            ->groupBy('date')
            ->pluck('total', 'date');

        $revenueLast14Days = collect(range(13, 0))->map(function ($daysAgo) use ($revenueByDay) {
            $date = now()->subDays($daysAgo)->toDateString();

            return ['date' => $date, 'total' => (float) ($revenueByDay[$date] ?? 0)];
        })->values();

        $ordersByStatus = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status');

        $lowStockProducts = Product::where('is_active', true)
            ->where('stock', '>', 0)
            ->where('stock', '<=', 5)
            ->orderBy('stock')
            ->limit(5)
            ->get(['id', 'name', 'slug', 'stock']);

        $topProducts = OrderItem::select('product_id', 'product_name', DB::raw('SUM(quantity) as units_sold'))
            ->whereHas('order', fn ($q) => $q->where('status', '!=', OrderStatus::Cancelled))
            ->groupBy('product_id', 'product_name')
            ->orderByDesc('units_sold')
            ->limit(5)
            ->get();

        return view('admin.dashboard', [
            'revenueTotal' => (float) $revenueTotal,
            'revenueThisMonth' => (float) $revenueThisMonth,
            'averageOrderValue' => round((float) $averageOrderValue, 2),
            'revenueLast14Days' => $revenueLast14Days,
            'ordersTotal' => Order::count(),
            'ordersPending' => (int) ($ordersByStatus[OrderStatus::Pending->value] ?? 0),
            'ordersByStatus' => $ordersByStatus,
            'productsCount' => Product::active()->count(),
            'outOfStockCount' => Product::where('stock', '<=', 0)->count(),
            'lowStockProducts' => $lowStockProducts,
            'reviewsCount' => Review::count(),
            'reviewsAverage' => round((float) Review::avg('rating'), 1),
            'topProducts' => $topProducts,
        ]);
    }
}
