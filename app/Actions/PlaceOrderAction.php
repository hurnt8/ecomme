<?php

namespace App\Actions;

use App\Enums\OrderStatus;
use App\Enums\UserRole;
use App\Exceptions\InsufficientStockException;
use App\Mail\NewOrderAlert;
use App\Mail\OrderConfirmation;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Notifications\NewOrderPlaced;
use App\Services\CartService;
use App\Services\SettingsService;
use App\Services\ShippingService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class PlaceOrderAction
{
    public function __construct(
        private readonly CartService $cart,
        private readonly ShippingService $shipping,
        private readonly SettingsService $settings,
    ) {}

    /**
     * @param  array{name: string, email: string, address: string, country: string}  $customer
     *
     * @throws InsufficientStockException
     */
    public function execute(array $customer): Order
    {
        $cartItems = $this->cart->items();

        if ($cartItems->isEmpty()) {
            throw new \RuntimeException('Le panier est vide.');
        }

        // items() self-heals quantities that exceed current stock — if that
        // happened, stop here rather than silently order less than the
        // customer asked for. They see the corrected cart and re-confirm.
        if ($cartItems->contains('wasCapped', true)) {
            throw new InsufficientStockException(
                $cartItems->first(fn ($item) => $item->wasCapped)->product->name
            );
        }

        $order = DB::transaction(function () use ($customer, $cartItems) {
            $lines = $this->lockAndValidateStock($cartItems);

            $subtotal = $lines->sum(fn ($line) => (float) $line['product']->price * $line['quantity']);
            $shippingCost = $this->shipping->calculateShipping($subtotal, $customer['country']);
            $tax = $this->shipping->calculateTax($subtotal);

            $order = Order::create([
                'status' => OrderStatus::Pending,
                'customer_name' => $customer['name'],
                'customer_email' => $customer['email'],
                'shipping_address' => $customer['address'],
                'country' => strtoupper($customer['country']),
                'subtotal' => $subtotal,
                'shipping' => $shippingCost,
                'tax' => $tax,
                'total' => round($subtotal + $shippingCost + $tax, 2),
            ]);

            foreach ($lines as $line) {
                $order->items()->create([
                    'product_id' => $line['product']->id,
                    'product_name' => $line['product']->name,
                    'unit_price' => $line['product']->price,
                    'quantity' => $line['quantity'],
                ]);

                $line['product']->decrement('stock', $line['quantity']);
            }

            return $order;
        });

        $order->load('items');
        $this->cart->clear();
        $this->notifyCustomer($order);
        $this->notifyAdmins($order);

        return $order;
    }

    /**
     * Row-locks every cart product and re-checks stock inside the
     * transaction, so two customers racing for the last unit can't both
     * succeed even if the pre-transaction check above raced too.
     *
     * @param  Collection<int, object{product: Product, quantity: int}>  $cartItems
     * @return Collection<int, array{product: Product, quantity: int}>
     */
    private function lockAndValidateStock(Collection $cartItems): Collection
    {
        return $cartItems->map(function ($item) {
            $product = Product::query()->whereKey($item->product->id)->lockForUpdate()->firstOrFail();

            if (! $product->is_active || $product->stock < $item->quantity) {
                throw new InsufficientStockException($product->name);
            }

            return ['product' => $product, 'quantity' => $item->quantity];
        });
    }

    private function notifyCustomer(Order $order): void
    {
        try {
            Mail::to($order->customer_email)->send(new OrderConfirmation($order));
        } catch (\Throwable $e) {
            Log::error('Failed to send order confirmation email', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    private function notifyAdmins(Order $order): void
    {
        try {
            $admins = User::where('role', UserRole::Admin)->get();
            Notification::send($admins, new NewOrderPlaced($order));
        } catch (\Throwable $e) {
            Log::error('Failed to create new-order admin notification', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
            ]);
        }

        $settings = $this->settings->current();

        if (! $settings->notify_new_orders) {
            return;
        }

        $recipient = $settings->notification_email ?: $settings->contact_email;

        if (! $recipient) {
            return;
        }

        try {
            Mail::to($recipient)->send(new NewOrderAlert($order));
        } catch (\Throwable $e) {
            Log::error('Failed to send new-order alert email', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
