@extends('layouts.shop')

@section('title', 'Accessibilité')
@section('meta_description', 'Engagement d\'accessibilité du site ' . $settings->site_name . '.')

@section('content')
    <x-shop.page-hero title="Accessibilité" image="hero-maison.jpg" />

    <div id="fh5co-about">
        <div class="container">
            <div class="row animate-box">
                <div class="col-md-8 col-md-offset-2">
                    <div class="desc">
                        <h3>Notre engagement</h3>
                        <p>Nous nous efforçons de rendre ce site utilisable par le plus grand nombre : contrastes suffisants, navigation au clavier, textes alternatifs sur les images de produits, structure de titres cohérente.</p>
                    </div>
                    <div class="desc">
                        <h3>Mesures mises en œuvre</h3>
                        <ul>
                            <li>Navigation et validation des formulaires possibles au clavier, sans souris</li>
                            <li>Zoom du texte jusqu'à 200 % sans perte de contenu ni de fonctionnalité</li>
                            <li>Structure de titres hiérarchique (h1, h2, h3) pour faciliter la navigation avec un lecteur d'écran</li>
                            <li>Libellés explicites sur les champs de formulaire (compte, commande, contact)</li>
                        </ul>
                    </div>
                    <div class="desc">
                        <h3>Niveau de conformité</h3>
                        <p>Le site vise un niveau de conformité proche du RGAA (Référentiel Général d'Amélioration de l'Accessibilité) sans certification formelle à ce jour. Un audit et une déclaration d'accessibilité complète sont prévus à mesure que le site évolue.</p>
                    </div>
                    <div class="desc">
                        <h3>Une difficulté ?</h3>
                        <p>Si une partie du site vous semble difficile d'accès, faites-le-nous savoir via notre <a href="{{ route('contact.index') }}">formulaire de contact</a> : nous en tiendrons compte dans nos prochaines mises à jour.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
