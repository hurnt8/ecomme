<aside class="w-60 shrink-0 bg-neutral-900 text-neutral-100 flex flex-col">
    <div class="px-5 py-5 border-b border-neutral-800">
        {{-- The shop wordmark is Playfair on the storefront header; the sidebar carries the same
             mark so the back-office opens on a familiar name rather than on a generic label. --}}
        <span class="admin-page-title block text-base text-white">{{ $settings->site_name }}</span>
        <span class="mt-1 block text-[11px] uppercase tracking-[0.16em] text-brand-400">Administration</span>
    </div>

    @php
        // 'admin' marks the entries a supervisor cannot reach. The routes refuse them anyway —
        // this only keeps the menu honest about what the person in front of it can actually open.
        $links = [
            ['route' => 'admin.dashboard', 'active' => 'admin.dashboard', 'label' => 'Tableau de bord', 'admin' => true],
            ['route' => 'admin.commandes.index', 'active' => 'admin.commandes.*', 'label' => 'Commandes', 'admin' => false],
            ['route' => 'admin.produits.index', 'active' => 'admin.produits.*', 'label' => 'Produits', 'admin' => true],
            ['route' => 'admin.categories.index', 'active' => 'admin.categories.*', 'label' => 'Catégories', 'admin' => true],
            ['route' => 'admin.bannieres.index', 'active' => 'admin.bannieres.*', 'label' => 'Bannières', 'admin' => true],
            ['route' => 'admin.utilisateurs.index', 'active' => 'admin.utilisateurs.*', 'label' => 'Utilisateurs', 'admin' => true],
            ['route' => 'admin.reglages.edit', 'active' => 'admin.reglages.*', 'label' => 'Réglages', 'admin' => true],
        ];

        $links = array_filter($links, fn ($link) => ! $link['admin'] || auth()->user()->isAdmin());
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
