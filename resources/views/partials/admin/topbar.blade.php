<header class="h-14 flex items-center justify-between px-6 border-b border-neutral-200 bg-white">
    <h1 class="text-sm font-medium text-neutral-700">@yield('title', 'Tableau de bord')</h1>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="text-sm text-neutral-500 hover:text-neutral-900">
            {{ auth()->user()->name }} · Déconnexion
        </button>
    </form>
</header>
