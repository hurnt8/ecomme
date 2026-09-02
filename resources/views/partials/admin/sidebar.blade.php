<aside class="w-60 shrink-0 bg-neutral-900 text-neutral-100 flex flex-col">
    <div class="px-5 py-5 text-sm font-semibold border-b border-neutral-800">
        {{ $settings->site_name }}
        <span class="block text-xs font-normal text-neutral-400">Administration</span>
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
            <a href="{{ route($link['route']) }}"
               class="block px-5 py-2.5 {{ request()->routeIs($link['active']) ? 'bg-neutral-800 text-white' : 'text-neutral-300 hover:bg-neutral-800 hover:text-white' }}">
                {{ $link['label'] }}
            </a>
        @endforeach
    </nav>

    <a href="{{ route('home') }}" target="_blank" class="px-5 py-3 text-xs text-neutral-400 border-t border-neutral-800 hover:text-white">
        Voir la boutique →
    </a>
</aside>
