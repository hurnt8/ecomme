@extends('layouts.admin')

@section('title', 'Catégories')

@section('content')
    <div class="flex justify-end mb-4">
        <a href="{{ route('admin.categories.create') }}" class="rounded-md bg-neutral-900 text-white text-sm px-4 py-2 hover:bg-neutral-800">
            + Nouvelle catégorie
        </a>
    </div>

    <div class="bg-white rounded-lg border border-neutral-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-neutral-50 text-neutral-500 text-xs uppercase">
                <tr>
                    <th class="text-left px-4 py-2">Nom</th>
                    <th class="text-left px-4 py-2">Parent</th>
                    <th class="text-right px-4 py-2">Ordre</th>
                    <th class="text-right px-4 py-2">Produits</th>
                    <th class="text-center px-4 py-2">Statut</th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-100">
                @forelse ($categories as $category)
                    <tr>
                        <td class="px-4 py-2">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="font-medium hover:underline">{{ $category->name }}</a>
                        </td>
                        <td class="px-4 py-2 text-neutral-500">{{ $category->parent?->name ?? '—' }}</td>
                        <td class="px-4 py-2 text-right">{{ $category->sort_order }}</td>
                        <td class="px-4 py-2 text-right">{{ $category->products_count }}</td>
                        <td class="px-4 py-2 text-center">
                            @if ($category->is_active)
                                <span class="inline-block px-2 py-0.5 rounded-full bg-green-100 text-green-700 text-xs">Active</span>
                            @else
                                <span class="inline-block px-2 py-0.5 rounded-full bg-neutral-100 text-neutral-500 text-xs">Inactive</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-right">
                            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}"
                                  onsubmit="return confirm('Supprimer cette catégorie ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-neutral-400 hover:text-red-600">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-6 text-center text-neutral-400">Aucune catégorie.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
