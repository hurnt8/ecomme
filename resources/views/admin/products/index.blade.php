@extends('layouts.admin')

@section('title', 'Produits')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <form method="GET" class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher un produit..."
                   class="rounded-md border border-neutral-300 px-3 py-1.5 text-sm w-64">
            <select name="category" class="rounded-md border border-neutral-300 px-3 py-1.5 text-sm" onchange="this.form.submit()">
                <option value="">Toutes les catégories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->slug }}" @selected(request('category') === $category->slug)>{{ $category->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="rounded-md border border-neutral-300 px-3 py-1.5 text-sm">Filtrer</button>
        </form>

        <a href="{{ route('admin.produits.create') }}" class="rounded-md bg-neutral-900 text-white text-sm px-4 py-2 hover:bg-neutral-800">
            + Nouveau produit
        </a>
    </div>

    <div class="bg-white rounded-lg border border-neutral-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-neutral-50 text-neutral-500 text-xs uppercase">
                <tr>
                    <th class="text-left px-4 py-2"></th>
                    <th class="text-left px-4 py-2">Produit</th>
                    <th class="text-left px-4 py-2">Catégorie</th>
                    <th class="text-right px-4 py-2">Prix</th>
                    <th class="text-right px-4 py-2">Stock</th>
                    <th class="text-center px-4 py-2">Statut</th>
                    <th class="text-right px-4 py-2">Avis</th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-100">
                @forelse ($products as $product)
                    <tr>
                        <td class="px-4 py-2">
                            <img src="{{ $product->images->first()?->url }}" alt="" class="w-10 h-10 object-cover rounded">
                        </td>
                        <td class="px-4 py-2">
                            <a href="{{ route('admin.produits.edit', $product) }}" class="font-medium hover:underline">{{ $product->name }}</a>
                            @if ($product->is_new)
                                <span class="ml-1 text-xs text-green-700">Nouveau</span>
                            @endif
                            @if ($product->is_bestseller)
                                <span class="ml-1 text-xs text-amber-700">Meilleure vente</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-neutral-500">{{ $product->category?->name ?? '—' }}</td>
                        <td class="px-4 py-2 text-right">{{ number_format((float) $product->price, 2) }}&nbsp;€</td>
                        <td class="px-4 py-2 text-right {{ $product->stock <= 5 ? 'text-red-600' : '' }}">{{ $product->stock }}</td>
                        <td class="px-4 py-2 text-center">
                            @if ($product->is_active)
                                <span class="inline-block px-2 py-0.5 rounded-full bg-green-100 text-green-700 text-xs">Actif</span>
                            @else
                                <span class="inline-block px-2 py-0.5 rounded-full bg-neutral-100 text-neutral-500 text-xs">Inactif</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-right text-neutral-500">{{ $product->reviews_count }}</td>
                        <td class="px-4 py-2 text-right">
                            <form method="POST" action="{{ route('admin.produits.destroy', $product) }}"
                                  onsubmit="return confirm('Supprimer ce produit ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-neutral-400 hover:text-red-600">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="px-4 py-6 text-center text-neutral-400">Aucun produit.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $products->links() }}</div>
@endsection
