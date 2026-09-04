<?php

namespace App\Http\Controllers\Shop;

use App\Actions\PlaceOrderAction;
use App\Exceptions\InsufficientStockException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Shop\PlaceOrderRequest;
use App\Models\Order;
use App\Services\CartService;
use App\Services\CheckoutService;
use App\Support\Countries;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function __construct(
        private readonly CartService $cart,
        private readonly CheckoutService $checkout,
    ) {}

    public function index(Request $request): View|RedirectResponse
    {
        if ($this->cart->isEmpty()) {
            return redirect()->route('cart.index')->with('toast', [
                'message' => 'Votre panier est vide.',
                'type' => 'error',
            ]);
        }

        $country = $request->old('country', 'FR');

        return view('shop.checkout', [
            'items' => $this->cart->items(),
            'summary' => $this->checkout->summary($country),
            'countries' => Countries::LIST,
        ]);
    }

    public function store(PlaceOrderRequest $request, PlaceOrderAction $action): RedirectResponse
    {
        try {
            $order = $action->execute($request->customer());
        } catch (InsufficientStockException $e) {
            return back()->withInput()->with('toast', ['message' => $e->getMessage(), 'type' => 'error']);
        } catch (\RuntimeException $e) {
            return redirect()->route('cart.index')->with('toast', ['message' => $e->getMessage(), 'type' => 'error']);
        }

        $request->session()->put('checkout.last_order_id', $order->id);

        return redirect()->route('checkout.confirmation');
    }

    public function confirmation(Request $request): View|RedirectResponse
    {
        $orderId = $request->session()->get('checkout.last_order_id');
        // items.product.images so the recap can show a thumbnail per line without a query each.
        // The relation is nullable — a product can be deleted after being ordered — so the view
        // falls back to the name snapshot stored on the line.
        $order = $orderId ? Order::with('items.product.images')->find($orderId) : null;

        if (! $order) {
            return redirect()->route('home');
        }

        return view('shop.checkout-confirmation', ['order' => $order]);
    }
}
