@extends('layouts.shop')

@section('title', 'Barrierefreiheit')
@section('meta_description', 'Engagement d\'accessibilité du site ' . $settings->site_name . '.')

@section('content')
    <x-shop.page-hero title="Barrierefreiheit" image="hero-maison.jpg" />

    <div id="fh5co-about">
        <div class="container">
            <div class="row animate-box">
                <div class="col-md-8 col-md-offset-2">
                    <div class="desc">
                        <h3>Unser Anspruch</h3>
                        <p>Wir bemühen uns, diese Website für möglichst viele Menschen nutzbar zu machen: ausreichende Kontraste, Tastaturbedienung, Alternativtexte für Produktbilder, eine schlüssige Überschriftenstruktur.</p>
                    </div>
                    <div class="desc">
                        <h3>Umgesetzte Maßnahmen</h3>
                        <ul>
                            <li>Navigation und Absenden von Formularen vollständig per Tastatur, ohne Maus</li>
                            <li>Textzoom bis 200 % ohne Verlust von Inhalten oder Funktionen</li>
                            <li>Hierarchische Überschriftenstruktur (h1, h2, h3) für die Navigation mit einem Screenreader</li>
                            <li>Eindeutige Beschriftungen der Formularfelder (Konto, Bestellung, Kontakt)</li>
                        </ul>
                    </div>
                    <div class="desc">
                        <h3>Grad der Konformität</h3>
                        <p>Die Website orientiert sich an den Anforderungen der BITV 2.0 und der WCAG 2.1, bislang ohne förmliche Zertifizierung. Ein Audit und eine vollständige Erklärung zur Barrierefreiheit sind im Zuge der Weiterentwicklung vorgesehen.</p>
                    </div>
                    <div class="desc">
                        <h3>Auf eine Hürde gestoßen?</h3>
                        <p>Wenn Ihnen ein Teil der Website schwer zugänglich erscheint, teilen Sie es uns über unser <a href="{{ route('contact.index') }}">Kontaktformular</a> : nous en tiendrons compte dans nos prochaines mises à jour.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
