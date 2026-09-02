<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateOrderStatusRequest;
use App\Models\Order;
use App\Notifications\OrderStatusChanged;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $orders = Order::query()
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))
            ->when($request->filled('search'), function ($q) use ($request) {
                $search = $request->string('search')->toString();
                $q->where(fn ($q2) => $q2->where('order_number', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_email', 'like', "%{$search}%"));
            })
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        return view('admin.orders.index', [
            'orders' => $orders,
            'statuses' => OrderStatus::cases(),
        ]);
    }

    public function show(Order $order): View
    {
        $order->load('items');

        return view('admin.orders.show', ['order' => $order]);
    }

    public function update(UpdateOrderStatusRequest $request, Order $order): RedirectResponse
    {
        $next = $request->status();

        if (! $order->status->canTransitionTo($next)) {
            return back()->with('toast', [
                'message' => "Impossible de passer de « {$order->status->label()} » à « {$next->label()} ».",
                'type' => 'error',
            ]);
        }

        if ($next === $order->status) {
            return back()->with('status', 'Statut inchangé.');
        }

        $order->status = $next;
        $order->paid_at = $next->isPaid() ? ($order->paid_at ?? now()) : null;
        $order->save();

        try {
            Notification::route('mail', $order->customer_email)->notify(new OrderStatusChanged($order));
        } catch (\Throwable $e) {
            report($e);
        }

        return back()->with('status', "Statut mis à jour : {$next->label()}.");
    }
}
