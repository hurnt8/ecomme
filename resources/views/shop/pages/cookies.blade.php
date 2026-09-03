@extends('layouts.shop')

@section('title', 'Cookies')
@section('meta_description', 'Utilisation des cookies sur le site ' . $settings->site_name . '.')

@section('content')
    <x-shop.page-hero title="Cookies" image="img_bg_5.jpg" />

    <div id="fh5co-about">
        <div class="container">
            <div class="row animate-box">
                <div class="col-md-8 col-md-offset-2">
                    <div class="desc">
                        <h3>Qu'est-ce qu'un cookie ?</h3>
                        <p>Un cookie est un petit fichier déposé sur votre navigateur lors de votre visite. Il permet de conserver certaines informations d'une page à l'autre ou d'une visite à l'autre.</p>
                    </div>
                    <div class="desc">
                        <h3>Cookies utilisés sur ce site</h3>
                        <p>Nous utilisons uniquement des cookies strictement nécessaires au fonctionnement du site : maintien de votre session, de votre panier et de votre connexion si vous possédez un compte. Ces cookies ne nécessitent pas de consentement préalable et ne sont pas utilisés à des fins publicitaires.</p>
                    </div>
                    <div class="desc">
                        <h3>Gestion des cookies</h3>
                        <p>Vous pouvez à tout moment configurer votre navigateur pour refuser les cookies. Le blocage des cookies strictement nécessaires empêchera toutefois le bon fonctionnement du panier et de la connexion.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
