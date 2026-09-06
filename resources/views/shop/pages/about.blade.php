@extends('layouts.shop')

@section('title', 'À propos')
@section('meta_description', 'Qui nous sommes : ' . $settings->site_name . ', boutique en ligne de matériel de motoculture, outils portés pour tracteur et bois de chauffage.')

@section('content')
    <x-shop.page-hero title="À propos" :subtitle="$settings->site_name" image="hero-maison.jpg" />

    <div id="fh5co-about" class="about">
        <div class="container">
            <div class="row about-intro">
                <div class="col-md-8 col-md-offset-2 text-center">
                    <h2>Une sélection courte, choisie machine par machine.</h2>
                    <p class="about-lead">{{ $settings->tagline }}</p>
                    <p>
                        {{ $settings->site_name }} est une boutique en ligne. Nous ne fabriquons pas :
                        nous choisissons, chez des constructeurs qui tiennent leurs pièces détachées,
                        le matériel que nous utiliserions sur notre propre terrain — des machines qui
                        se réparent plutôt qu'elles ne se remplacent, et de quoi se chauffer une fois
                        le bois coupé.
                    </p>
                    <p>
                        Le catalogue compte aujourd'hui <strong>{{ $productCount }}&nbsp;{{ $productCount > 1 ? 'références' : 'référence' }}</strong>.
                        Chacune est retenue pour sa mécanique autant que pour son prix : nous
                        préférons une sélection que nous connaissons vraiment, et sur laquelle nous
                        savons répondre au téléphone, à un catalogue que personne ne peut parcourir.
                    </p>
                </div>
            </div>

            {{-- Figures read off the catalogue and the shop settings rather than written into the
                 copy, so the page cannot end up claiming more than the shop actually carries. --}}
            <div class="row about-facts">
                <div class="col-sm-4">
                    <strong>{{ $productCount }}</strong>
                    <span>{{ $productCount > 1 ? 'références disponibles' : 'référence disponible' }} à la commande</span>
                </div>
                <div class="col-sm-4">
                    <strong>{{ number_format((float) $settings->free_shipping_threshold, 0) }}&nbsp;{{ $settings->currency_symbol }}</strong>
                    <span>le seuil de livraison offerte en zone euro</span>
                </div>
                <div class="col-sm-4">
                    <strong>14 jours</strong>
                    <span>de rétractation sur tout le catalogue</span>
                </div>
            </div>

            @if ($stockedCategories->isNotEmpty())
                {{-- Each range is shown with a photo of one of its own products rather than a
                     decorative shot, so this section fills itself in as ranges get stocked — no
                     copy to update when Bois & Chauffage arrives. --}}
                <div class="about-ranges">
                    <h3>Ce que nous vendons</h3>
                    <div class="row">
                        @foreach ($stockedCategories as $category)
                            @php
                                // Prefer a product that actually has photography over the placeholder.
                                $cover = $category->image_url
                                    ?? $category->products->firstWhere(fn ($p) => $p->hasPhoto())?->thumbnail_url;
                            @endphp
                            <div class="col-sm-6 col-md-3">
                                <a class="about-range" href="{{ route('catalog', ['category' => $category->slug]) }}">
                                    <span class="about-range-image" @if ($cover) style="background-image:url('{{ $cover }}');" @endif></span>
                                    <span class="about-range-body">
                                        <strong>{{ $category->name }}</strong>
                                        <span>{{ $category->products_count }} {{ $category->products_count > 1 ? 'références' : 'référence' }}</span>
                                    </span>
                                </a>
                            </div>
                        @endforeach
                    </div>

                    @if ($emptyCategories->isNotEmpty())
                        {{-- Only while a range really is still empty; it disappears once stocked. --}}
                        <p class="about-note">
                            {{ $emptyCategories->pluck('name')->join(', ', ' et ') }}
                            {{ $emptyCategories->count() > 1 ? 'arrivent' : 'arrive' }} prochainement.
                        </p>
                    @endif
                </div>
            @endif

            <div class="row about-commitments">
                <div class="col-md-4">
                    <h3>Ce que nous regardons</h3>
                    <p>
                        Des moteurs répandus — Honda, Kawasaki, Briggs &amp; Stratton, Kohler, Loncin —
                        parce qu'on en trouve les pièces partout, et des transmissions dimensionnées
                        pour l'usage annoncé. Pour le bois de chauffage, la même exigence appliquée
                        autrement : essences dures, séchage maîtrisé, taux d'humidité contrôlé.
                    </p>
                </div>
                <div class="col-md-4">
                    <h3>Comment nous expédions</h3>
                    <p>
                        Sur palette filmée, avec suivi à chaque étape. Livraison offerte dès
                        {{ number_format((float) $settings->free_shipping_threshold, 0) }}&nbsp;{{ $settings->currency_symbol }}
                        d'achat en zone euro ; les machines lourdes et le bois passent par un camion à
                        hayon, sur rendez-vous, avec dépose au pied de la propriété sur sol stabilisé.
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
                <p>Toutes nos références, en stock et prêtes à partir.</p>
                <a href="{{ route('catalog') }}" class="btn btn-primary btn-lg">Découvrir la boutique</a>
            </div>
        </div>
    </div>
@endsection
