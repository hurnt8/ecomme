@extends('layouts.shop')

@section('title', 'Karriere')
@section('meta_description', 'Werden Sie Teil des Teams von ' . $settings->site_name . '.')

@section('content')
    <x-shop.page-hero title="Karriere" subtitle="Teil des Teams werden" image="hero-maison.jpg" />

    <div id="fh5co-about">
        <div class="container">
            <div class="row animate-box">
                <div class="col-md-8 col-md-offset-2">
                    <div class="desc">
                        <h3>Arbeiten bei {{ $settings->site_name }}</h3>
                        <p>Wir sind ein kleines Team, dem gute Arbeit am Herzen liegt — von der Auswahl der Maschinen bis zum Kundendienst. Unser Geschäft umfasst Motorgeräte und Traktoranbaugeräte ebenso wie ein traditionelleres Handwerk, das Brennholz, woraus sich recht unterschiedliche Stellenprofile ergeben.</p>
                        <p>Derzeit ist keine Stelle ausgeschrieben, Initiativbewerbungen sehen wir uns jedoch gerne an.</p>
                    </div>
                    <div class="desc">
                        <h3>Unsere Tätigkeitsfelder</h3>
                        <p>Je nach Bedarf suchen wir Profile aus den Bereichen <strong>Logistik</strong> (Auftragsvorbereitung, Handling schwerer Lasten wie Pelletpaletten oder Anbaugeräte), <strong>Mechanik</strong> (Inbetriebnahme, Wartung und Kundendienst für Motorgeräte), <strong>Kundenservice</strong> (Beratung vor dem Kauf, Bestellverfolgung), <strong>Katalogpflege</strong> (Produktdatenblätter, Fotografie) und gelegentlich <strong>Holzfäller-Partnerbetrieben</strong> für die Holzbeschaffung.</p>
                    </div>
                    <div class="desc">
                        <h3>Initiativbewerbung</h3>
                        <p>Senden Sie uns Ihren Lebenslauf und ein paar Zeilen zu Ihrer Person über unser <a href="{{ route('contact.index') }}">Kontaktformular</a>{{ $settings->contact_email ? ' oder per E-Mail an ' : '' }}
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
