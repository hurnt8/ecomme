@extends('layouts.shop')

@section('title', 'Accessibilité')
@section('meta_description', 'Engagement d\'accessibilité du site ' . $settings->site_name . '.')

@section('content')
    <x-shop.page-hero title="Accessibilité" image="img_bg_1.jpg" />

    <div id="fh5co-about">
        <div class="container">
            <div class="row animate-box">
                <div class="col-md-8 col-md-offset-2">
                    <div class="desc">
                        <h3>Notre engagement</h3>
                        <p>Nous nous efforçons de rendre ce site utilisable par le plus grand nombre : contrastes suffisants, navigation au clavier, textes alternatifs sur les images de produits, structure de titres cohérente.</p>
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
