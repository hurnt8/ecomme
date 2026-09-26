@extends('layouts.shop')

@section('title', 'Allgemeine Geschäftsbedingungen')
@section('meta_description', 'Allgemeine Geschäftsbedingungen von ' . $settings->site_name . '.')

@section('content')
    <x-shop.page-hero title="AGB" subtitle="Allgemeine Geschäftsbedingungen" image="hero-maison.jpg" />

    <div id="fh5co-about">
        <div class="container">
            <div class="row animate-box">
                <div class="col-md-8 col-md-offset-2">
                    <div class="desc">
                        <h3>1. Gegenstand</h3>
                        <p>Diese Allgemeinen Geschäftsbedingungen gelten für alle Verkäufe über die Website {{ $settings->site_name }} zwischen {{ $settings->site_name }} und allen Kundinnen und Kunden, die einen Kauf tätigen.</p>
                    </div>
                    <div class="desc">
                        <h3>2. Produkte</h3>
                        <p>Unser Sortiment gliedert sich in zwölf Bereiche: Rasenmäher, Mähroboter, Aufsitzmäher &amp; Rasentraktoren, Kettensägen &amp; Baumpflege, Freischneider &amp; Motorhacken, Heckenscheren &amp; Laubbläser, Traktoranbaugeräte, Pumpen &amp; Sprühtechnik, Brennholz &amp; Heizen, Grills &amp; Gartenöfen, Pools &amp; Whirlpools sowie Garten &amp; Außenbereich. Die Produkte werden nur solange der Vorrat reicht angeboten; ist ein Artikel nach der Bestellung nicht verfügbar, wird die Kundin oder der Kunde informiert und gegebenenfalls erstattet. Benzinbetriebene Maschinen werden ohne Kraftstoff geliefert und, sofern im Datenblatt nicht anders angegeben, mit aufgefülltem Öl. Brennholz, verkauft als Raummeter oder im Netz, kann aufgrund seiner Natürlichkeit leicht in Holzart, Feuchte und Farbe schwanken.</p>
                    </div>
                    <div class="desc">
                        <h3>3. Preise</h3>
                        <p>Die Preise sind angegeben in {{ $settings->currency }}, inklusive aller Steuern. {{ $settings->site_name }} behält sich vor, die Preise jederzeit zu ändern; berechnet werden die zum Zeitpunkt der Bestellbestätigung gültigen Preise.</p>
                    </div>
                    <div class="desc">
                        <h3>4. Bestellung</h3>
                        <p>Mit jeder Bestellung werden diese Allgemeinen Geschäftsbedingungen vollständig anerkannt. Die Bestellung wird erst mit der Bestätigung per E-Mail und dem Zahlungseingang verbindlich.</p>
                    </div>
                    <div class="desc">
                        <h3>5. Zahlung</h3>
                        <p>Die Zahlung erfolgt per Banküberweisung nach den Bedingungen auf unserer Seite <a href="{{ url('/moyens-paiement') }}">Zahlungsarten</a>.</p>
                    </div>
                    <div class="desc">
                        <h3>6. Lieferung</h3>
                        <p>Lieferbedingungen und Lieferzeiten sind auf unserer Seite <a href="{{ url('/livraison') }}">Versand</a> aufgeführt. Für Brennholz und sperrige Artikel gelten besondere Lieferbedingungen (eigene Spedition, vorherige Terminvereinbarung).</p>
                    </div>
                    <div class="desc">
                        <h3>7. Widerrufsrecht</h3>
                        <p>Nach geltendem Recht haben Sie 14 Tage Zeit, Ihr Widerrufsrecht auszuüben. Einzelheiten und Ausnahmen (insbesondere für bereits angebrochenes Brennholz) finden Sie auf unserer Seite <a href="{{ url('/retours') }}">Rücksendungen</a> beschrieben.</p>
                    </div>
                    <div class="desc">
                        <h3>8. Gewährleistung</h3>
                        <p>Für alle unsere Artikel gilt die gesetzliche Gewährleistung für Sachmängel nach den Bestimmungen des Bürgerlichen Gesetzbuchs (BGB).</p>
                    </div>
                    <div class="desc">
                        <h3>9. Haftung</h3>
                        <p>{{ $settings->site_name }} haftet nicht für Schäden, die auf unsachgemäßen Gebrauch des gekauften Produkts (insbesondere eines Heiz- oder Feuerungsgeräts) oder auf höhere Gewalt zurückgehen.</p>
                    </div>
                    <div class="desc">
                        <h3>10. Anwendbares Recht</h3>
                        <p>Diese Allgemeinen Geschäftsbedingungen unterliegen französischem Recht, da der Verkäufer seinen Sitz in Frankreich hat. Im Streitfall wird vor einem gerichtlichen Vorgehen eine gütliche Einigung angestrebt.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
