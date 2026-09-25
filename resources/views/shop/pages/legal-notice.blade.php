@extends('layouts.shop')

@section('title', 'Impressum')
@section('meta_description', 'Impressum von ' . $settings->site_name . '.')

@section('content')
    <x-shop.page-hero title="Impressum" image="hero-objets.jpg" />

    <div id="fh5co-about">
        <div class="container">
            <div class="row animate-box">
                <div class="col-md-8 col-md-offset-2">
                    <div class="desc">
                        <h3>Anbieter</h3>
                        <p>
                            {{ $settings->site_name }}@if ($settings->legal_name && $settings->legal_name !== $settings->site_name) — {{ $settings->legal_name }}@endif<br>
                            @if ($settings->legal_form){{ $settings->legal_form }}<br>@endif
                            @if ($settings->registered_address ?: $settings->contact_address){{ $settings->registered_address ?: $settings->contact_address }}<br>@endif
                            @if ($settings->contact_email)E-Mail: <a href="mailto:{{ $settings->contact_email }}">{{ $settings->contact_email }}</a><br>@endif
                            @if ($settings->contact_phone)Telefon: {{ $settings->contact_phone }}<br>@endif
                            @if ($settings->publication_director)Verantwortlich für den Inhalt: {{ $settings->publication_director }}@endif
                        </p>
                    </div>
                    @if ($settings->siren || $settings->siret || $settings->vat_number || $settings->naf_code)
                        <div class="desc">
                            <h3>Registrierung</h3>
                            <p>
                                @if ($settings->siren)SIREN: {{ $settings->siren }}<br>@endif
                                @if ($settings->siret)SIRET (Hauptniederlassung): {{ $settings->siret }}<br>@endif
                                @if ($settings->naf_code)NAF/APE-Code: {{ $settings->naf_code }}@if ($settings->naf_label) — {{ $settings->naf_label }}@endif<br>@endif
                                {{-- Printed only when a number exists. The wording for a business without
                                     one depends on which regime applies (franchise en base, exonération,
                                     autoliquidation), and asserting the wrong article on a public legal
                                     page is a liability — so nothing is claimed here by default. --}}
                                @if ($settings->vat_number)USt-IdNr.: {{ $settings->vat_number }}@endif
                            </p>
                        </div>
                    @endif
                    <div class="desc">
                        <h3>Tätigkeit</h3>
                        <p>{{ $settings->site_name }} betreibt den Online-Handel mit Motorgeräten (Kettensägen und Hochentaster, Rasenmäher und Mähroboter, Rasentraktoren und Aufsitzmäher, Freischneider, Motorhacken und Bodenfräsen, Heckenscheren und Laubbläser), Traktoranbaugeräten, Pumpen und Sprühtechnik, Brennholz und Holzheizgeräten sowie Ausstattung für den Außenbereich (Grills, Gartenöfen, Pools und Gartenhäuser) für Privat- und Gewerbekunden.</p>
                    </div>
                    <div class="desc">
                        <h3>Hosting</h3>
                        <p>{{ $settings->host_details ?: "Angaben zum Hoster sind vor dem Livegang der Website zu ergänzen." }}</p>
                    </div>
                    <div class="desc">
                        <h3>Urheberrecht</h3>
                        <p>Sämtliche Inhalte dieser Website (Texte, Bilder, Logo) sind Eigentum von {{ $settings->site_name }} oder seiner Partner, sofern nicht anders angegeben. Jede Vervielfältigung ohne vorherige Zustimmung ist untersagt.</p>
                    </div>
                    <div class="desc">
                        <h3>Verbraucherschlichtung</h3>
                        <p>Nach dem Verbraucherstreitbeilegungsgesetz (VSBG) können Kundinnen und Kunden bei einem Streit, der sich mit unserem Kundenservice nicht unmittelbar klären lässt, kostenfrei eine Verbraucherschlichtungsstelle anrufen.</p>
                    </div>
                    <div class="desc">
                        <h3>Anwendbares Recht</h3>
                        <p>Diese Website und dieses Impressum unterliegen französischem Recht, da der Anbieter seinen Sitz in Frankreich hat. Im Streitfall und mangels gütlicher Einigung sind ausschließlich die französischen Gerichte zuständig.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
