@extends('layouts.shop')

@section('title', $product->name)
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($product->description), 150))

@section('content')
    <div id="fh5co-product">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1 animate-box">
                    <div class="owl-carousel owl-carousel-fullwidth product-carousel">
                        @forelse ($product->images as $image)
                            <div class="item">
                                <div class="active text-center">
                                    <figure>
                                        <img src="{{ $image->url }}" alt="{{ $product->name }}">
                                    </figure>
                                </div>
                            </div>
                        @empty
                            <div class="item">
                                <div class="active text-center">
                                    <figure>
                                        <img src="{{ asset('template/images/product-1.jpg') }}" alt="{{ $product->name }}">
                                    </figure>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <div class="row animate-box">
                        <div class="col-md-8 col-md-offset-2 text-center fh5co-heading">
                            <h2>{{ $product->name }}</h2>
                            <p><x-shop.price :price="$product->price" :compare-at-price="$product->compare_at_price" /></p>

                            @if ($product->stock > 0)
                                <form method="POST" action="{{ route('cart.store') }}" x-data="{ quantity: 1, max: {{ $product->stock }} }">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                                    <div style="display:flex;justify-content:center;gap:10px;flex-wrap:wrap;margin-bottom:15px;">
                                        @if ($product->sizes)
                                            <select name="size" class="form-control" style="width:auto;display:inline-block;">
                                                @foreach ($product->sizes as $size)
                                                    <option value="{{ $size }}">{{ $size }}</option>
                                                @endforeach
                                            </select>
                                        @endif

                                        @if ($product->colors)
                                            <select name="color" class="form-control" style="width:auto;display:inline-block;">
                                                @foreach ($product->colors as $color)
                                                    <option value="{{ $color }}">{{ $color }}</option>
                                                @endforeach
                                            </select>
                                        @endif

                                        <span class="input-group" style="width:120px;display:inline-flex;">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-default" @click="quantity = Math.max(1, quantity - 1)">-</button>
                                            </span>
                                            <input type="number" name="quantity" x-model.number="quantity" min="1" :max="max" class="form-control text-center">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-default" @click="quantity = Math.min(max, quantity + 1)">+</button>
                                            </span>
                                        </span>
                                    </div>

                                    <p><button type="submit" class="btn btn-primary btn-outline btn-lg">Ajouter au panier</button></p>
                                </form>
                                <p class="text-muted">{{ $product->stock }} en stock</p>
                            @else
                                <p><span class="btn btn-default btn-outline btn-lg disabled">Rupture de stock</span></p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="fh5co-tabs animate-box">
                        <ul class="fh5co-tab-nav">
                            <li class="active"><a href="#" data-tab="1"><span class="icon visible-xs"><i class="icon-file"></i></span><span class="hidden-xs">Description</span></a></li>
                            <li><a href="#" data-tab="2"><span class="icon visible-xs"><i class="icon-bar-graph"></i></span><span class="hidden-xs">Livraison &amp; retours</span></a></li>
                            <li><a href="#" data-tab="3"><span class="icon visible-xs"><i class="icon-star"></i></span><span class="hidden-xs">Avis ({{ $product->reviews->count() }})</span></a></li>
                        </ul>

                        <div class="fh5co-tab-content-wrap">
                            <div class="fh5co-tab-content tab-content active" data-tab-content="1">
                                <div class="col-md-10 col-md-offset-1">
                                    <h2>{{ $product->name }}</h2>
                                    @if ($product->category)
                                        <p class="text-muted">{{ $product->category->name }}</p>
                                    @endif
                                    <p style="white-space:pre-line;">{{ $product->description }}</p>
                                </div>
                            </div>

                            <div class="fh5co-tab-content tab-content" data-tab-content="2">
                                <div class="col-md-10 col-md-offset-1">
                                    <h3>Livraison</h3>
                                    <ul>
                                        <li>Livraison offerte dès {{ number_format((float) $settings->free_shipping_threshold, 0) }}&nbsp;{{ $settings->currency }} d'achat, hors zone euro : frais de {{ number_format((float) $settings->international_shipping_fee, 0) }}&nbsp;{{ $settings->currency }} supplémentaires.</li>
                                        <li>Expédition sous 2 à 5 jours ouvrés selon disponibilité.</li>
                                    </ul>
                                    <h3>Retours</h3>
                                    <ul>
                                        <li>30 jours pour changer d'avis, retour gratuit.</li>
                                        <li>Article à retourner dans son emballage d'origine.</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="fh5co-tab-content tab-content" data-tab-content="3">
                                <div class="col-md-10 col-md-offset-1">
                                    <h3>Avis clients</h3>

                                    @if ($product->reviews->isEmpty())
                                        <p>Aucun avis pour le moment.</p>
                                    @else
                                        <div class="feed">
                                            @foreach ($product->reviews as $review)
                                                <div>
                                                    <blockquote>
                                                        <p>{{ $review->comment }}</p>
                                                    </blockquote>
                                                    <h3>&mdash; {{ $review->author_name }}</h3>
                                                    <span class="rate">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <i class="icon-star2" style="{{ $i > $review->rating ? 'opacity:.3' : '' }}"></i>
                                                        @endfor
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if ($related->isNotEmpty())
                <div class="row animate-box" style="margin-top:40px;">
                    <div class="col-md-8 col-md-offset-2 text-center fh5co-heading">
                        <span>Vous aimerez aussi</span>
                        <h2>Produits liés</h2>
                    </div>
                </div>
                <div class="row">
                    @foreach ($related as $relatedProduct)
                        <x-shop.product-card :product="$relatedProduct" />
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
