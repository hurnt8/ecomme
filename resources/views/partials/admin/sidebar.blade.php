<aside class="w-60 shrink-0 bg-neutral-900 text-neutral-100 flex flex-col">
    <div class="px-5 py-5 border-b border-neutral-800">
        <span class="block text-sm font-semibold text-white">{{ $settings->site_name }}</span>
        <span class="mt-1 block text-[11px] uppercase tracking-[0.16em] text-brand-400">Administration</span>
    </div>

    @php
        $links = [
            ['route' => 'admin.dashboard', 'active' => 'admin.dashboard', 'label' => 'Tableau de bord'],
            ['route' => 'admin.produits.index', 'active' => 'admin.produits.*', 'label' => 'Produits'],
            ['route' => 'admin.categories.index', 'active' => 'admin.categories.*', 'label' => 'Catégories'],
            ['route' => 'admin.bannieres.index', 'active' => 'admin.bannieres.*', 'label' => 'Bannières'],
            ['route' => 'admin.commandes.index', 'active' => 'admin.commandes.*', 'label' => 'Commandes'],
            ['route' => 'admin.reglages.edit', 'active' => 'admin.reglages.*', 'label' => 'Réglages'],
        ];
    @endphp

    <nav class="flex-1 py-4 text-sm">
        @foreach ($links as $link)
            {{-- The active item is marked by a gold rule rather than by background alone: on a
                 near-black sidebar a one-step background change is barely perceptible. --}}
            <a href="{{ route($link['route']) }}"
               @class([
                   'block border-l-2 px-5 py-2.5 transition-colors',
                   'border-brand-400 bg-neutral-800 font-medium text-white' => request()->routeIs($link['active']),
                   'border-transparent text-neutral-400 hover:border-neutral-700 hover:bg-neutral-800 hover:text-white' => ! request()->routeIs($link['active']),
               ])>
                {{ $link['label'] }}
            </a>
        @endforeach
    </nav>

    <a href="{{ route('home') }}" target="_blank" class="border-t border-neutral-800 px-5 py-3 text-xs text-neutral-400 transition-colors hover:text-brand-400">
        Voir la boutique →
    </a>
</aside>
