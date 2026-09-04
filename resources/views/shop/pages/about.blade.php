@extends('layouts.shop')

@section('title', 'À propos')
@section('meta_description', 'Qui nous sommes : ' . $settings->site_name . ', boutique en ligne de mobilier, décoration et équipement pour la maison.')

@section('content')
    <x-shop.page-hero title="À propos" :subtitle="$settings->site_name" image="img_bg_1.jpg" />

    <div id="fh5co-about" class="about">
        <div class="container">
            <div class="row about-intro">
                <div class="col-md-6">
                    <h2>Une sélection courte, choisie pièce par pièce.</h2>
                    <p class="about-lead">{{ $settings->tagline }}</p>
                    <p>
                        {{ $settings->site_name }} est une boutique en ligne. Nous ne fabriquons pas :
                        nous choisissons, auprès d'éditeurs et d'ateliers, des pièces en matières
                        massives — bois, béton, marbre, céramique — qui vieillissent bien et se
                        réparent plutôt que de se remplacer.
                    </p>
                    <p>
                        Notre catalogue compte aujourd'hui <strong>{{ $productCount }} pièces</strong>. C'est
                        volontairement peu : chaque référence est retenue pour sa fabrication autant que
                        pour son dessin, et nous préférons une sélection courte que nous connaissons
                        vraiment à un catalogue que personne ne peut parcourir.
                    </p>
                </div>
                <div class="col-md-6">
                    <img class="img-responsive about-image" src="{{ asset('template/images/img_bg_1.jpg') }}" alt="Une pièce de la sélection {{ $settings->site_name }}">
                </div>
            </div>

            {{-- Figures read off the catalogue and the shop settings rather than written into the
                 copy, so the page cannot end up claiming more than the shop actually carries. --}}
            <div class="row about-facts">
                <div class="col-sm-4">
                    <strong>{{ $productCount }}</strong>
                    <span>pièces au catalogue, toutes disponibles à la commande</span>
                </div>
                <div class="col-sm-4">
                    <strong>{{ number_format((float) $settings->free_shipping_threshold, 0) }}&nbsp;{{ $settings->currency_symbol }}</strong>
                    <span>le seuil de livraison offerte en zone euro</span>
                </div>
                <div class="col-sm-4">
                    <strong>30 jours</strong>
                    <span>pour changer d'avis, retour gratuit</span>
                </div>
            </div>

            @if ($categories->isNotEmpty())
                <div class="row about-ranges">
                    <div class="col-md-12">
                        <h3>Ce que nous vendons</h3>
                        <ul>
                            @foreach ($categories as $category)
                                <li>
                                    <a href="{{ route('catalog', ['category' => $category->slug]) }}">
                                        <strong>{{ $category->name }}</strong>
                                        <span>{{ $category->products_count }} {{ $category->products_count > 1 ? 'pièces' : 'pièce' }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <p class="about-note">
                            D'autres univers ouvriront au fur et à mesure que la sélection s'étoffe.
                        </p>
                    </div>
                </div>
            @endif

            <div class="row about-commitments">
                <div class="col-md-4">
                    <h3>Ce que nous regardons</h3>
                    <p>
                        Des matières massives et des finitions naturelles — huile, cire, émail — plutôt
                        que des placages et des vernis synthétiques. Une pièce qui se ponce, se rehuile
                        et se transmet.
                    </p>
                </div>
                <div class="col-md-4">
                    <h3>Comment nous expédions</h3>
                    <p>
                        Emballage renforcé et suivi à chaque étape. Livraison offerte dès
                        {{ number_format((float) $settings->free_shipping_threshold, 0) }}&nbsp;{{ $settings->currency_symbol }}
                        d'achat en zone euro ; les pièces volumineuses passent par un transporteur dédié.
                    </p>
                </div>
                <div class="col-md-4">
                    <h3>Comment nous répondons</h3>
                    <p>
                        Une équipe réduite, joignable directement.
                        @if ($settings->contact_phone)
                            Par téléphone au <a href="tel:{{ $settings->contact_phone }}">{{ $settings->contact_phone }}</a>,
                        @endif
                        par e-mail ou via le <a href="{{ route('contact.index') }}">formulaire de contact</a>.
                    </p>
                </div>
            </div>

            <div class="about-cta">
                <h3>Parcourir la sélection</h3>
                <p>{{ $productCount }} pièces, cinq minutes suffisent pour en faire le tour.</p>
                <a href="{{ route('catalog') }}" class="btn btn-primary btn-lg">Découvrir la boutique</a>
            </div>
        </div>
    </div>
@endsection
