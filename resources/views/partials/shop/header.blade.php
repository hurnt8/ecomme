{{-- Laid out after guerrinibois.fr: a dark main row (logo, catalogue search with a category picker,
     account and basket) over a menu bar carrying the phone number. The menu-1 / menu-2 class names
     are kept because site.js clones `.menu-1 > ul` and `.menu-2 > ul` into the mobile off-canvas
     panel. data-cart-count seeds $store.cart (resources/js/modules/cart.js), which keeps both
     basket badges current when items are added in the background. --}}
<nav class="fh5co-nav site-header" role="navigation" data-cart-count="{{ $cartCount }}">
    <div class="site-header-main">
        <div class="container">
            <div class="site-header-main-row">
                {{-- The uploaded logo already carries the wordmark, so it replaces the text rather
                     than sitting next to it. Text remains the fallback when none is uploaded. --}}
                <div id="fh5co-logo" @class(['site-header-logo', 'has-logo-image' => $settings->logo_url])>
                    <a href="{{ route('home') }}">
                        @if ($settings->logo_url)
                            <img src="{{ $settings->logo_url }}" alt="{{ $settings->site_name }}" class="fh5co-logo-image">
                        @else
                            {{ $settings->site_name }}
                        @endif
                    </a>
                </div>

                <form class="site-header-search" action="{{ route('catalog') }}" method="GET" role="search">
                    <select name="category" aria-label="Catégorie">
                        <option value="">Toutes les catégories</option>
                        @foreach ($navCategories as $category)
                            <option value="{{ $category->slug }}" @selected(request('category') === $category->slug)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher un produit…" aria-label="Rechercher un produit">
                    <button type="submit">Rechercher</button>
                </form>

                <div class="site-header-actions">
                    <a href="{{ auth()->check() ? route('account.index') : route('login') }}" class="site-header-account">
                        <i class="icon-user"></i>
                        <span>
                            <small>Mon compte</small>
                            <strong>{{ auth()->check() ? auth()->user()->name : 'Connexion / Inscription' }}</strong>
                        </span>
                    </a>
                    <a href="{{ route('cart.index') }}" class="site-header-cart" aria-label="Panier ({{ $cartCount }})"
                       x-data :aria-label="`Panier (${$store.cart.count})`">
                        <i class="icon-shopping-cart"></i>
                        <span class="site-header-cart-count" x-text="$store.cart.count">{{ $cartCount }}</span>
                    </a>
                </div>

                {{-- Mobile only: the search, account and basket above are hidden below 769px. The
                     basket stays out of the burger panel so its count is readable without opening
                     anything; site.js reuses this burger rather than injecting its own. --}}
                <div class="fh5co-nav-toggle-col">
                    <a href="{{ route('cart.index') }}" class="fh5co-mobile-cart" aria-label="Panier ({{ $cartCount }})"
                       x-data :aria-label="`Panier (${$store.cart.count})`">
                        <i class="icon-shopping-cart"></i>
                        {{-- Rendered even for an empty basket, hidden, so the first item added in the
                             background can show it. `hidden` rather than x-show: x-show defers hiding
                             to an animation frame, and a basket emptied in the background could be left
                             showing "0". --}}
                        <span class="fh5co-mobile-cart-count" :hidden="$store.cart.count === 0" x-text="$store.cart.count"
                              @if ($cartCount === 0) hidden @endif>{{ $cartCount }}</span>
                    </a>
                    <a href="#" class="js-fh5co-nav-toggle fh5co-nav-toggle" aria-label="Ouvrir le menu" aria-expanded="false"><i></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="site-header-bar">
        <div class="container">
            <div class="site-header-bar-row">
                <div class="menu-1">
                    <ul>
                        <li @class(['active' => request()->routeIs('home')])><a href="{{ route('home') }}">Accueil</a></li>
                        <li @class(['active' => request()->routeIs('pages.about')])><a href="{{ route('pages.about') }}">À propos</a></li>
                        <li @class(['has-dropdown', 'active' => request()->routeIs('catalog', 'product.show')])>
                            <a href="{{ route('catalog') }}">Boutique</a>
                            <ul class="dropdown">
                                <li><a href="{{ route('catalog') }}">Toute la boutique</a></li>
                                @foreach ($navCategories as $category)
                                    <li><a href="{{ route('catalog', ['category' => $category->slug]) }}">{{ $category->name }}</a></li>
                                @endforeach
                                <li><a href="{{ route('catalog', ['on_sale' => 1]) }}">Promotions</a></li>
                            </ul>
                        </li>
                        <li @class(['active' => request()->routeIs('account.*')])><a href="{{ auth()->check() ? route('account.index') : route('login') }}">Mon compte</a></li>
                        <li @class(['active' => request()->routeIs('contact.*')])><a href="{{ route('contact.index') }}">Contact</a></li>
                        <li @class(['active' => request()->routeIs('tracking.*')])><a href="{{ route('tracking.index') }}">Suivi de commande</a></li>
                    </ul>
                </div>

                @if ($settings->contact_phone)
                    <a href="tel:{{ preg_replace('/[^\d+]/', '', $settings->contact_phone) }}" class="site-header-phone">Appelez-nous : {{ $settings->contact_phone }}</a>
                @endif
            </div>
        </div>
    </div>

    {{-- Never shown in the header itself: only here for site.js to clone the search box into the
         off-canvas panel, under the menu. "Mon compte" already comes with the menu above. --}}
    <div class="menu-2">
        <ul>
            <li class="search">
                <form class="input-group" action="{{ route('catalog') }}" method="GET">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher..">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
                    </span>
                </form>
            </li>
        </ul>
    </div>
</nav>
