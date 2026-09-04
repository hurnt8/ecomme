@extends('layouts.shop')

@section('title', 'Carrières')
@section('meta_description', 'Rejoindre l\'équipe de ' . $settings->site_name . '.')

@section('content')
    <x-shop.page-hero title="Carrières" subtitle="Rejoindre l'équipe" image="hero-maison.jpg" />

    <div id="fh5co-about">
        <div class="container">
            <div class="row animate-box">
                <div class="col-md-8 col-md-offset-2">
                    <div class="desc">
                        <h3>Travailler chez {{ $settings->site_name }}</h3>
                        <p>Nous sommes une petite équipe attachée au travail bien fait, de la sélection des matières jusqu'au service après-vente. Notre activité couvre à la fois le mobilier et la décoration et un métier plus traditionnel, le bois de chauffage, ce qui nous donne des profils de postes assez variés.</p>
                        <p>Aucun poste n'est ouvert pour le moment, mais nous étudions volontiers les candidatures spontanées.</p>
                    </div>
                    <div class="desc">
                        <h3>Nos métiers</h3>
                        <p>Selon les besoins, nous recrutons sur des profils liés à la <strong>logistique</strong> (préparation de commandes, manutention de charges lourdes comme le bois de chauffage ou le mobilier de jardin), au <strong>service client</strong> (suivi de commande, SAV), à la <strong>gestion de catalogue</strong> (fiches produits, photographie) et, ponctuellement, à des <strong>partenaires bûcherons</strong> pour l'approvisionnement en bois.</p>
                    </div>
                    <div class="desc">
                        <h3>Candidature spontanée</h3>
                        <p>Envoyez-nous votre CV et quelques lignes de présentation via notre <a href="{{ route('contact.index') }}">formulaire de contact</a>{{ $settings->contact_email ? ' ou par e-mail à ' : '' }}
                            @if ($settings->contact_email)
                                <a href="mailto:{{ $settings->contact_email }}">{{ $settings->contact_email }}</a>.
                            @else
                                .
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
