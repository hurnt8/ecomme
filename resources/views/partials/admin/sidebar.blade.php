<aside class="w-60 shrink-0 bg-neutral-900 text-neutral-100 flex flex-col">
    <div class="px-5 py-5 text-sm font-semibold border-b border-neutral-800">
        {{ $settings->site_name }}
        <span class="block text-xs font-normal text-neutral-400">Administration</span>
    </div>

    <nav class="flex-1 py-4 text-sm">
        <a href="{{ route('admin.dashboard') }}"
           class="block px-5 py-2.5 {{ request()->routeIs('admin.dashboard') ? 'bg-neutral-800 text-white' : 'text-neutral-300 hover:bg-neutral-800 hover:text-white' }}">
            Tableau de bord
        </a>
        {{-- Produits, catégories, bannières, commandes, réglages : ajoutés en Phase 6 (back-office) --}}
    </nav>
</aside>
