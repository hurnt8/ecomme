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
     * @return Collection<int, object{key: string, product: Product, color: ?string, size: ?string, quantity: int, lineTotal: float}>
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

        return collect($raw)
            ->map(function (array $line, string $key) use ($products) {
                $product = $products->get($line['product_id']);

                if (! $product || ! $product->is_active) {
                    return null;
                }

                $quantity = min($line['quantity'], max($product->stock, 0));

                return (object) [
                    'key' => $key,
                    'product' => $product,
                    'color' => $line['color'],
                    'size' => $line['size'],
                    'quantity' => $quantity,
                    'lineTotal' => round((float) $product->price * $quantity, 2),
                ];
            })
            ->filter()
            ->values();
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
