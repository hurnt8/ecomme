<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shop\AddToCartRequest;
use App\Http\Requests\Shop\UpdateCartItemRequest;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(private readonly CartService $cart) {}

    public function index(): View
    {
        $items = $this->cart->items();

        $recommended = Product::active()
            ->inStock()
            ->with('images')
            ->whereNotIn('id', $items->pluck('product.id'))
            ->inRandomOrder()
            // Three, so the suggestions fill exactly one row of the 3-up grid instead of
            // leaving a fourth card stranded on a row of its own.
            ->take(3)
            ->get();

        return view('shop.cart', [
            'items' => $items,
            'subtotal' => $this->cart->subtotal(),
            'recommended' => $recommended,
        ]);
    }

    public function store(AddToCartRequest $request): RedirectResponse|JsonResponse
    {
        $product = Product::findOrFail($request->integer('product_id'));

        $added = $this->cart->add(
            $product,
            $request->integer('quantity'),
            $request->string('color')->value() ?: null,
            $request->string('size')->value() ?: null,
        );

        $toast = $added
            ? ['message' => "{$product->name} in den Warenkorb gelegt.", 'type' => 'success']
            : ['message' => 'Dieses Produkt ist in der gewünschten Menge nicht verfügbar.', 'type' => 'error'];

        if ($request->expectsJson()) {
            return $this->cartResponse($toast, $added ? 200 : 422);
        }

        return back()->with('toast', $toast);
    }

    public function update(UpdateCartItemRequest $request, string $key): RedirectResponse|JsonResponse
    {
        $this->cart->updateQuantity($key, $request->integer('quantity'));

        // No toast in the background: the stepper sends a request per change, and the line and
        // summary it re-renders already show the result.
        if ($request->expectsJson()) {
            return $this->cartResponse();
        }

        return back()->with('toast', ['message' => 'Warenkorb aktualisiert.', 'type' => 'success']);
    }

    public function destroy(Request $request, string $key): RedirectResponse|JsonResponse
    {
        $this->cart->remove($key);

        $toast = ['message' => 'Artikel aus dem Warenkorb entfernt.', 'type' => 'success'];

        if ($request->expectsJson()) {
            return $this->cartResponse($toast);
        }

        return back()->with('toast', $toast);
    }

    /**
     * The answer to a cart form sent in the background (resources/js/modules/cart.js): the item
     * count for the header badge, an optional toast, and the cart page's lines and summary
     * re-rendered from the partial the page itself includes, so nothing is formatted twice.
     *
     * @param  array{message: string, type: string}|null  $toast
     */
    private function cartResponse(?array $toast = null, int $status = 200): JsonResponse
    {
        $items = $this->cart->items();

        return response()->json([
            'message' => $toast['message'] ?? null,
            'type' => $toast['type'] ?? null,
            'count' => (int) $items->sum('quantity'),
            'html' => view('partials.shop.cart-body', [
                'items' => $items,
                'subtotal' => round((float) $items->sum('lineTotal'), 2),
            ])->render(),
        ], $status);
    }
}
