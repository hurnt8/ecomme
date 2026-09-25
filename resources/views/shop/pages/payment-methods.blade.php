@extends('layouts.shop')

@section('title', 'Zahlungsarten')
@section('meta_description', 'Comment régler votre commande chez ' . $settings->site_name . '.')

@section('content')
    <x-shop.page-hero title="Zahlungsarten" image="hero-objets.jpg" />

    <div id="fh5co-about">
        <div class="container">
            <div class="row animate-box">
                <div class="col-md-8 col-md-offset-2">
                    <div class="desc">
                        <h3>Banküberweisung</h3>
                        <p>Die Bezahlung Ihrer Bestellung erfolgt ausschließlich per Banküberweisung. Nach Abschluss der Bestellung erhalten Sie unsere Bankverbindung auf der Bestätigungsseite sowie per E-Mail zusammen mit Ihrer Rechnung.</p>
                        @if ($settings->bank_iban)
                            <p>
                                @if ($settings->bank_account_holder)
                                    Titulaire : {{ $settings->bank_account_holder }}<br>
                                @endif
                                @if ($settings->bank_name)
                                    Banque : {{ $settings->bank_name }}<br>
                                @endif
                                IBAN : <strong>{{ $settings->bank_iban }}</strong>
                                @if ($settings->bank_bic)
                                    <br>BIC : {{ $settings->bank_bic }}
                                @endif
                            </p>
                        @endif
                    </div>
                    <div class="desc">
                        <h3>Bearbeitung der Bestellung</h3>
                        <p>Ihre Bestellung wird bearbeitet, sobald Ihre Überweisung eingegangen und bestätigt ist. Die Bearbeitung einer Überweisung durch die Bank dauert in der Regel 1 bis 3 Werktage.</p>
                    </div>
                    <div class="desc">
                        <h3>Sicherheit</h3>
                        <p>Auf dieser Website werden keine Bankdaten erhoben oder gespeichert: Die Überweisung führen Sie direkt in Ihrem eigenen Online-Banking aus.</p>
                    </div>
                    <div class="desc">
                        <h3>Gewerbliche Bestellungen und große Mengen</h3>
                        <p>Für Brennholzbestellungen in größeren Mengen oder die Ausstattung eines Betriebs erstellen wir auf Anfrage ein Angebot mit passenden Zahlungsmodalitäten (Anzahlung, Zahlung bei Lieferung) über unser <a href="{{ route('contact.index') }}">Kontaktformular</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
