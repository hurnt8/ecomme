@extends('layouts.shop')

@section('title', 'Mobilier & décoration')
@section('meta_description', $settings->description)

@section('content')
    <aside id="fh5co-hero" class="js-fullheight">
        <div class="flexslider js-fullheight">
            <ul class="slides">
                @forelse ($heroBanners as $banner)
                    <li style="background-image: url('{{ $banner->image_url }}');">
                        <div class="overlay-gradient"></div>
                        <div class="container">
                            <div class="col-md-6 col-md-offset-3 col-md-pull-3 js-fullheight slider-text">
                                <div class="slider-text-inner">
                                    <div class="desc">
                                        <h2>{{ $banner->title }}</h2>
                                        <p>{{ $banner->subtitle }}</p>
                                        @if ($banner->link_url)
                                            <p><a href="{{ $banner->link_url }}" class="btn btn-primary btn-outline btn-lg">Découvrir</a></p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                @empty
                    <li style="background-image: url('{{ asset('template/images/img_bg_1.jpg') }}');">
                        <div class="overlay-gradient"></div>
                        <div class="container">
                            <div class="col-md-6 col-md-offset-3 col-md-pull-3 js-fullheight slider-text">
                                <div class="slider-text-inner">
                                    <div class="desc">
                                        <h2>{{ $settings->site_name }}</h2>
                                        <p>{{ $settings->tagline }}</p>
                                        <p><a href="{{ route('catalog') }}" class="btn btn-primary btn-outline btn-lg">Découvrir</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforelse
            </ul>
        </div>
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
                        <h3>Retours gratuits</h3>
                        <p>30 jours pour changer d'avis : retournez votre article sans frais s'il ne vous convient pas.</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 text-center">
                    <div class="feature-center animate-box" data-animate-effect="fadeIn">
                        <span class="icon"><i class="icon-paper-plane"></i></span>
                        <h3>Livraison soignée</h3>
                        <p>Emballage renforcé et suivi à chaque étape, offerte dès {{ number_format((float) $settings->free_shipping_threshold, 0) }}&nbsp;{{ $settings->currency }} d'achat.</p>
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

    <div id="fh5co-product">
        <div class="container">
            <div class="row animate-box">
                <div class="col-md-8 col-md-offset-2 text-center fh5co-heading">
                    <span>Sélection</span>
                    <h2>Nos pièces.</h2>
                    <p>Meubles et objets choisis pour leur fabrication soignée et leur design intemporel.</p>
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
