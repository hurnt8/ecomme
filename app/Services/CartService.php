<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;

/**
 * Session-based cart (no DB table, no login merge — the shop has no active
 * customer accounts, matching the reference storefront's client-side cart).
 * Prices/stock are read live from the product on every read; snapshots only
 * happen once an order is actually placed (Order/OrderItem).
 */
class CartService
{
    private const SESSION_KEY = 'cart';

    public function add(Product $product, int $quantity, ?string $color = null, ?string $size = null): bool
    {
        if (! $product->is_active || $product->stock <= 0 || $quantity < 1) {
            return false;
        }

        $items = $this->raw();
        $key = $this->key($product->id, $color, $size);
        $requested = ($items[$key]['quantity'] ?? 0) + $quantity;

        $items[$key] = [
            'product_id' => $product->id,
            'color' => $color,
            'size' => $size,
            'quantity' => min($requested, $product->stock),
        ];

        $this->save($items);

        return true;
    }

    public function updateQuantity(string $key, int $quantity): void
    {
        $items = $this->raw();

        if (! isset($items[$key])) {
            return;
        }

        $product = Product::find($items[$key]['product_id']);
        $max = $product ? max($product->stock, 0) : 0;
        $quantity = max(0, min($quantity, $max));

        if ($quantity === 0) {
            unset($items[$key]);
        } else {
            $items[$key]['quantity'] = $quantity;
        }

        $this->save($items);
    }

    public function remove(string $key): void
    {
        $items = $this->raw();
        unset($items[$key]);
        $this->save($items);
    }

    public function clear(): void
    {
        session()->forget(self::SESSION_KEY);
    }

    /**
     * Reads the cart. A line whose requested quantity now exceeds live stock
     * (the product can sell out between "add to cart" and checkout) is
     * capped for display/ordering purposes and flagged via `wasCapped` —
     * but the session itself is left untouched, so the flag keeps showing
     * on every page (cart, checkout) until the customer explicitly updates
     * or removes the line. This is what lets PlaceOrderAction refuse to
     * silently order less than requested: the flag can't have been quietly
     * cleared by an intervening page view.
     *
     * Lines for a product that's gone entirely (deleted, deactivated, or
     * out of stock) are pruned from the session — there's no quantity fix
     * for those, only removal, so nothing is lost by dropping them here.
     *
     * @return Collection<int, object{key: string, product: Product, color: ?string, size: ?string, quantity: int, lineTotal: float, wasCapped: bool}>
     */
    public function items(): Collection
    {
        $raw = $this->raw();

        if (empty($raw)) {
            return collect();
        }

        $products = Product::with('images')
            ->whereIn('id', collect($raw)->pluck('product_id')->unique())
            ->get()
            ->keyBy('id');

        $pruned = $raw;
        $changed = false;

        $items = collect($raw)
            ->map(function (array $line, string $key) use ($products, &$pruned, &$changed) {
                $product = $products->get($line['product_id']);

                if (! $product || ! $product->is_active || $product->stock <= 0) {
                    unset($pruned[$key]);
                    $changed = true;

                    return null;
                }

                $quantity = min($line['quantity'], $product->stock);

                return (object) [
                    'key' => $key,
                    'product' => $product,
                    'color' => $line['color'],
                    'size' => $line['size'],
                    'quantity' => $quantity,
                    'lineTotal' => round((float) $product->price * $quantity, 2),
                    'wasCapped' => $quantity !== $line['quantity'],
                ];
            })
            ->filter()
            ->values();

        if ($changed) {
            $this->save($pruned);
        }

        return $items;
    }

    public function hasAdjustments(): bool
    {
        return $this->items()->contains('wasCapped', true);
    }

    public function count(): int
    {
        return (int) $this->items()->sum('quantity');
    }

    public function subtotal(): float
    {
        return round((float) $this->items()->sum('lineTotal'), 2);
    }

    public function isEmpty(): bool
    {
        return $this->items()->isEmpty();
    }

    private function key(int $productId, ?string $color, ?string $size): string
    {
        return md5($productId.'|'.$color.'|'.$size);
    }

    private function raw(): array
    {
        return session(self::SESSION_KEY, []);
    }

    private function save(array $items): void
    {
        session([self::SESSION_KEY => $items]);
    }
}
