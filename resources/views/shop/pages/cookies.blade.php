@extends('layouts.shop')

@section('title', 'Cookies')
@section('meta_description', 'Verwendung von Cookies auf der Website ' . $settings->site_name . '.')

@section('content')
    <x-shop.page-hero title="Cookies" image="hero-objets.jpg" />

    <div id="fh5co-about">
        <div class="container">
            <div class="row animate-box">
                <div class="col-md-8 col-md-offset-2">
                    <div class="desc">
                        <h3>Was ist ein Cookie?</h3>
                        <p>Ein Cookie ist eine kleine Datei, die bei Ihrem Besuch in Ihrem Browser abgelegt wird. Sie hält bestimmte Informationen von Seite zu Seite oder von Besuch zu Besuch fest.</p>
                    </div>
                    <div class="desc">
                        <h3>Auf dieser Website verwendete Cookies</h3>
                        <p>Wir setzen ausschließlich Cookies ein, die für den Betrieb der Website unbedingt erforderlich sind. Diese Cookies bedürfen keiner vorherigen Einwilligung und werden niemals für Werbung oder Tracking verwendet:</p>
                        <table class="table table-bordered">
                            <thead>
                                <tr><th>Cookie</th><th>Zweck</th><th>Dauer</th></tr>
                            </thead>
                            <tbody>
                                <tr><td>Sitzung</td><td>Aufrechterhaltung Ihrer Navigation (Warenkorb, aktuelle Seite)</td><td>Sitzung (bis Browser geschlossen wird)</td></tr>
                                <tr><td>Warenkorb</td><td>Speicherung des Warenkorbinhalts zwischen zwei Besuchen</td><td>Bis zu 2 Wochen</td></tr>
                                <tr><td>Anmeldung</td><td>Aufrechterhaltung Ihrer Kontoanmeldung</td><td>Bis zu 30 Tage (je nach "Angemeldet bleiben")</td></tr>
                                <tr><td>CSRF-Token</td><td>Schutz vor Angriffen beim Absenden von Formularen</td><td>Sitzung</td></tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="desc">
                        <h3>Cookies verwalten</h3>
                        <p>Sie können Ihren Browser jederzeit so einstellen, dass er Cookies ablehnt. Das Blockieren unbedingt erforderlicher Cookies verhindert allerdings das Funktionieren von Warenkorb und Anmeldung.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
