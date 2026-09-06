@extends('layouts.shop')

@section('title', 'Mentions légales')
@section('meta_description', 'Mentions légales de ' . $settings->site_name . '.')

@section('content')
    <x-shop.page-hero title="Mentions légales" image="hero-objets.jpg" />

    <div id="fh5co-about">
        <div class="container">
            <div class="row animate-box">
                <div class="col-md-8 col-md-offset-2">
                    <div class="desc">
                        <h3>Éditeur du site</h3>
                        <p>
                            {{ $settings->site_name }}<br>
                            @if ($settings->contact_address){{ $settings->contact_address }}<br>@endif
                            @if ($settings->contact_email)E-mail : <a href="mailto:{{ $settings->contact_email }}">{{ $settings->contact_email }}</a><br>@endif
                            @if ($settings->contact_phone)Téléphone : {{ $settings->contact_phone }}@endif
                        </p>
                    </div>
                    <div class="desc">
                        <h3>Activité</h3>
                        <p>{{ $settings->site_name }} exerce une activité de vente en ligne de matériel de motoculture (tronçonneuses et élagueuses, tondeuses et robots de tonte, tracteurs tondeuses et autoportées, débroussailleuses, motobineuses et motoculteurs), d'outils portés pour tracteur et de bois de chauffage, à destination des particuliers et professionnels.</p>
                    </div>
                    <div class="desc">
                        <h3>Hébergement</h3>
                        <p>Coordonnées de l'hébergeur à compléter avant la mise en production du site.</p>
                    </div>
                    <div class="desc">
                        <h3>Propriété intellectuelle</h3>
                        <p>L'ensemble des contenus présents sur ce site (textes, visuels, logo) est la propriété de {{ $settings->site_name }} ou de ses partenaires, sauf mention contraire. Toute reproduction sans autorisation préalable est interdite.</p>
                    </div>
                    <div class="desc">
                        <h3>Médiation de la consommation</h3>
                        <p>Conformément à l'article L.616-1 du Code de la consommation, tout client peut recourir gratuitement à un médiateur de la consommation en cas de litige non résolu directement avec notre service client.</p>
                    </div>
                    <div class="desc">
                        <h3>Droit applicable</h3>
                        <p>Le présent site et les présentes mentions légales sont soumis au droit français. En cas de litige et à défaut de résolution amiable, les tribunaux français seront seuls compétents.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
