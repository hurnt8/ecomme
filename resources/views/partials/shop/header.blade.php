<nav class="fh5co-nav" role="navigation">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-xs-2">
                <div id="fh5co-logo"><a href="{{ route('home') }}">{{ $settings->site_name }}</a></div>
            </div>
            <div class="col-md-6 col-xs-6 text-center menu-1">
                <ul>
                    <li><a href="{{ route('catalog') }}">Boutique</a></li>
                    <li><a href="{{ url('/a-propos') }}">À propos</a></li>
                    <li><a href="{{ url('/contact') }}">Contact</a></li>
                    <li><a href="{{ route('tracking.index') }}">Suivi de commande</a></li>
                </ul>
            </div>
            <div class="col-md-3 col-xs-4 text-right hidden-xs menu-2">
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
                        <a href="{{ route('cart.index') }}" class="cart">
                            <span><small>{{ $cartCount }}</small><i class="icon-shopping-cart"></i></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
