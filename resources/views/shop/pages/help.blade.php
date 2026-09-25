@extends('layouts.shop')

@section('title', 'Aide / FAQ')
@section('meta_description', 'Questions fréquentes sur les commandes, la livraison, les retours et le paiement chez ' . $settings->site_name . '.')

@section('content')
    <x-shop.page-hero title="Hilfe" subtitle="Häufige Fragen" image="hero-maison.jpg" />

    <div id="fh5co-about">
        <div class="container">
            <div class="row animate-box">
                <div class="col-md-8 col-md-offset-2">
                    <div class="desc">
                        <h3>Wie gebe ich eine Bestellung auf?</h3>
                        <p>Legen Sie die gewünschten Artikel in den Warenkorb und folgen Sie dann dem Bestellvorgang: Kontaktdaten, Lieferanschrift, Auswahl des Landes und Bestätigung. Für eine Bestellung ist kein Konto erforderlich.</p>
                    </div>
                    <div class="desc">
                        <h3>Wie lange dauert der Versand und was kostet er?</h3>
                        <p>Der Versand ist kostenlos ab {{ number_format((float) $settings->free_shipping_threshold, 0) }}&nbsp;{{ $settings->currency_symbol }} Bestellwert innerhalb der Eurozone. Außerhalb der Eurozone fallen Zuschläge an. Einzelheiten auf unserer Seite <a href="{{ url('/livraison') }}">Versand</a>.</p>
                    </div>
                    <div class="desc">
                        <h3>Wie verfolge ich meine Bestellung?</h3>
                        <p>Besuchen Sie unsere Seite <a href="{{ route('tracking.index') }}">Sendungsverfolgung</a> avec votre numéro de commande et votre e-mail.</p>
                    </div>
                    <div class="desc">
                        <h3>Wie bezahle ich meine Bestellung?</h3>
                        <p>Die Zahlung erfolgt per Banküberweisung. Die Bankverbindung erhalten Sie auf der Bestätigungsseite und per E-Mail. Einzelheiten auf unserer Seite <a href="{{ url('/moyens-paiement') }}">Moyens de paiement</a>.</p>
                    </div>
                    <div class="desc">
                        <h3>Kann ich einen Artikel zurücksenden?</h3>
                        <p>Ja, unter den Bedingungen, die auf unserer Seite <a href="{{ url('/retours') }}">Rücksendungen</a> beschrieben sind. Le bois de chauffage entamé ou livré en vrac ne peut toutefois pas être repris, pour des raisons pratiques et d'hygiène.</p>
                    </div>
                    <div class="desc">
                        <h3>Wie wird Brennholz geliefert?</h3>
                        <p>Brennholz wird als Raummeter oder im Netz auf Palette verkauft. Wegen Gewicht und Volumen kann für diese Produkte eine Terminvereinbarung nötig sein; geliefert wird bis an den Bordstein oder die Grundstücksgrenze (die Spedition trägt nicht in die Etagen). Siehe unsere Seite <a href="{{ url('/livraison') }}">Versand</a> für Einzelheiten.</p>
                    </div>
                    <div class="desc">
                        <h3>Woran erkenne ich, ob ein Anbaugerät zu meinem Traktor passt?</h3>
                        <p>Bei jedem Mulcher, jeder Kippmulde und jeder Gabel nennt das Datenblatt die empfohlene Traktorleistung, das Gewicht und die Anbauart. Bleiben Sie im angegebenen Bereich: darunter quält sich die Zapfwelle und der Rotor kommt nicht auf Drehzahl, darüber leidet das Getriebe des Geräts. Im Zweifel nennen Sie uns vor der Bestellung Ihr Traktormodell.</p>
                    </div>
                    <div class="desc">
                        <h3>Bieten Sie Angebote für Gewerbe oder große Mengen an?</h3>
                        <p>Ja, insbesondere für Brennholzbestellungen in größeren Mengen oder die Ausstattung eines Betriebs. Kontaktieren Sie uns über das <a href="{{ route('contact.index') }}">Kontaktformular</a> en précisant votre besoin.</p>
                    </div>
                    <div class="desc">
                        <h3>Noch eine Frage?</h3>
                        <p>Unser Team antwortet Ihnen über das <a href="{{ route('contact.index') }}">Kontaktformular</a>
                            @if ($settings->whatsapp_number)
                                ou par WhatsApp.
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
