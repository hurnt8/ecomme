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
                            {{ $settings->site_name }}@if ($settings->legal_name && $settings->legal_name !== $settings->site_name) — {{ $settings->legal_name }}@endif<br>
                            @if ($settings->legal_form){{ $settings->legal_form }}<br>@endif
                            @if ($settings->registered_address ?: $settings->contact_address){{ $settings->registered_address ?: $settings->contact_address }}<br>@endif
                            @if ($settings->contact_email)E-mail : <a href="mailto:{{ $settings->contact_email }}">{{ $settings->contact_email }}</a><br>@endif
                            @if ($settings->contact_phone)Téléphone : {{ $settings->contact_phone }}<br>@endif
                            @if ($settings->publication_director)Directeur de la publication : {{ $settings->publication_director }}@endif
                        </p>
                    </div>
                    @if ($settings->siren || $settings->siret || $settings->vat_number || $settings->naf_code)
                        <div class="desc">
                            <h3>Immatriculation</h3>
                            <p>
                                @if ($settings->siren)SIREN : {{ $settings->siren }}<br>@endif
                                @if ($settings->siret)SIRET du siège social : {{ $settings->siret }}<br>@endif
                                @if ($settings->naf_code)Code NAF/APE : {{ $settings->naf_code }}@if ($settings->naf_label) — {{ $settings->naf_label }}@endif<br>@endif
                                {{-- Printed only when a number exists. The wording for a business without
                                     one depends on which regime applies (franchise en base, exonération,
                                     autoliquidation), and asserting the wrong article on a public legal
                                     page is a liability — so nothing is claimed here by default. --}}
                                @if ($settings->vat_number)N° TVA intracommunautaire : {{ $settings->vat_number }}@endif
                            </p>
                        </div>
                    @endif
                    <div class="desc">
                        <h3>Activité</h3>
                        <p>{{ $settings->site_name }} exerce une activité de vente en ligne de matériel de motoculture (tronçonneuses et élagueuses, tondeuses et robots de tonte, tracteurs tondeuses et autoportées, débroussailleuses, motobineuses et motoculteurs, taille-haies et souffleurs), d'outils portés pour tracteur, de pompes et de matériel de pulvérisation, de bois de chauffage et d'appareils de chauffage au bois, ainsi que d'équipement d'extérieur (barbecues, fours d'extérieur, piscines et abris de jardin), à destination des particuliers et professionnels.</p>
                    </div>
                    <div class="desc">
                        <h3>Hébergement</h3>
                        <p>{{ $settings->host_details ?: "Coordonnées de l'hébergeur à compléter avant la mise en production du site." }}</p>
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
