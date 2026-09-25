@extends('layouts.shop')

@section('title', 'Motorgeräte, Garten & Holzheizung')
@section('meta_description', $settings->description)

@section('content')
    {{-- Laid out like guerrinibois.fr: the hero slider, then one carousel per row (categories,
         deals, best sellers, new arrivals, blog) with the two promo tiles between them. Each row
         is an Owl carousel sized by its data-items* attributes — see homeCarousels() in site.js.
         .slider-text / .slider-text-inner are kept on the hero: the flexslider callbacks in
         site.js animate those classes. --}}
    <aside id="fh5co-hero">
        <div class="flexslider">
            <ul class="slides">
                @forelse ($heroBanners as $banner)
                    <li style="background-image: url('{{ $banner->image_url }}');">
                        <div class="hero-overlay"></div>
                        <div class="container">
                            <div class="col-md-8 slider-text">
                                <div class="slider-text-inner">
                                    <div class="hero-content">
                                        <h2 class="hero-title">{{ $banner->title }}</h2>
                                        @if ($banner->subtitle)
                                            <p class="hero-tagline">{{ $banner->subtitle }}</p>
                                        @endif
                                        <a href="{{ $banner->link_url ?: route('catalog') }}" class="hero-btn">Jetzt kaufen</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                @empty
                    <li style="background-image: url('{{ asset('images/hero-maison.jpg') }}');">
                        <div class="hero-overlay"></div>
                        <div class="container">
                            <div class="col-md-8 slider-text">
                                <div class="slider-text-inner">
                                    <div class="hero-content">
                                        <h2 class="hero-title">{{ $settings->tagline }}</h2>
                                        <p class="hero-tagline">{{ $settings->site_name }}</p>
                                        <a href="{{ route('catalog') }}" class="hero-btn">Jetzt kaufen</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforelse
            </ul>
        </div>
    </aside>

    @if ($categories->isNotEmpty())
        <section class="home-section">
            <div class="container">
                <div class="home-heading">
                    <h2>Nach Kategorie einkaufen</h2>
                </div>
                <div class="owl-carousel home-carousel js-home-carousel" data-items="6" data-items-laptop="5" data-items-tablet="4" data-items-mobile="2">
                    @foreach ($categories as $category)
                        @php
                            $url = route('catalog', ['category' => $category->slug]);
                            $image = $category->image_url ?? $category->products->first()?->thumbnail_url;
                        @endphp
                        <div class="home-cat">
                            <a href="{{ $url }}" @class(['home-cat-image', 'is-product-photo' => ! $category->image_url])>
                                @if ($image)
                                    <img src="{{ $image }}" alt="{{ $category->name }}" loading="lazy">
                                @endif
                            </a>
                            <div class="home-cat-title"><a href="{{ $url }}">{{ $category->name }}</a></div>
                            <div class="home-cat-total">{{ $category->products_count }} {{ $category->products_count > 1 ? 'Produkte' : 'Produkt' }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Placed above the deals carousel for the cold season: heating is what the shop is named
         after and what customers come for from October. Drop this section back down, or remove
         it, when the mowing season starts again. --}}
    @if ($heatingProducts->isNotEmpty())
        <section id="fh5co-heating" class="home-section">
            <div class="container">
                <div class="home-heading">
                    <h2>Die Saison für Holzheizung</h2>
                    <p>Scheitholz, Pellets und Öfen — mit den Kettensägen für die Wintervorbereitung.</p>
                </div>
                <div class="owl-carousel home-carousel js-home-carousel" data-items="5" data-items-laptop="4" data-items-tablet="3" data-items-mobile="2">
                    @foreach ($heatingProducts as $product)
                        <x-shop.product-slide :product="$product" />
                    @endforeach
                </div>

                <div class="text-center home-more">
                    <a href="{{ route('catalog', ['category' => 'bois-chauffage']) }}" class="btn btn-primary btn-outline btn-lg">Brennholz &amp; Heizen ansehen</a>
                </div>
            </div>
        </section>
    @endif

    @if ($saleProducts->isNotEmpty())
        <section class="home-section">
            <div class="container">
                <div class="home-heading">
                    <h2>Unsere Angebote des Tages</h2>
                </div>
                <div class="owl-carousel home-carousel js-home-carousel" data-items="5" data-items-laptop="4" data-items-tablet="3" data-items-mobile="2">
                    @foreach ($saleProducts as $product)
                        <x-shop.product-slide :product="$product" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if ($secondaryBanners->isNotEmpty())
        <section class="home-section home-promos">
            <div class="container">
                <div class="row">
                    @foreach ($secondaryBanners as $banner)
                        {{-- The artwork is half photo, half solid panel, and the two tiles mirror
                             each other (panel on the right, then on the left): the copy goes on
                             the panel. --}}
                        <div class="col-sm-6">
                            <a href="{{ $banner->link_url ?: route('catalog') }}" class="home-promo {{ $loop->even ? 'is-text-left' : 'is-text-right' }}">
                                <img src="{{ $banner->image_url }}" alt="" loading="lazy">
                                <span class="home-promo-text">
                                    @if ($banner->subtitle)
                                        <span class="home-promo-kicker">{{ $banner->subtitle }}</span>
                                    @endif
                                    <span class="home-promo-title">{{ $banner->title }}</span>
                                    <span class="home-promo-btn">Jetzt kaufen</span>
                                </span>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if ($bestsellerProducts->isNotEmpty())
        <section id="fh5co-bestsellers" class="home-section">
            <div class="container">
                <div class="home-heading">
                    <h2>Bestseller</h2>
                </div>
                <div class="owl-carousel home-carousel js-home-carousel" data-items="5" data-items-laptop="4" data-items-tablet="3" data-items-mobile="2">
                    @foreach ($bestsellerProducts as $product)
                        <x-shop.product-slide :product="$product" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section id="fh5co-product" class="home-section">
        <div class="container">
            <div class="home-heading">
                <h2>Neue Produkte</h2>
            </div>
            <div class="owl-carousel home-carousel js-home-carousel" data-items="4" data-items-laptop="4" data-items-tablet="3" data-items-mobile="2">
                @foreach ($latestProducts as $product)
                    <x-shop.product-slide :product="$product" />
                @endforeach
            </div>

            <div class="text-center home-more">
                <a href="{{ route('catalog') }}" class="btn btn-primary btn-outline btn-lg">Gesamtes Sortiment ansehen</a>
            </div>
        </div>
    </section>

    <div id="fh5co-services" class="fh5co-bg-section home-services">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-4 text-center">
                    <div class="feature-center animate-box" data-animate-effect="fadeIn">
                        <span class="icon"><i class="icon-credit-card"></i></span>
                        <h3>Sichere Zahlung</h3>
                        <p>Bezahlen Sie Ihre Bestellung bequem per Banküberweisung, mit sofortiger Bestätigung per E-Mail.</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 text-center">
                    <div class="feature-center animate-box" data-animate-effect="fadeIn">
                        <span class="icon"><i class="icon-wallet"></i></span>
                        <h3>Beratung vor dem Kauf</h3>
                        <p>Unsicher bei Leistung, Schnittbreite oder Kompatibilität? Rufen Sie uns vor der Bestellung an.</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 text-center">
                    <div class="feature-center animate-box" data-animate-effect="fadeIn">
                        <span class="icon"><i class="icon-paper-plane"></i></span>
                        <h3>Palettenlieferung</h3>
                        <p>Lieferung nach Terminvereinbarung mit Sendungsverfolgung, kostenlos ab {{ number_format((float) $settings->free_shipping_threshold, 0) }}&nbsp;{{ $settings->currency_symbol }} Bestellwert.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($blogPosts->isNotEmpty())
        <section class="home-section home-blog">
            <div class="container">
                <div class="home-heading">
                    <h2>Aus dem Blog</h2>
                </div>
                <div class="owl-carousel home-carousel js-home-carousel" data-items="3" data-items-laptop="3" data-items-tablet="2" data-items-mobile="1" data-gap="30">
                    @foreach ($blogPosts as $post)
                        @php($url = route('blog.show', $post->slug))
                        <article class="home-post">
                            <a href="{{ $url }}" class="home-post-thumb">
                                @if ($post->cover_image_url)
                                    <img src="{{ $post->cover_image_url }}" alt="" loading="lazy">
                                @endif
                            </a>
                            <div class="home-post-meta">{{ $post->published_at->translatedFormat('j F Y') }}</div>
                            <h3 class="home-post-title"><a href="{{ $url }}">{{ $post->title }}</a></h3>
                            @if ($post->excerpt)
                                <p class="home-post-excerpt">{{ Str::limit($post->excerpt, 110) }}</p>
                            @endif
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if ($bestReviews->isNotEmpty())
        <div id="fh5co-testimonial" class="fh5co-bg-section">
            <div class="container">
                <div class="row animate-box">
                    <div class="col-md-8 col-md-offset-2 text-center fh5co-heading">
                        <span>Bewertungen</span>
                        <h2>Sie vertrauen uns</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="row animate-box">
                            <div class="owl-carousel owl-carousel-fullwidth">
                                @foreach ($bestReviews as $review)
                                    <div class="item">
                                        <div class="testimony-slide active text-center">
                                            <span>{{ $review->author_name }} — {{ $review->product->name }}</span>
                                            <blockquote>
                                                <p>&ldquo;{{ $review->comment }}&rdquo;</p>
                                            </blockquote>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
