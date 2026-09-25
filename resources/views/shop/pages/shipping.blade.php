@extends('layouts.shop')

@section('title', 'Versand')
@section('meta_description', 'Délais et frais de livraison de ' . $settings->site_name . ', en zone euro et à l\'international.')

@section('content')
    <x-shop.page-hero title="Versand" image="hero-objets.jpg" />

    <div id="fh5co-about">
        <div class="container">
            <div class="row animate-box">
                <div class="col-md-8 col-md-offset-2">
                    <div class="desc">
                        <h3>Eurozone</h3>
                        <p>Für Lieferungen in ein Land der Eurozone ({{ implode(', ', \App\Support\Countries::eurozoneLabels()) }}) betragen die Versandkosten {{ number_format(\App\Services\ShippingService::BASE_SHIPPING_FEE, 2) }}&nbsp;{{ $settings->currency_symbol }}, kostenlos ab {{ number_format((float) $settings->free_shipping_threshold, 0) }}&nbsp;{{ $settings->currency_symbol }} Bestellwert.</p>
                    </div>
                    <div class="desc">
                        <h3>Außerhalb der Eurozone</h3>
                        <p>Für Lieferungen außerhalb der Eurozone fällt ein Zuschlag von {{ number_format((float) $settings->international_shipping_fee, 2) }}&nbsp;{{ $settings->currency_symbol }} zusätzlich zu den Standardversandkosten an, um die internationalen Transportkosten zu decken.</p>
                    </div>
                    <div class="desc">
                        <h3>Lieferzeiten</h3>
                        <p>Bestellungen werden innerhalb von 2 bis 4 Werktagen nach Zahlungseingang kommissioniert und anschließend versandt. Die Transportzeit beträgt danach je nach Ziel 2 bis 7 Werktage.</p>
                    </div>
                    <div class="desc">
                        <h3>Brennholz und sperrige Artikel</h3>
                        <p>Brennholz (als Raummeter oder im Netz, auf Palette) sowie schwere Maschinen — Aufsitzmäher, Mulcher, Motorhacken und Anbaugeräte — werden ihres Gewichts wegen von einer Spedition befördert. Die Zustellung erfolgt per Lkw mit Hebebühne bis an den Bordstein oder die Grundstücksgrenze auf befestigtem Untergrund, nach vorheriger Terminvereinbarung per Telefon oder E-Mail. Sorgen Sie bei Sendungen über 150 kg für eine Hilfe beim Abladen. Die Transportzeit kann bei diesen Produkten mit 5 bis 10 Werktagen etwas länger ausfallen.</p>
                    </div>
                    <div class="desc">
                        <h3>Sendungsverfolgung</h3>
                        <p>Sobald Ihre Bestellung unser Lager verlässt, erhalten Sie eine Versandbestätigung per E-Mail. Den Status können Sie jederzeit auf unserer Seite <a href="{{ route('tracking.index') }}">Sendungsverfolgung</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
