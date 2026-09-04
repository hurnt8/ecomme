@extends('layouts.shop')

@section('title', 'Presse')
@section('meta_description', 'Contact presse et ressources média pour ' . $settings->site_name . '.')

@section('content')
    <x-shop.page-hero title="Presse" subtitle="Espace média" image="hero-objets.jpg" />

    <div id="fh5co-about">
        <div class="container">
            <div class="row animate-box">
                <div class="col-md-8 col-md-offset-2">
                    <div class="desc">
                        <h3>Contact presse</h3>
                        <p>Journalistes et créateurs de contenu, pour toute demande d'interview, de visuels haute définition ou d'informations sur {{ $settings->site_name }}, contactez-nous directement.</p>
                        @if ($settings->contact_email)
                            <p><a href="mailto:{{ $settings->contact_email }}">{{ $settings->contact_email }}</a></p>
                        @endif
                    </div>
                    <div class="desc">
                        <h3>À propos de {{ $settings->site_name }}</h3>
                        <p>{{ $settings->description }}</p>
                    </div>
                    <div class="desc">
                        <h3>Notre positionnement</h3>
                        <p>{{ $settings->site_name }} se distingue par un catalogue resserré organisé autour de cinq univers — Mobilier, Jardin &amp; Extérieur, Décoration, Équipement Maison et Bois &amp; Chauffage — plutôt qu'une offre généraliste démesurée. Cette double identité, entre mobilier design et bois de chauffage, en fait un cas atypique dans le paysage du e-commerce maison en France.</p>
                    </div>
                    <div class="desc">
                        <h3>Kit presse</h3>
                        <p>Logo, visuels produits en haute définition et éléments de langage sont disponibles sur simple demande auprès de notre contact presse ci-dessus.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
