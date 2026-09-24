<header class="h-14 flex items-center justify-between px-6 border-b border-neutral-200 bg-white">
    <h1 class="admin-page-title text-lg text-neutral-900">@yield('title', 'Tableau de bord')</h1>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="rounded-md px-3 py-1.5 text-sm text-neutral-500 transition-colors hover:bg-neutral-100 hover:text-neutral-900">
            {{ auth()->user()->name }} · Déconnexion
        </button>
    </form>
</header>
