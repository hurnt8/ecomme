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
                        <p>Nous sommes une petite équipe attachée au travail bien fait, de la sélection des machines jusqu'au service après-vente. Notre activité couvre à la fois la motoculture et les outils portés pour tracteur et un métier plus traditionnel, le bois de chauffage, ce qui nous donne des profils de postes assez variés.</p>
                        <p>Aucun poste n'est ouvert pour le moment, mais nous étudions volontiers les candidatures spontanées.</p>
                    </div>
                    <div class="desc">
                        <h3>Nos métiers</h3>
                        <p>Selon les besoins, nous recrutons sur des profils liés à la <strong>logistique</strong> (préparation de commandes, manutention de charges lourdes comme les palettes de granulés ou les broyeurs portés), à la <strong>mécanique</strong> (mise en route, entretien et SAV des machines thermiques), au <strong>service client</strong> (conseil avant achat, suivi de commande), à la <strong>gestion de catalogue</strong> (fiches produits, photographie) et, ponctuellement, à des <strong>partenaires bûcherons</strong> pour l'approvisionnement en bois.</p>
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
