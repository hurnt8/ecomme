@extends('layouts.admin')

@section('title', 'Tableau de bord')

@section('content')
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg border border-neutral-200 p-5">
            <p class="text-xs text-neutral-500 uppercase tracking-wide mb-1">CA total (payé)</p>
            <p class="text-2xl font-semibold">{{ number_format($revenueTotal, 0) }}&nbsp;€</p>
        </div>
        <div class="bg-white rounded-lg border border-neutral-200 p-5">
            <p class="text-xs text-neutral-500 uppercase tracking-wide mb-1">CA ce mois-ci</p>
            <p class="text-2xl font-semibold">{{ number_format($revenueThisMonth, 0) }}&nbsp;€</p>
        </div>
        <div class="bg-white rounded-lg border border-neutral-200 p-5">
            <p class="text-xs text-neutral-500 uppercase tracking-wide mb-1">Panier moyen</p>
            <p class="text-2xl font-semibold">{{ number_format($averageOrderValue, 2) }}&nbsp;€</p>
        </div>
        <div class="bg-white rounded-lg border border-neutral-200 p-5">
            <p class="text-xs text-neutral-500 uppercase tracking-wide mb-1">Commandes en attente</p>
            <p class="text-2xl font-semibold">{{ $ordersPending }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-lg border border-neutral-200 p-5">
            <p class="text-xs text-neutral-500 uppercase tracking-wide mb-1">Commandes totales</p>
            <p class="text-2xl font-semibold">{{ $ordersTotal }}</p>
        </div>
        <div class="bg-white rounded-lg border border-neutral-200 p-5">
            <p class="text-xs text-neutral-500 uppercase tracking-wide mb-1">Produits actifs</p>
            <p class="text-2xl font-semibold">{{ $productsCount }}</p>
            @if ($outOfStockCount > 0)
                <p class="text-xs text-clay-600 mt-1">{{ $outOfStockCount }} en rupture</p>
            @endif
        </div>
        <div class="bg-white rounded-lg border border-neutral-200 p-5">
            <p class="text-xs text-neutral-500 uppercase tracking-wide mb-1">Avis</p>
            <p class="text-2xl font-semibold">{{ $reviewsCount }} <span class="text-sm text-neutral-400">({{ $reviewsAverage ?: '—' }}/5)</span></p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg border border-neutral-200">
            <h2 class="px-5 py-3 text-sm font-medium border-b border-neutral-200">Produits en stock faible</h2>
            @if ($lowStockProducts->isEmpty())
                <p class="px-5 py-4 text-sm text-neutral-400">Aucun produit en stock faible.</p>
            @else
                <ul class="divide-y divide-neutral-100">
                    @foreach ($lowStockProducts as $product)
                        <li class="px-5 py-3 text-sm flex justify-between">
                            <a href="{{ route('admin.produits.edit', $product) }}" class="hover:underline">{{ $product->name }}</a>
                            <span class="text-neutral-500">{{ $product->stock }} en stock</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="bg-white rounded-lg border border-neutral-200">
            <h2 class="px-5 py-3 text-sm font-medium border-b border-neutral-200">Meilleures ventes</h2>
            @if ($topProducts->isEmpty())
                <p class="px-5 py-4 text-sm text-neutral-400">Aucune vente pour le moment.</p>
            @else
                <ul class="divide-y divide-neutral-100">
                    @foreach ($topProducts as $item)
                        <li class="px-5 py-3 text-sm flex justify-between">
                            <span>{{ $item->product_name }}</span>
                            <span class="text-neutral-500">{{ $item->units_sold }} vendus</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
@endsection
