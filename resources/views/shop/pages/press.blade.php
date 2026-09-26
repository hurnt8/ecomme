@extends('layouts.shop')

@section('title', 'Presse')
@section('meta_description', 'Pressekontakt und Medienressourcen für ' . $settings->site_name . '.')

@section('content')
    <x-shop.page-hero title="Presse" subtitle="Medienbereich" image="hero-objets.jpg" />

    <div id="fh5co-about">
        <div class="container">
            <div class="row animate-box">
                <div class="col-md-8 col-md-offset-2">
                    <div class="desc">
                        <h3>Pressekontakt</h3>
                        <p>Journalistinnen, Journalisten und Content-Schaffende: für Interviewanfragen, hochauflösendes Bildmaterial oder Informationen über {{ $settings->site_name }}, wenden Sie sich direkt an uns.</p>
                        @if ($settings->contact_email)
                            <p><a href="mailto:{{ $settings->contact_email }}">{{ $settings->contact_email }}</a></p>
                        @endif
                    </div>
                    <div class="desc">
                        <h3>Über {{ $settings->site_name }}</h3>
                        <p>{{ $settings->description }}</p>
                    </div>
                    <div class="desc">
                        <h3>Unsere Ausrichtung</h3>
                        <p>{{ $settings->site_name }} deckt den Außenbereich das ganze Jahr über ab, aufgeteilt in zwölf Sortimente — Rasenmäher, Mähroboter, Aufsitzmäher &amp; Rasentraktoren, Kettensägen &amp; Baumpflege, Freischneider &amp; Motorhacken, Heckenscheren &amp; Laubbläser, Traktoranbaugeräte, Pumpen &amp; Sprühtechnik, Brennholz &amp; Heizen, Grills &amp; Gartenöfen, Pools &amp; Whirlpools sowie Garten &amp; Außenbereich. Die Klammer ist nicht die Produktfamilie, sondern die Jahreszeit: im Sommer wird gemäht und bewässert, im Herbst gemulcht und geschnitten, im Winter geheizt — und Pool und Grill füllen die Monate, in denen der Rasenmäher ruht.</p>
                    </div>
                    <div class="desc">
                        <h3>Pressemappe</h3>
                        <p>Logo, hochauflösende Produktbilder und Sprachbausteine erhalten Sie auf Anfrage über den oben genannten Pressekontakt.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
