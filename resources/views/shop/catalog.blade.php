@extends('layouts.shop')

@section('title', 'Boutique')
@section('meta_description', 'Découvrez notre sélection de matériel de motoculture, d\'outils portés pour tracteur et de bois de chauffage.')

@php
    // Links that keep the rest of the query intact, so changing one filter never silently
    // discards the others (and never carries a stale page number).
    $baseQuery = request()->except(['page']);
    $activeFilters = collect();

    if ($slug = request('category')) {
        $name = $categories->firstWhere('slug', $slug)?->name ?? $slug;
        $activeFilters->push(['label' => $name, 'remove' => route('catalog', collect($baseQuery)->except('category')->all())]);
    }
    if ($value = request('color')) {
        $activeFilters->push(['label' => $value, 'remove' => route('catalog', collect($baseQuery)->except('color')->all())]);
    }
    if ($value = request('size')) {
        $activeFilters->push(['label' => 'Taille : '.$value, 'remove' => route('catalog', collect($baseQuery)->except('size')->all())]);
    }
    if (request()->filled('min_price') || request()->filled('max_price')) {
        $activeFilters->push([
            'label' => 'Prix : '.(request('min_price') ?: '0').' – '.(request('max_price') ?: '∞').' '.$settings->currency_symbol,
            'remove' => route('catalog', collect($baseQuery)->except(['min_price', 'max_price'])->all()),
        ]);
    }
    if (request()->boolean('in_stock')) {
        $activeFilters->push(['label' => 'En stock', 'remove' => route('catalog', collect($baseQuery)->except('in_stock')->all())]);
    }
    if (request()->boolean('is_new')) {
        $activeFilters->push(['label' => 'Nouveautés', 'remove' => route('catalog', collect($baseQuery)->except('is_new')->all())]);
    }
    if (request()->boolean('on_sale')) {
        $activeFilters->push(['label' => 'En promotion', 'remove' => route('catalog', collect($baseQuery)->except('on_sale')->all())]);
    }
    if ($value = request('search')) {
        $activeFilters->push(['label' => '« '.$value.' »', 'remove' => route('catalog', collect($baseQuery)->except('search')->all())]);
    }
@endphp

