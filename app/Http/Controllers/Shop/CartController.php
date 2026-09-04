<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shop\AddToCartRequest;
use App\Http\Requests\Shop\UpdateCartItemRequest;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
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

    public function store(AddToCartRequest $request): RedirectResponse
    {
        $product = Product::findOrFail($request->integer('product_id'));

        $added = $this->cart->add(
            $product,
            $request->integer('quantity'),
            $request->string('color')->value() ?: null,
            $request->string('size')->value() ?: null,
        );

        return back()->with('toast', $added
            ? ['message' => "{$product->name} ajouté au panier.", 'type' => 'success']
            : ['message' => 'Ce produit est indisponible en quantité demandée.', 'type' => 'error']
        );
    }

    public function update(UpdateCartItemRequest $request, string $key): RedirectResponse
    {
        $this->cart->updateQuantity($key, $request->integer('quantity'));

        return back()->with('toast', ['message' => 'Panier mis à jour.', 'type' => 'success']);
    }

    public function destroy(string $key): RedirectResponse
    {
        $this->cart->remove($key);

        return back()->with('toast', ['message' => 'Article retiré du panier.', 'type' => 'success']);
    }
}
