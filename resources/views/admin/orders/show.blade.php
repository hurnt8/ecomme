@extends('layouts.admin')

@section('title', 'Commande '.$order->order_number)

@section('content')
    <div class="mb-4">
        <a href="{{ route('admin.commandes.index') }}" class="text-sm text-neutral-500 hover:underline">&larr; Retour aux commandes</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-lg border border-neutral-200 p-5">
                <h2 class="text-sm font-medium mb-3">Articles</h2>
                <table class="w-full text-sm">
                    <thead class="text-neutral-500 text-xs uppercase">
                        <tr>
                            <th class="text-left py-1">Produit</th>
                            <th class="text-right py-1">Prix</th>
                            <th class="text-right py-1">Qté</th>
                            <th class="text-right py-1">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-100">
                        @foreach ($order->items as $item)
                            <tr>
                                <td class="py-2">{{ $item->product_name }}</td>
                                <td class="py-2 text-right">{{ number_format((float) $item->unit_price, 2) }}&nbsp;€</td>
                                <td class="py-2 text-right">{{ $item->quantity }}</td>
                                <td class="py-2 text-right">{{ number_format((float) $item->unit_price * $item->quantity, 2) }}&nbsp;€</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="text-sm mt-3 space-y-1 text-right">
                    <p>Sous-total : {{ number_format((float) $order->subtotal, 2) }}&nbsp;€</p>
                    <p>Livraison : {{ number_format((float) $order->shipping, 2) }}&nbsp;€</p>
                    <p>Taxes : {{ number_format((float) $order->tax, 2) }}&nbsp;€</p>
                    <p class="font-semibold">Total : {{ number_format((float) $order->total, 2) }}&nbsp;€</p>
                </div>
            </div>

            <div class="bg-white rounded-lg border border-neutral-200 p-5">
                <h2 class="text-sm font-medium mb-3">Client</h2>
                <p class="text-sm">{{ $order->customer_name }}</p>
                <p class="text-sm text-neutral-500">{{ $order->customer_email }}</p>
                @if ($order->customer_phone)
                    <p class="text-sm text-neutral-500">{{ $order->customer_phone }}</p>
                @endif
                <p class="text-sm text-neutral-500 mt-2 whitespace-pre-line">{{ $order->shipping_address }}</p>
                <p class="text-sm text-neutral-500">{{ \App\Support\Countries::label($order->country) ?? $order->country }}</p>
            </div>

            <div class="flex gap-3">
                <a href="{{ \Illuminate\Support\Facades\URL::signedRoute('orders.invoice', ['order' => $order->order_number]) }}"
                   target="_blank" class="text-sm rounded-md border border-neutral-300 px-4 py-2 hover:bg-neutral-50">
                    Télécharger la facture
                </a>
                @if ($order->paid_at)
                    <a href="{{ \Illuminate\Support\Facades\URL::signedRoute('orders.receipt', ['order' => $order->order_number]) }}"
                       target="_blank" class="text-sm rounded-md border border-neutral-300 px-4 py-2 hover:bg-neutral-50">
                        Télécharger le reçu
                    </a>
                @endif
            </div>
        </div>

        <div class="space-y-4">
            <div class="bg-white rounded-lg border border-neutral-200 p-5">
                <h2 class="text-sm font-medium mb-3">Statut</h2>
                <p class="text-sm mb-3">Statut actuel : <strong>{{ $order->status->label() }}</strong></p>

                @php
                    $nextStatuses = collect(\App\Enums\OrderStatus::cases())
                        ->filter(fn ($status) => $status !== $order->status && $order->status->canTransitionTo($status));
                @endphp

                @if ($nextStatuses->isNotEmpty())
                    <form method="POST" action="{{ route('admin.commandes.update', $order) }}" class="flex gap-2">
                        @csrf
                        @method('PATCH')
                        <select name="status" class="flex-1 rounded-md border border-neutral-300 px-3 py-1.5 text-sm">
                            @foreach ($nextStatuses as $status)
                                <option value="{{ $status->value }}">{{ $status->label() }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="rounded-md bg-brand-400 px-4 py-1.5 text-sm font-medium text-neutral-900 transition-colors hover:bg-brand-500">
                            Mettre à jour
                        </button>
                    </form>
                @else
                    <p class="text-xs text-neutral-400">Statut final, aucune transition possible.</p>
                @endif

                @if ($order->paid_at)
                    <p class="text-xs text-neutral-400 mt-3">Payée le {{ $order->paid_at->format('d/m/Y H:i') }}</p>
                @endif
            </div>
        </div>
    </div>
@endsection
