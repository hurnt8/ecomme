@extends('layouts.admin')

@section('title', 'Tableau de bord')

@section('content')
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        <div class="bg-white rounded-lg border border-neutral-200 p-5">
            <p class="text-xs text-neutral-500 uppercase tracking-wide mb-1">Commandes</p>
            <p class="text-2xl font-semibold">{{ $ordersCount }}</p>
        </div>
        <div class="bg-white rounded-lg border border-neutral-200 p-5">
            <p class="text-xs text-neutral-500 uppercase tracking-wide mb-1">Produits actifs</p>
            <p class="text-2xl font-semibold">{{ $productsCount }}</p>
        </div>
        <div class="bg-white rounded-lg border border-neutral-200 p-5">
            <p class="text-xs text-neutral-500 uppercase tracking-wide mb-1">Stock faible</p>
            <p class="text-2xl font-semibold">{{ $lowStockProducts->count() }}</p>
        </div>
    </div>

    @if ($lowStockProducts->isNotEmpty())
        <div class="bg-white rounded-lg border border-neutral-200">
            <h2 class="px-5 py-3 text-sm font-medium border-b border-neutral-200">Produits en stock faible</h2>
            <ul class="divide-y divide-neutral-100">
                @foreach ($lowStockProducts as $product)
                    <li class="px-5 py-3 text-sm flex justify-between">
                        <span>{{ $product->name }}</span>
                        <span class="text-neutral-500">{{ $product->stock }} en stock</span>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <p class="mt-8 text-sm text-neutral-400">
        Gestion des produits, catégories, bannières, commandes et réglages : Phase 6 (back-office).
    </p>
@endsection
