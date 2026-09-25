@extends('layouts.shop')

@section('title', 'Über uns')
@section('meta_description', 'Wer wir sind: ' . $settings->site_name . ', Online-Shop für Motorgeräte, Traktoranbaugeräte, Brennholz und Ausstattung für den Außenbereich.')

@section('content')
    <x-shop.page-hero title="Über uns" :subtitle="$settings->site_name" image="hero-maison.jpg" />

    <div id="fh5co-about" class="about">
        <div class="container">
            <div class="row about-intro">
                <div class="col-md-8 col-md-offset-2 text-center">
                    <h2>Ein breites Sortiment, eine kurze Beratung.</h2>
                    <p class="about-lead">{{ $settings->tagline }}</p>
                    <p>
                        {{ $settings->site_name }} ist ein Online-Shop. Wir stellen nichts selbst her:
                        Wir verkaufen — von Herstellern, die ihre Ersatzteile vorhalten — die Geräte,
                        die wir auf dem eigenen Grundstück einsetzen würden. Maschinen, die sich
                        reparieren statt ersetzen lassen, etwas zum Heizen, wenn das Holz geschlagen ist,
                        und etwas, um das Grundstück den Rest des Jahres zu genießen.
                    </p>
                    <p>
                        Das Sortiment umfasst derzeit <strong>{{ number_format($productCount, 0, ',', ' ') }}&nbsp;{{ $productCount > 1 ? 'Artikel' : 'Artikel' }}</strong>.
                        Das ist viel, und niemand geht eine solche Liste durch: Grenzen Sie mit den
                        Sortimenten und Filtern ein und rufen Sie uns dann an. Das Aussortieren ist
                        unsere Aufgabe — nennen Sie uns Fläche, Hanglage und was Sie bereits haben, und
                        wir nennen Ihnen die zwei oder drei Maschinen, die dazu passen.
                    </p>
                </div>
            </div>

            {{-- Figures read off the catalogue and the shop settings rather than written into the
                 copy, so the page cannot end up claiming more than the shop actually carries. --}}
            <div class="row about-facts">
                <div class="col-sm-4">
                    <strong>{{ $productCount }}</strong>
                    <span>{{ $productCount > 1 ? 'Artikel verfügbar' : 'Artikel verfügbar' }} zur Bestellung</span>
                </div>
                <div class="col-sm-4">
                    <strong>{{ number_format((float) $settings->free_shipping_threshold, 0) }}&nbsp;{{ $settings->currency_symbol }}</strong>
                    <span>Mindestbestellwert für kostenlosen Versand in der Eurozone</span>
                </div>
                <div class="col-sm-4">
                    <strong>14 Tage</strong>
                    <span>Widerrufsrecht auf das gesamte Sortiment</span>
                </div>
            </div>

            @if ($stockedCategories->isNotEmpty())
                {{-- Each range is shown with a photo of one of its own products rather than a
                     decorative shot, so this section fills itself in as ranges get stocked — no
                     copy to update when Bois & Chauffage arrives. --}}
                <div class="about-ranges">
                    <h3>Was wir verkaufen</h3>
                    <div class="row">
                        @foreach ($stockedCategories as $category)
                            @php
                                // Prefer a product that actually has photography over the placeholder.
                                // The cover is resolved in the controller rather than by scanning
                                // $category->products, which would mean loading the whole catalogue.
                                // ->get(), not [] : a range whose products all lack photography has
                                // no entry here, and Collection's array access throws on a missing
                                // key rather than returning null.
                                $cover = $category->image_url ?? $covers->get($category->id)?->thumbnail_url;
                            @endphp
                            <div class="col-sm-6 col-md-3">
                                <a class="about-range" href="{{ route('catalog', ['category' => $category->slug]) }}">
                                    <span class="about-range-image" @if ($cover) style="background-image:url('{{ $cover }}');" @endif></span>
                                    <span class="about-range-body">
                                        <strong>{{ $category->name }}</strong>
                                        <span>{{ $category->products_count }} {{ $category->products_count > 1 ? 'Artikel' : 'Artikel' }}</span>
                                    </span>
                                </a>
                            </div>
                        @endforeach
                    </div>

                    @if ($emptyCategories->isNotEmpty())
                        {{-- Only while a range really is still empty; it disappears once stocked. --}}
                        <p class="about-note">
                            {{ $emptyCategories->pluck('name')->join(', ', ' und ') }}
                            {{ $emptyCategories->count() > 1 ? 'folgen' : 'folgt' }} in Kürze.
                        </p>
                    @endif
                </div>
            @endif

            <div class="row about-commitments">
                <div class="col-md-4">
                    <h3>Worauf wir achten</h3>
                    <p>
                        Verbreitete Motoren — Honda, Kawasaki, Briggs &amp; Stratton, Kohler, Loncin —
                        weil es dafür überall Teile gibt, und Getriebe, die für den angegebenen Einsatz
                        ausgelegt sind. Beim Brennholz derselbe Anspruch, anders angewandt: Hartholz,
                        kontrollierte Trocknung, geprüfte Restfeuchte. Und für alles, was draußen
                        überwintert — Gartenhäuser, Grills, Pools — Materialien, die eine Saison länger
                        halten als die Garantie.
                    </p>
                </div>
                <div class="col-md-4">
                    <h3>Wie wir versenden</h3>
                    <p>
                        Auf folierter Palette, mit Sendungsverfolgung in jedem Schritt. Versandkostenfrei ab
                        {{ number_format((float) $settings->free_shipping_threshold, 0) }}&nbsp;{{ $settings->currency_symbol }}
                        Bestellwert innerhalb der Eurozone; schwere Maschinen und Holz kommen per Lkw mit
                        Hebebühne, nach Terminvereinbarung, mit Absetzen an der Grundstücksgrenze auf
                        befestigtem Untergrund.
                    </p>
                </div>
                <div class="col-md-4">
                    <h3>Wie wir erreichbar sind</h3>
                    <p>
                        Ein kleines Team, direkt erreichbar.
                        @if ($settings->contact_phone)
                            Telefonisch unter <a href="tel:{{ $settings->contact_phone }}">{{ $settings->contact_phone }}</a>,
                        @endif
                        per E-Mail oder über das <a href="{{ route('contact.index') }}">Kontaktformular</a>.
                    </p>
                </div>
            </div>

            <div class="about-cta">
                <h3>Das Sortiment durchstöbern</h3>
                <p>Alle unsere Artikel, auf Lager und versandbereit.</p>
                <a href="{{ route('catalog') }}" class="btn btn-primary btn-lg">Shop entdecken</a>
            </div>
        </div>
    </div>
@endsection
