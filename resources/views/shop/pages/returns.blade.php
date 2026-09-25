@extends('layouts.shop')

@section('title', 'Rücksendungen')
@section('meta_description', 'Conditions de retour et de remboursement chez ' . $settings->site_name . '.')

@section('content')
    <x-shop.page-hero title="Rücksendungen" image="hero-maison.jpg" />

    <div id="fh5co-about">
        <div class="container">
            <div class="row animate-box">
                <div class="col-md-8 col-md-offset-2">
                    <div class="desc">
                        <h3>Widerrufsrecht</h3>
                        <p>Nach geltendem Recht haben Sie ab Erhalt Ihrer Bestellung 14 Tage Zeit, Ihr Widerrufsrecht auszuüben, ohne Angabe von Gründen.</p>
                    </div>
                    <div class="desc">
                        <h3>Bedingungen</h3>
                        <p>Der Artikel muss im Originalzustand, unbenutzt und nach Möglichkeit in der Originalverpackung zurückgesandt werden. Die Rücksendekosten trägt die Kundin oder der Kunde, außer bei mangelhafter oder nicht vertragsgemäßer Ware.</p>
                    </div>
                    <div class="desc">
                        <h3>Ausnahmen</h3>
                        <p>Gemäß § 312g Abs. 2 BGB besteht kein Widerrufsrecht bei versiegelten Waren, die aus Gründen des Gesundheitsschutzes oder der Hygiene nach der Entsiegelung nicht zur Rückgabe geeignet sind, sowie bei Waren, die nach Kundenspezifikation angefertigt wurden. <strong>Brennholz</strong> livré en vrac ou en filets ouverts ne peut donc pas être retourné une fois la livraison réceptionnée ; nous vous invitons à vérifier votre commande dès sa réception.</p>
                    </div>
                    <div class="desc">
                        <h3>Wie sende ich einen Artikel zurück?</h3>
                        <p>Kontaktieren Sie uns über unser <a href="{{ route('contact.index') }}">Kontaktformular</a> und nennen Sie Ihre Bestellnummer. Wir teilen Ihnen das weitere Vorgehen mit.</p>
                    </div>
                    <div class="desc">
                        <h3>Erstattung</h3>
                        <p>Die Erstattung erfolgt per Banküberweisung innerhalb von 14 Tagen nach Eingang der Rücksendung, über dasselbe Zahlungsmittel wie bei der ursprünglichen Zahlung.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
