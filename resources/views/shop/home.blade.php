@extends('layouts.shop')

@section('title', 'Motoculture & bois de chauffage')
@section('meta_description', $settings->description)

@section('content')
    {{-- The template put the hero copy in a translucent white panel (.desc) with a 24px black
         headline and no overlay, so the text sat on the photo with almost no contrast and the
         panel cut a hard rectangle across the image. Full-bleed gradient over the photo instead,
         with the copy sized to carry the page. .slider-text / .slider-text-inner are kept: the
         flexslider callbacks in site.js animate those classes. --}}
    <aside id="fh5co-hero" class="js-fullheight">
        <div class="flexslider js-fullheight">
            <ul class="slides">
                @forelse ($heroBanners as $banner)
                    <li style="background-image: url('{{ $banner->image_url }}');">
                        <div class="hero-overlay"></div>
                        <div class="container">
                            <div class="col-md-7 js-fullheight slider-text">
                                <div class="slider-text-inner">
                                    <div class="hero-content">
                                        <span class="hero-kicker">{{ $banner->subtitle ? $settings->site_name : 'Nouvelle saison' }}</span>
                                        <h2 class="hero-title">{{ $banner->title }}</h2>
                                        @if ($banner->subtitle)
                                            <p class="hero-lead">{{ $banner->subtitle }}</p>
                                        @endif
                                        <div class="hero-actions">
                                            <a href="{{ $banner->link_url ?: route('catalog') }}" class="btn btn-primary btn-lg">Découvrir le catalogue</a>
                                            <a href="{{ route('catalog', ['on_sale' => 1]) }}" class="hero-link">Voir les promotions</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                @empty
                    <li style="background-image: url('{{ asset('images/hero-maison.jpg') }}');">
                        <div class="hero-overlay"></div>
                        <div class="container">
                            <div class="col-md-7 js-fullheight slider-text">
                                <div class="slider-text-inner">
                                    <div class="hero-content">
                                        <span class="hero-kicker">{{ $settings->site_name }}</span>
                                        <h2 class="hero-title">{{ $settings->tagline }}</h2>
                                        <p class="hero-lead">{{ $settings->description }}</p>
                                        <div class="hero-actions">
                                            <a href="{{ route('catalog') }}" class="btn btn-primary btn-lg">Découvrir le catalogue</a>
                                            <a href="{{ route('catalog', ['on_sale' => 1]) }}" class="hero-link">Voir les promotions</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforelse
            </ul>
        </div>

        <a href="#fh5co-services" class="hero-scroll" aria-label="Faire défiler vers le contenu">
            <span>Découvrir</span>
            <i class="icon-arrow-down"></i>
        </a>
    </aside>

    <div id="fh5co-services" class="fh5co-bg-section">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-4 text-center">
                    <div class="feature-center animate-box" data-animate-effect="fadeIn">
                        <span class="icon"><i class="icon-credit-card"></i></span>
                        <h3>Paiement sécurisé</h3>
                        <p>Réglez votre commande par virement bancaire en toute confiance, avec confirmation immédiate par e-mail.</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 text-center">
                    <div class="feature-center animate-box" data-animate-effect="fadeIn">
                        <span class="icon"><i class="icon-wallet"></i></span>
                        <h3>Conseil avant achat</h3>
                        <p>Un doute sur la puissance, la largeur de coupe ou la compatibilité ? Appelez-nous avant de commander.</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 text-center">
                    <div class="feature-center animate-box" data-animate-effect="fadeIn">
                        <span class="icon"><i class="icon-paper-plane"></i></span>
                        <h3>Livraison sur palette</h3>
                        <p>Livraison sur rendez-vous et suivi à chaque étape, offerte dès {{ number_format((float) $settings->free_shipping_threshold, 0) }}&nbsp;{{ $settings->currency_symbol }} d'achat.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($secondaryBanners->isNotEmpty())
        <div class="container" style="margin-top:50px;">
            <div class="row animate-box">
                @foreach ($secondaryBanners as $banner)
                    <div class="col-md-{{ 12 / min($secondaryBanners->count(), 3) }}">
                        <x-shop.promo-banner :banner="$banner" />
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if ($bestsellerProducts->isNotEmpty())
        <div id="fh5co-bestsellers">
            <div class="container">
                <div class="row animate-box">
                    <div class="col-md-8 col-md-offset-2 text-center fh5co-heading">
                        <span>Coup de cœur clients</span>
                        <h2>Meilleures ventes.</h2>
                        <p>Les machines qui reviennent le plus souvent dans les commandes, saison après saison.</p>
                    </div>
                </div>
                @foreach ($bestsellerProducts->chunk(3) as $row)
                    <div class="row">
                        @foreach ($row as $product)
                            <x-shop.product-card :product="$product" />
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <div id="fh5co-product">
        <div class="container">
            <div class="row animate-box">
                <div class="col-md-8 col-md-offset-2 text-center fh5co-heading">
                    <span>Sélection</span>
                    <h2>Nos machines.</h2>
                    <p>Du matériel choisi pour être réparable, avec les pièces et le service qui vont avec.</p>
                </div>
            </div>
            @foreach ($products->chunk(3) as $row)
                <div class="row">
                    @foreach ($row as $product)
                        <x-shop.product-card :product="$product" />
                    @endforeach
                </div>
            @endforeach

            <div class="row">
                <div class="col-md-12 text-center" style="margin-top:20px;">
                    <a href="{{ route('catalog') }}" class="btn btn-primary btn-outline btn-lg">Voir toute la boutique</a>
                </div>
            </div>
        </div>
    </div>

    @if ($bestReviews->isNotEmpty())
        <div id="fh5co-testimonial" class="fh5co-bg-section">
            <div class="container">
                <div class="row animate-box">
                    <div class="col-md-8 col-md-offset-2 text-center fh5co-heading">
                        <span>Avis</span>
                        <h2>Ils nous font confiance</h2>
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
