@extends('layouts.shop')

@section('title', 'Livraison')
@section('meta_description', 'Délais et frais de livraison de ' . $settings->site_name . ', en zone euro et à l\'international.')

@section('content')
    <x-shop.page-hero title="Livraison" image="hero-objets.jpg" />

    <div id="fh5co-about">
        <div class="container">
            <div class="row animate-box">
                <div class="col-md-8 col-md-offset-2">
                    <div class="desc">
                        <h3>Zone euro</h3>
                        <p>Pour toute livraison dans un pays de la zone euro ({{ implode(', ', \App\Support\Countries::eurozoneLabels()) }}), les frais de livraison sont de {{ number_format(\App\Services\ShippingService::BASE_SHIPPING_FEE, 2) }}&nbsp;{{ $settings->currency_symbol }}, offerts dès {{ number_format((float) $settings->free_shipping_threshold, 0) }}&nbsp;{{ $settings->currency_symbol }} d'achat.</p>
                    </div>
                    <div class="desc">
                        <h3>Hors zone euro</h3>
                        <p>Pour les livraisons hors zone euro, des frais supplémentaires de {{ number_format((float) $settings->international_shipping_fee, 2) }}&nbsp;{{ $settings->currency_symbol }} s'ajoutent aux frais de livraison standards, pour couvrir les coûts de transport international.</p>
                    </div>
                    <div class="desc">
                        <h3>Délais</h3>
                        <p>Les commandes sont préparées sous 2 à 4 jours ouvrés après validation du paiement, puis expédiées. Le délai d'acheminement varie ensuite de 2 à 7 jours ouvrés selon la destination.</p>
                    </div>
                    <div class="desc">
                        <h3>Bois de chauffage et articles volumineux</h3>
                        <p>Le bois de chauffage (vendu au stère ou en filets, sur palette) ainsi que les machines lourdes — autoportées, broyeurs, motoculteurs et outils portés — sont acheminés par un transporteur spécialisé en raison de leur poids. La livraison se fait par camion à hayon, au pied de l'immeuble ou de la propriété et sur sol stabilisé, avec prise de rendez-vous préalable par téléphone ou e-mail. Prévoyez une aide à la manutention pour les colis de plus de 150 kg. Le délai d'acheminement pour ces produits peut être légèrement plus long, entre 5 et 10 jours ouvrés.</p>
                    </div>
                    <div class="desc">
                        <h3>Suivi</h3>
                        <p>Un e-mail d'expédition vous est envoyé dès que votre commande quitte notre entrepôt. Vous pouvez suivre son statut à tout moment sur notre page <a href="{{ route('tracking.index') }}">Suivi de commande</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
