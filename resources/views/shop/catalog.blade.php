@extends('layouts.shop')

@section('title', 'Boutique')
@section('meta_description', 'Découvrez notre sélection de mobilier et objets de décoration.')

@section('content')
    <header id="fh5co-header" class="fh5co-cover fh5co-cover-sm" role="banner" style="background-image:url('{{ asset('template/images/img_bg_2.jpg') }}');">
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

    <div id="fh5co-product">
        <div class="container">
            <div class="row animate-box">
                <div class="col-md-12">
                    <form method="GET" action="{{ route('catalog') }}" class="form-inline" style="margin-bottom:30px;">
                        <div class="form-group" style="margin-right:10px;">
                            <select name="category" class="form-control" onchange="this.form.submit()">
                                <option value="">Toutes les catégories</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->slug }}" @selected(request('category') === $category->slug)>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        @if (count($sizes))
                            <div class="form-group" style="margin-right:10px;">
                                <select name="size" class="form-control" onchange="this.form.submit()">
                                    <option value="">Toutes les tailles</option>
                                    @foreach ($sizes as $size)
                                        <option value="{{ $size }}" @selected(request('size') === $size)>{{ $size }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        @if (count($colors))
                            <div class="form-group" style="margin-right:10px;">
                                <select name="color" class="form-control" onchange="this.form.submit()">
                                    <option value="">Toutes les couleurs</option>
                                    @foreach ($colors as $color)
                                        <option value="{{ $color }}" @selected(request('color') === $color)>{{ $color }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <div class="form-group" style="margin-right:10px;">
                            <input type="number" name="min_price" value="{{ request('min_price') }}" class="form-control" placeholder="Prix min" style="width:110px;">
                        </div>
                        <div class="form-group" style="margin-right:10px;">
                            <input type="number" name="max_price" value="{{ request('max_price') }}" class="form-control" placeholder="Prix max" style="width:110px;">
                        </div>

                        <div class="checkbox" style="display:inline-block;margin-right:10px;">
                            <label>
                                <input type="checkbox" name="in_stock" value="1" @checked(request()->boolean('in_stock')) onchange="this.form.submit()">
                                En stock
                            </label>
                        </div>

                        <div class="checkbox" style="display:inline-block;margin-right:10px;">
                            <label>
                                <input type="checkbox" name="is_new" value="1" @checked(request()->boolean('is_new')) onchange="this.form.submit()">
                                Nouveautés
                            </label>
                        </div>

                        <div class="form-group" style="margin-right:10px;">
                            <select name="sort" class="form-control" onchange="this.form.submit()">
                                <option value="newest" @selected($sort === 'newest')>Plus récents</option>
                                <option value="price_asc" @selected($sort === 'price_asc')>Prix croissant</option>
                                <option value="price_desc" @selected($sort === 'price_desc')>Prix décroissant</option>
                                <option value="name_asc" @selected($sort === 'name_asc')>Nom (A-Z)</option>
                            </select>
                        </div>

                        <input type="hidden" name="search" value="{{ request('search') }}">

                        <button type="submit" class="btn btn-primary">Filtrer</button>
                        @if (request()->anyFilled(['category', 'size', 'color', 'min_price', 'max_price', 'in_stock', 'is_new', 'search']))
                            <a href="{{ route('catalog') }}" class="btn btn-default">Réinitialiser</a>
                        @endif
                    </form>

                    @if (request()->filled('search'))
                        <p>Résultats pour « {{ request('search') }} »</p>
                    @endif
                </div>
            </div>

            @forelse ($products->chunk(3) as $row)
                <div class="row">
                    @foreach ($row as $product)
                        <x-shop.product-card :product="$product" />
                    @endforeach
                </div>
            @empty
                <div class="row">
                    <div class="col-md-12 text-center">
                        <p>Aucune pièce ne correspond à ces critères pour le moment.</p>
                    </div>
                </div>
            @endforelse

            <div class="row">
                <div class="col-md-12 text-center">
                    {{ $products->links('partials.shop.pagination') }}
                </div>
            </div>
        </div>
    </div>
@endsection
