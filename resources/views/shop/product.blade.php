@extends('layouts.shop')

@section('title', $product->name)
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($product->description), 150))

@php
    $galleryImages = $product->images->map(fn ($image) => $image->url)->values();

    // thumbnail_url resolves to the neutral placeholder rather than another product's photo.
    if ($galleryImages->isEmpty()) {
        $galleryImages = collect([$product->thumbnail_url]);
    }

    $onSale = $product->compare_at_price && (float) $product->compare_at_price > (float) $product->price;
    $discount = $onSale
        ? (int) round(100 - ((float) $product->price / (float) $product->compare_at_price) * 100)
        : null;
    $averageRating = $product->reviews->avg('rating');
@endphp

@section('content')
    <div id="fh5co-product" class="product-detail">
        <div class="container">
            <ol class="product-breadcrumb">
                <li><a href="{{ route('home') }}">Startseite</a></li>
                <li><a href="{{ route('catalog') }}">Shop</a></li>
                @if ($product->category)
                    <li><a href="{{ route('catalog', ['category' => $product->category->slug]) }}">{{ $product->category->name }}</a></li>
                @endif
                <li class="is-current">{{ $product->name }}</li>
            </ol>

            <div class="row product-detail-main">
                {{-- Gallery: a main image plus thumbnails rather than the template's Owl carousel.
                     Every image is rendered server-side with a real src, so the gallery still works
                     without JS; Alpine only swaps which one is shown. --}}
                <div class="col-md-7">
                    <div class="product-gallery" x-data="{ active: 0 }">
                        <div class="product-gallery-main">
                            @if ($onSale)
                                <span class="product-gallery-badge product-gallery-badge-promo">-{{ $discount }}%</span>
                            @elseif ($product->is_new)
                                <span class="product-gallery-badge">Neu</span>
                            @endif

                            @foreach ($galleryImages as $index => $url)
                                <img src="{{ $url }}"
                                     alt="{{ $product->name }}"
                                     @if ($index > 0) x-cloak @endif
                                     x-show="active === {{ $index }}">
                            @endforeach
                        </div>

                        @if ($galleryImages->count() > 1)
                            <div class="product-gallery-thumbs">
                                @foreach ($galleryImages as $index => $url)
                                    <button type="button"
                                            class="product-gallery-thumb"
                                            :class="{ 'is-active': active === {{ $index }} }"
                                            @click="active = {{ $index }}"
                                            aria-label="Bild {{ $index + 1 }} ansehen">
                                        <img src="{{ $url }}" alt="">
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="product-summary">
                        @if ($product->category)
                            <a class="product-summary-category" href="{{ route('catalog', ['category' => $product->category->slug]) }}">
                                {{ $product->category->name }}
                            </a>
                        @endif

                        <h1 class="product-summary-title">{{ $product->name }}</h1>

                        @if ($product->reviews->isNotEmpty())
                            <div class="product-summary-rating">
                                <span class="rate">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="icon-star2" style="{{ $i > round($averageRating) ? 'opacity:.25' : '' }}"></i>
                                    @endfor
                                </span>
                                <span class="product-summary-rating-count">
                                    {{ number_format($averageRating, 1, ',', ' ') }}/5 &middot; {{ $product->reviews->count() }}
                                    {{ $product->reviews->count() === 1 ? 'Bewertung' : 'Bewertungen' }}
                                </span>
                            </div>
                        @endif

                        <div class="product-summary-price">
                            <x-shop.price :price="$product->price" :compare-at-price="$product->compare_at_price" />
                            @if ($onSale)
                                <span class="product-summary-discount">-{{ $discount }}%</span>
                            @endif
                        </div>

                        {{-- A teaser of a sentence or two, as on guerrinibois.fr: the full text is in
                             the Description tab below. --}}
                        @if ($product->description)
                            <p class="product-summary-excerpt">
                                {{ \Illuminate\Support\Str::limit(strip_tags(explode("\n", $product->description)[0]), 160, preserveWords: true) }}
                            </p>
                        @endif

                        @if ($product->stock > 0)
                            <form method="POST" action="{{ route('cart.store') }}" data-cart-form x-data="{ quantity: 1, max: {{ $product->stock }} }">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">

                                @if ($product->sizes)
                                    <div class="product-option">
                                        <label for="product-size">Größe</label>
                                        <select id="product-size" name="size" class="form-control">
                                            @foreach ($product->sizes as $size)
                                                <option value="{{ $size }}">{{ $size }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif

                                @if ($product->colors)
                                    <div class="product-option">
                                        <label for="product-color">Farben</label>
                                        <select id="product-color" name="color" class="form-control">
                                            @foreach ($product->colors as $color)
                                                <option value="{{ $color }}">{{ $color }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif

                                <div class="product-option">
                                    <label for="product-quantity">Menge</label>
                                    {{-- Not Bootstrap's .input-group (display:table, with a float:left,
                                         width:100% .form-control sized against its .input-group-btn
                                         siblings): that construction falls apart inside a flex parent,
                                         overlapping the buttons. Plain flex, explicitly sized. --}}
                                    <div class="product-quantity">
                                        <button type="button" class="btn btn-default" @click="quantity = Math.max(1, quantity - 1)" aria-label="Menge verringern">&minus;</button>
                                        <input id="product-quantity" type="number" name="quantity" x-model.number="quantity" min="1" :max="max" class="form-control text-center">
                                        <button type="button" class="btn btn-default" @click="quantity = Math.min(max, quantity + 1)" aria-label="Menge erhöhen">+</button>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary btn-lg product-add-to-cart">In den Warenkorb</button>
                            </form>

                            <p class="product-stock {{ $product->stock <= 3 ? 'is-low' : '' }}">
                                @if ($product->stock <= 3)
                                    Nur noch {{ $product->stock }} auf Lager — jetzt bestellen
                                @else
                                    Auf Lager ({{ $product->stock }} verfügbar)
                                @endif
                            </p>
                        @else
                            <p><span class="btn btn-default btn-outline btn-lg disabled product-add-to-cart">Nicht vorrätig</span></p>
                            <p class="product-stock is-out">Dieser Artikel ist vorübergehend nicht verfügbar.</p>
                        @endif

                        <ul class="product-reassurance">
                            <li>
                                <i class="icon-paper-plane"></i>
                                Kostenloser Versand ab {{ number_format((float) $settings->free_shipping_threshold, 0) }}&nbsp;{{ $settings->currency_symbol }} Bestellwert
                            </li>
                            <li><i class="icon-wallet"></i> 14 Tage Widerrufsrecht</li>
                            <li><i class="icon-credit-card"></i> Sichere Zahlung per Banküberweisung</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="fh5co-tabs animate-box">
                        <ul class="fh5co-tab-nav">
                            <li class="active"><a href="#" data-tab="1"><span class="icon visible-xs"><i class="icon-file"></i></span><span class="hidden-xs">Beschreibung</span></a></li>
                            <li><a href="#" data-tab="2"><span class="icon visible-xs"><i class="icon-bar-graph"></i></span><span class="hidden-xs">Versand &amp; Rücksendungen</span></a></li>
                            <li><a href="#" data-tab="3"><span class="icon visible-xs"><i class="icon-star"></i></span><span class="hidden-xs">Bewertungen ({{ $product->reviews->count() }})</span></a></li>
                        </ul>

                        <div class="fh5co-tab-content-wrap">
                            <div class="fh5co-tab-content tab-content active" data-tab-content="1">
                                {{-- Supplier descriptions run to several thousand characters, mostly in a
                                     single paragraph, which pushed the reviews and related products
                                     thousands of pixels down. Long ones are folded to a few lines behind
                                     "Lire la suite". Alpine applies the folded class, so without JS the
                                     text simply stays whole. --}}
                                @if (mb_strlen($product->description) > 600)
                                    <div class="product-description" x-data="{ open: false }" :class="{ 'is-collapsed': ! open }">
                                        <div class="product-description-text">{{ $product->description }}</div>
                                        <button type="button" class="product-description-toggle" x-cloak @click="open = ! open" :aria-expanded="open.toString()" x-text="open ? 'Weniger anzeigen' : 'Weiterlesen'">Weiterlesen</button>
                                    </div>
                                @else
                                    <p style="white-space:pre-line;">{{ $product->description }}</p>
                                @endif
                            </div>

                            <div class="fh5co-tab-content tab-content" data-tab-content="2">
                                <h3>Versand</h3>
                                <ul>
                                    <li>Kostenloser Versand ab {{ number_format((float) $settings->free_shipping_threshold, 0) }}&nbsp;{{ $settings->currency_symbol }} Bestellwert, außerhalb der Eurozone fallen {{ number_format((float) $settings->international_shipping_fee, 0) }}&nbsp;{{ $settings->currency_symbol }} zusätzliche Gebühren an.</li>
                                    <li>Versand innerhalb von 2 bis 5 Werktagen je nach Verfügbarkeit.</li>
                                </ul>
                                <h3>Rücksendungen</h3>
                                <ul>
                                    <li>14 Tage Widerrufsrecht gemäß unseren Rückgabebedingungen.</li>
                                    <li>Artikel in der Originalverpackung zurücksenden.</li>
                                </ul>
                            </div>

                            <div class="fh5co-tab-content tab-content" data-tab-content="3">
                                @if ($product->reviews->isEmpty())
                                    <p>Noch keine Bewertungen.</p>
                                @else
                                    <div class="product-reviews">
                                        @foreach ($product->reviews as $review)
                                            <div class="product-review">
                                                <span class="rate">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i class="icon-star2" style="{{ $i > $review->rating ? 'opacity:.25' : '' }}"></i>
                                                    @endfor
                                                </span>
                                                <p>{{ $review->comment }}</p>
                                                <cite>{{ $review->author_name }}</cite>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if ($related->isNotEmpty())
                <div class="row animate-box" style="margin-top:40px;">
                    <div class="col-md-8 col-md-offset-2 text-center fh5co-heading">
                        <span>Das könnte Ihnen auch gefallen</span>
                        <h2>Zugehörige Produkte</h2>
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
