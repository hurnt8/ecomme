@extends('layouts.admin')

@section('title', 'Bannières')

@section('content')
    <div class="flex justify-end mb-4">
        <a href="{{ route('admin.bannieres.create') }}" class="rounded-md bg-brand-400 px-4 py-2 text-sm font-medium text-neutral-900 transition-colors hover:bg-brand-500">
            + Nouvelle bannière
        </a>
    </div>

    <div class="bg-white rounded-lg border border-neutral-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-neutral-50 text-neutral-500 text-xs uppercase">
                <tr>
                    <th class="text-left px-4 py-2"></th>
                    <th class="text-left px-4 py-2">Titre</th>
                    <th class="text-left px-4 py-2">Emplacement</th>
                    <th class="text-right px-4 py-2">Ordre</th>
                    <th class="text-center px-4 py-2">Statut</th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-100">
                @forelse ($banners as $banner)
                    <tr>
                        <td class="px-4 py-2">
                            <img src="{{ $banner->image_url }}" alt="" class="w-14 h-10 object-cover rounded">
                        </td>
                        <td class="px-4 py-2">
                            <a href="{{ route('admin.bannieres.edit', $banner) }}" class="font-medium hover:underline">{{ $banner->title }}</a>
                        </td>
                        <td class="px-4 py-2 text-neutral-500">{{ $banner->position }}</td>
                        <td class="px-4 py-2 text-right">{{ $banner->sort_order }}</td>
                        <td class="px-4 py-2 text-center">
                            @if ($banner->is_active)
                                <span class="inline-block px-2 py-0.5 rounded-full bg-sage-100 text-sage-700 text-xs">Active</span>
                            @else
                                <span class="inline-block px-2 py-0.5 rounded-full bg-neutral-100 text-neutral-500 text-xs">Inactive</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-right">
                            <form method="POST" action="{{ route('admin.bannieres.destroy', $banner) }}"
                                  onsubmit="return confirm('Supprimer cette bannière ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-neutral-400 hover:text-clay-600">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-6 text-center text-neutral-400">Aucune bannière.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
