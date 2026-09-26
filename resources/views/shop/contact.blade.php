@extends('layouts.shop')

@section('title', 'Kontakt')
@section('meta_description', 'Kontaktieren Sie ' . $settings->site_name . ': Telefon, E-Mail und Formular. Antwort innerhalb von 24 Werkstunden.')

@section('content')
    <x-shop.page-hero title="Kontakt" subtitle="Eine Frage? Schreiben Sie uns" image="hero-maison.jpg" />

    <div id="fh5co-contact">
        <div class="container">
            <div class="row contact-intro">
                <div class="col-md-8 col-md-offset-2 text-center fh5co-heading">
                    <span>Nachricht senden</span>
                    <h2>Eine Frage zu einem Teil, einer Bestellung oder einer Lieferung?</h2>
                    <p>
                        Wir sind ein kleines Team: Ihre Nachricht liest einer von uns, und wir antworten
                        innerhalb von 24&nbsp;Werkstunden. Bei einer Frage zu einer laufenden Bestellung
                        nennen Sie bitte deren Nummer — dann geht es schneller.
                    </p>
                </div>
            </div>

            {{-- The form comes first in the source so it is the first thing reached on a phone,
                 where the two columns stack. On desktop it keeps the wider left column. --}}
            <div class="row contact-row">
                <div class="col-md-7 contact-form-col">
                    <div class="contact-panel">
                        <h3>Schreiben Sie uns</h3>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul style="margin:0;">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('contact.store') }}">
                            @csrf

                            <div class="form-group">
                                <label for="contact-name">Ihr Name</label>
                                <input type="text" name="name" id="contact-name" value="{{ old('name') }}"
                                       class="form-control @error('name') is-invalid @enderror" required>
                                @error('name')<span class="field-error">{{ $message }}</span>@enderror
                            </div>

                            <div class="form-group">
                                <label for="contact-email">Ihre E-Mail-Adresse</label>
                                <input type="email" name="email" id="contact-email" value="{{ old('email') }}"
                                       class="form-control @error('email') is-invalid @enderror" required>
                                @error('email')<span class="field-error">{{ $message }}</span>@enderror
                                <small class="contact-hint">An diese Adresse senden wir unsere Antwort.</small>
                            </div>

                            <div class="form-group">
                                <label for="contact-subject">Betreff</label>
                                <input type="text" name="subject" id="contact-subject" value="{{ old('subject') }}"
                                       class="form-control @error('subject') is-invalid @enderror" required>
                                @error('subject')<span class="field-error">{{ $message }}</span>@enderror
                            </div>

                            <div class="form-group">
                                <label for="contact-message">Ihre Nachricht</label>
                                <textarea name="message" id="contact-message" rows="8"
                                          class="form-control @error('message') is-invalid @enderror" required>{{ old('message') }}</textarea>
                                @error('message')<span class="field-error">{{ $message }}</span>@enderror
                            </div>

                            <div class="contact-submit">
                                <button type="submit" class="btn btn-primary btn-lg">Nachricht senden</button>
                                <small>Ihre Kontaktdaten dienen ausschließlich unserer Antwort. Siehe unsere
                                    <a href="{{ route('pages.privacy') }}">Datenschutzerklärung</a>.</small>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-md-5 contact-aside-col">
                    <div class="contact-panel contact-panel-muted">
                        <h3>Direkt erreichen</h3>
                        <ul class="contact-details">
                            @if ($settings->contact_phone)
                                <li>
                                    <span class="contact-details-label">Telefon</span>
                                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $settings->contact_phone) }}">{{ $settings->contact_phone }}</a>
                                </li>
                            @endif
                            @if ($settings->contact_email)
                                <li>
                                    <span class="contact-details-label">E-Mail</span>
                                    <a href="mailto:{{ $settings->contact_email }}">{{ $settings->contact_email }}</a>
                                </li>
                            @endif
                            @if ($settings->whatsapp_number)
                                <li>
                                    <span class="contact-details-label">WhatsApp</span>
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings->whatsapp_number) }}"
                                       target="_blank" rel="noopener">{{ $settings->whatsapp_number }}</a>
                                </li>
                            @endif
                            @if ($settings->contact_address)
                                <li>
                                    <span class="contact-details-label">Adresse</span>
                                    <span>{{ $settings->contact_address }}</span>
                                </li>
                            @endif
                        </ul>
                    </div>

                    <div class="contact-panel contact-panel-muted">
                        <h3>Öffnungszeiten</h3>
                        <ul class="contact-hours">
                            <li><span>Montag – Freitag</span><strong>9h – 18h</strong></li>
                            <li><span>Samstag</span><strong>10h – 17h</strong></li>
                            <li><span>Sonntag</span><strong>Geschlossen</strong></li>
                        </ul>
                        <p class="contact-hours-note">
                            Nachrichten, die am Wochenende eingehen, werden am Montagmorgen bearbeitet.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Most contact-form messages are one of these three questions. Answering them here
                 saves the visitor a round trip and us a reply. --}}
            <div class="contact-shortcuts">
                <h3>Die Antwort finden Sie oft schon hier</h3>
                <div class="row">
                    <div class="col-sm-4">
                        <a class="contact-shortcut" href="{{ route('tracking.index') }}">
                            <strong>Wo ist meine Bestellung?</strong>
                            <span>Verfolgen Sie den Status mit Ihrer Bestellnummer.</span>
                            <em>Sendungsverfolgung</em>
                        </a>
                    </div>
                    <div class="col-sm-4">
                        <a class="contact-shortcut" href="{{ route('pages.shipping') }}">
                            <strong>Lieferzeiten und Versandkosten</strong>
                            <span>Liefergebiete, Spediteure und Lieferung sperriger Teile.</span>
                            <em>Versand</em>
                        </a>
                    </div>
                    <div class="col-sm-4">
                        <a class="contact-shortcut" href="{{ route('pages.returns') }}">
                            <strong>Einen Artikel zurücksenden</strong>
                            <span>14 Tage Widerrufsrecht gemäß unseren Rückgabebedingungen.</span>
                            <em>Rücksendungen</em>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