@section('content')
    <header id="fh5co-header" class="fh5co-cover fh5co-cover-sm fh5co-cover-compact" role="banner" style="background-image:url('{{ asset('images/hero-boutique.jpg') }}');">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 text-center">
                    <div class="display-t">
                        <div class="display-tc animate-box" data-animate-effect="fadeIn">
                            <h1>Boutique</h1>
                            <h2>{{ $products->total() }} pièce{{ $products->total() > 1 ? 's' : '' }} sélectionnée{{ $products->total() > 1 ? 's' : '' }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div id="fh5co-product" class="catalog">
        <div class="container">
            @if ($promoBanners->isNotEmpty())
                <div class="row animate-box">
                    @foreach ($promoBanners as $banner)
                        <div class="col-md-{{ $promoBanners->count() > 1 ? 6 : 12 }}">
                            <x-shop.promo-banner :banner="$banner" :show-countdown="$banner->position === 'shop_sale'" />
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- One form spanning both columns: the sidebar inputs and the toolbar's sort control
                 submit together, so sorting never drops the active filters and vice versa. --}}
            <form method="GET" action="{{ route('catalog') }}" x-data="{ filtersOpen: false }">
                <input type="hidden" name="search" value="{{ request('search') }}">
                <input type="hidden" name="category" value="{{ request('category') }}">

                <div class="row">
                    <div class="col-md-3">
                        <button type="button" class="catalog-filters-toggle" @click="filtersOpen = !filtersOpen">
                            <span x-text="filtersOpen ? 'Masquer les filtres' : 'Filtrer'">Filtrer</span>
                            @if ($activeFilters->isNotEmpty())
                                <span class="catalog-filters-count">{{ $activeFilters->count() }}</span>
                            @endif
                        </button>

                        <aside class="catalog-filters" :class="{ 'is-open': filtersOpen }">
                            <div class="catalog-filter-group">
                                <h3>Catégories</h3>
                                <ul class="catalog-filter-list">
                                    <li>
                                        <a href="{{ route('catalog', collect($baseQuery)->except('category')->all()) }}"
                                           class="{{ request('category') ? '' : 'is-active' }}">
                                            Toutes les pièces
                                        </a>
                                    </li>
                                    @foreach ($categories as $category)
                                        <li>
                                            <a href="{{ route('catalog', collect($baseQuery)->except('page')->merge(['category' => $category->slug])->all()) }}"
                                               class="{{ request('category') === $category->slug ? 'is-active' : '' }}">
                                                {{ $category->name }}
                                                <span class="catalog-filter-qty">{{ $category->products_count }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="catalog-filter-group">
                                <h3>Prix</h3>
                                <div class="catalog-filter-price">
                                    <input type="number" name="min_price" value="{{ request('min_price') }}" class="form-control" placeholder="Min" aria-label="Prix minimum">
                                    <span>–</span>
                                    <input type="number" name="max_price" value="{{ request('max_price') }}" class="form-control" placeholder="Max" aria-label="Prix maximum">
                                </div>
                            </div>

                            @if (count($colors))
                                <div class="catalog-filter-group">
                                    <h3>Coloris</h3>
                                    <select name="color" class="form-control" onchange="this.form.submit()">
                                        <option value="">Tous</option>
                                        @foreach ($colors as $color)
                                            <option value="{{ $color }}" @selected(request('color') === $color)>{{ $color }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            @if (count($sizes))
                                <div class="catalog-filter-group">
                                    <h3>Taille</h3>
                                    <select name="size" class="form-control" onchange="this.form.submit()">
                                        <option value="">Toutes</option>
                                        @foreach ($sizes as $size)
                                            <option value="{{ $size }}" @selected(request('size') === $size)>{{ $size }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            <div class="catalog-filter-group">
                                <h3>Disponibilité</h3>
                                <label class="catalog-filter-check">
                                    <input type="checkbox" name="in_stock" value="1" @checked(request()->boolean('in_stock')) onchange="this.form.submit()">
                                    En stock uniquement
                                </label>
                                <label class="catalog-filter-check">
                                    <input type="checkbox" name="is_new" value="1" @checked(request()->boolean('is_new')) onchange="this.form.submit()">
                                    Nouveautés
                                </label>
                                <label class="catalog-filter-check">
                                    <input type="checkbox" name="on_sale" value="1" @checked(request()->boolean('on_sale')) onchange="this.form.submit()">
                                    En promotion
                                </label>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">Appliquer</button>
                            @if ($activeFilters->isNotEmpty())
                                <a href="{{ route('catalog') }}" class="catalog-filters-reset">Tout réinitialiser</a>
                            @endif
                        </aside>
                    </div>

                    <div class="col-md-9">
                        <div class="catalog-toolbar">
                            <p class="catalog-count">
                                <strong>{{ $products->total() }}</strong>
                                {{ $products->total() > 1 ? 'pièces' : 'pièce' }}
                                @if ($activeFilters->isNotEmpty())
                                    correspondant à votre sélection
                                @endif
                            </p>

                            <div class="catalog-sort">
                                <label for="filter-sort">Trier par</label>
                                <select name="sort" id="filter-sort" class="form-control" onchange="this.form.submit()">
                                    <option value="newest" @selected($sort === 'newest')>Plus récents</option>
                                    <option value="price_asc" @selected($sort === 'price_asc')>Prix croissant</option>
                                    <option value="price_desc" @selected($sort === 'price_desc')>Prix décroissant</option>
                                    <option value="name_asc" @selected($sort === 'name_asc')>Nom (A-Z)</option>
                                </select>
                            </div>
                        </div>

                        @if ($activeFilters->isNotEmpty())
                            <div class="catalog-chips">
                                @foreach ($activeFilters as $filter)
                                    <a href="{{ $filter['remove'] }}" class="catalog-chip">
                                        {{ $filter['label'] }}<span aria-hidden="true">&times;</span>
                                    </a>
                                @endforeach
                            </div>
                        @endif

                        @forelse ($products->chunk(3) as $row)
                            <div class="row">
                                @foreach ($row as $product)
                                    <x-shop.product-card :product="$product" />
                                @endforeach
                            </div>
                        @empty
                            <div class="catalog-empty">
                                <h3>Aucune pièce ne correspond à ces critères</h3>
                                <p>Essayez d'élargir votre recherche ou de retirer un filtre.</p>
                                <a href="{{ route('catalog') }}" class="btn btn-primary btn-outline">Voir toute la boutique</a>
                            </div>
                        @endforelse

                        @if ($products->hasPages())
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    {{ $products->links('partials.shop.pagination') }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
