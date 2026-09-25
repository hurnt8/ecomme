@extends('layouts.shop')

@section('title', 'Cookies')
@section('meta_description', 'Utilisation des cookies sur le site ' . $settings->site_name . '.')

@section('content')
    <x-shop.page-hero title="Cookies" image="hero-objets.jpg" />

    <div id="fh5co-about">
        <div class="container">
            <div class="row animate-box">
                <div class="col-md-8 col-md-offset-2">
                    <div class="desc">
                        <h3>Was ist ein Cookie?</h3>
                        <p>Ein Cookie ist eine kleine Datei, die bei Ihrem Besuch in Ihrem Browser abgelegt wird. Sie hält bestimmte Informationen von Seite zu Seite oder von Besuch zu Besuch fest.</p>
                    </div>
                    <div class="desc">
                        <h3>Auf dieser Website verwendete Cookies</h3>
                        <p>Wir setzen ausschließlich Cookies ein, die für den Betrieb der Website unbedingt erforderlich sind. Diese Cookies bedürfen keiner vorherigen Einwilligung und werden niemals für Werbung oder Tracking verwendet:</p>
                        <table class="table table-bordered">
                            <thead>
                                <tr><th>Cookie</th><th>Finalité</th><th>Durée</th></tr>
                            </thead>
                            <tbody>
                                <tr><td>Session</td><td>Maintien de votre navigation (panier, page courante)</td><td>Session (fermeture du navigateur)</td></tr>
                                <tr><td>Panier</td><td>Conservation du contenu de votre panier entre deux visites</td><td>Jusqu'à 2 semaines</td></tr>
                                <tr><td>Connexion</td><td>Maintien de votre connexion à votre compte</td><td>Jusqu'à 30 jours (selon "Se souvenir de moi")</td></tr>
                                <tr><td>Jeton CSRF</td><td>Protection contre les attaques lors de l'envoi de formulaires</td><td>Session</td></tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="desc">
                        <h3>Cookies verwalten</h3>
                        <p>Sie können Ihren Browser jederzeit so einstellen, dass er Cookies ablehnt. Das Blockieren unbedingt erforderlicher Cookies verhindert allerdings das Funktionieren von Warenkorb und Anmeldung.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
