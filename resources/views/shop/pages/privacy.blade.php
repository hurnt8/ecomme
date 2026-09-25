@extends('layouts.shop')

@section('title', 'Politique de confidentialité')
@section('meta_description', 'Comment ' . $settings->site_name . ' collecte et utilise vos données personnelles.')

@section('content')
    <x-shop.page-hero title="Datenschutz" subtitle="Schutz personenbezogener Daten" image="hero-maison.jpg" />

    <div id="fh5co-about">
        <div class="container">
            <div class="row animate-box">
                <div class="col-md-8 col-md-offset-2">
                    <div class="desc">
                        <h3>Erhobene Daten</h3>
                        <p>Bei einer Bestellung erheben wir Ihren Namen, Ihre E-Mail-Adresse und Ihre Lieferanschrift. Wenn Sie ein Konto anlegen, speichern wir zusätzlich Ihre Anmeldedaten (das Passwort wird verschlüsselt abgelegt).</p>
                    </div>
                    <div class="desc">
                        <h3>Verwendung der Daten</h3>
                        <p>Diese Daten dienen ausschließlich der Abwicklung Ihrer Bestellungen, der damit verbundenen Kommunikation (Bestätigung, Sendungsverfolgung, Rechnung) und, sofern Sie einwilligen, unserem Newsletter.</p>
                    </div>
                    <div class="desc">
                        <h3>Speicherdauer</h3>
                        <p>Bestelldaten werden so lange aufbewahrt, wie es unsere gesetzlichen und handelsrechtlichen Aufbewahrungspflichten erfordern. Die Daten eines Kundenkontos bleiben gespeichert, solange das Konto aktiv ist.</p>
                    </div>
                    <div class="desc">
                        <h3>Empfänger der Daten</h3>
                        <p>Ihre Daten werden niemals an Dritte verkauft. Sie können an Dienstleister weitergegeben werden, die für die Abwicklung der Bestellung unbedingt erforderlich sind (Spedition für die Lieferung, E-Mail-Dienst für Bestätigung und Sendungsverfolgung), und zwar nur im dafür notwendigen Umfang.</p>
                    </div>
                    <div class="desc">
                        <h3>Sicherheit</h3>
                        <p>Der Zugang zu Ihrem Konto ist durch ein verschlüsseltes Passwort geschützt. Die Verbindung zur Website ist gesichert (HTTPS). Bankdaten werden von uns weder erhoben noch gespeichert, da die Zahlung per direkter Banküberweisung erfolgt.</p>
                    </div>
                    <div class="desc">
                        <h3>Cookies</h3>
                        <p>Die Website verwendet technisch notwendige Cookies für ihren Betrieb (Warenkorb, Sitzung, Anmeldung). Einzelheiten finden Sie auf unserer Seite <a href="{{ url('/cookies') }}">Cookies</a>.</p>
                    </div>
                    <div class="desc">
                        <h3>Ihre Rechte</h3>
                        <p>Nach der Datenschutz-Grundverordnung (DSGVO) haben Sie das Recht auf Auskunft, Berichtigung, Löschung und Datenübertragbarkeit sowie das Recht, der Verarbeitung zu Werbezwecken zu widersprechen. Zur Ausübung wenden Sie sich an uns
                            @if ($settings->contact_email)
                                à <a href="mailto:{{ $settings->contact_email }}">{{ $settings->contact_email }}</a>.
                            @else
                                via notre <a href="{{ route('contact.index') }}">Kontaktformular</a>.
                            @endif
                            Sie haben zudem das Recht, sich bei einer Datenschutz-Aufsichtsbehörde zu beschweren.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
