<nav class="fh5co-nav" role="navigation">
    <div class="container">
        <div class="row">
            {{-- col-xs-8 (not the template's original col-xs-2, sized for its short "Shop." logo): menu-1/menu-2
                 are display:none below 768px anyway, so this only needs to fit our longer site name before
                 the absolutely-positioned .fh5co-nav-toggle hamburger on the right. --}}
            <div class="col-md-3 col-xs-8">
                <div id="fh5co-logo"><a href="{{ route('home') }}">{{ $settings->site_name }}</a></div>
            </div>
            {{-- col-md-5 (not the template's original col-md-6): freed up a column for menu-2 below,
                 which now carries two icons (account + cart) instead of the template's one. --}}
            <div class="col-md-5 col-xs-6 text-center menu-1">
                <ul>
                    <li class="has-dropdown">
                        <a href="{{ route('catalog') }}">Boutique</a>
                        <ul class="dropdown">
                            <li><a href="{{ route('catalog') }}">Toute la boutique</a></li>
                            @foreach ($navCategories as $category)
                                <li><a href="{{ route('catalog', ['category' => $category->slug]) }}">{{ $category->name }}</a></li>
                            @endforeach
                            <li><a href="{{ route('catalog', ['on_sale' => 1]) }}">Promotions</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ url('/a-propos') }}">À propos</a></li>
                    <li><a href="{{ url('/contact') }}">Contact</a></li>
                    <li><a href="{{ route('tracking.index') }}">Suivi de commande</a></li>
                </ul>
            </div>
            {{-- col-md-4 (not the template's original col-md-3): see note on menu-1 above. --}}
            <div class="col-md-4 col-xs-4 text-right hidden-xs menu-2">
                <ul>
                    <li class="search">
                        <form class="input-group" action="{{ route('catalog') }}" method="GET">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher..">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
                            </span>
                        </form>
                    </li>
                    <li class="shopping-cart">
                        <a href="{{ auth()->check() ? route('account.index') : route('login') }}" class="cart" title="{{ auth()->check() ? 'Mon compte' : 'Connexion' }}">
                            <span><i class="icon-user"></i></span>
                            <span class="offcanvas-label">{{ auth()->check() ? 'Mon compte' : 'Connexion' }}</span>
                        </a>
                    </li>
                    <li class="shopping-cart">
                        <a href="{{ route('cart.index') }}" class="cart">
                            <span><small>{{ $cartCount }}</small><i class="icon-shopping-cart"></i></span>
                            <span class="offcanvas-label">Panier</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
