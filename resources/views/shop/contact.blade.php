@extends('layouts.shop')

@section('title', 'Contact')
@section('meta_description', 'Contactez ' . $settings->site_name . ' : téléphone, e-mail et formulaire. Réponse sous 24 heures ouvrées.')

@section('content')
    <x-shop.page-hero title="Contact" subtitle="Une question ? Écrivez-nous" image="hero-maison.jpg" />

    <div id="fh5co-contact">
        <div class="container">
            <div class="row contact-intro">
                <div class="col-md-8 col-md-offset-2 text-center fh5co-heading">
                    <span>Nous écrire</span>
                    <h2>Une question sur une pièce, une commande ou une livraison ?</h2>
                    <p>
                        Nous sommes une équipe réduite : c'est l'un de nous qui lira votre message,
                        et nous répondons sous 24&nbsp;heures ouvrées. Pour une question sur une
                        commande en cours, indiquez son numéro — la réponse ira plus vite.
                    </p>
                </div>
            </div>

            {{-- The form comes first in the source so it is the first thing reached on a phone,
                 where the two columns stack. On desktop it keeps the wider left column. --}}
            <div class="row contact-row">
                <div class="col-md-7 contact-form-col">
                    <div class="contact-panel">
                        <h3>Envoyez-nous un message</h3>

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
                                <label for="contact-name">Votre nom</label>
                                <input type="text" name="name" id="contact-name" value="{{ old('name') }}"
                                       class="form-control @error('name') is-invalid @enderror" required>
                                @error('name')<span class="field-error">{{ $message }}</span>@enderror
                            </div>

                            <div class="form-group">
                                <label for="contact-email">Votre adresse e-mail</label>
                                <input type="email" name="email" id="contact-email" value="{{ old('email') }}"
                                       class="form-control @error('email') is-invalid @enderror" required>
                                @error('email')<span class="field-error">{{ $message }}</span>@enderror
                                <small class="contact-hint">C'est à cette adresse que nous vous répondrons.</small>
                            </div>

                            <div class="form-group">
                                <label for="contact-subject">Sujet</label>
                                <input type="text" name="subject" id="contact-subject" value="{{ old('subject') }}"
                                       class="form-control @error('subject') is-invalid @enderror" required>
                                @error('subject')<span class="field-error">{{ $message }}</span>@enderror
                            </div>

                            <div class="form-group">
                                <label for="contact-message">Votre message</label>
                                <textarea name="message" id="contact-message" rows="8"
                                          class="form-control @error('message') is-invalid @enderror" required>{{ old('message') }}</textarea>
                                @error('message')<span class="field-error">{{ $message }}</span>@enderror
                            </div>

                            <div class="contact-submit">
                                <button type="submit" class="btn btn-primary btn-lg">Envoyer le message</button>
                                <small>Vos coordonnées servent uniquement à vous répondre. Voir notre
                                    <a href="{{ route('pages.privacy') }}">politique de confidentialité</a>.</small>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-md-5 contact-aside-col">
                    <div class="contact-panel contact-panel-muted">
                        <h3>Nous joindre directement</h3>
                        <ul class="contact-details">
                            @if ($settings->contact_phone)
                                <li>
                                    <span class="contact-details-label">Téléphone</span>
                                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $settings->contact_phone) }}">{{ $settings->contact_phone }}</a>
                                </li>
                            @endif
                            @if ($settings->contact_email)
                                <li>
                                    <span class="contact-details-label">E-mail</span>
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
                        <h3>Horaires</h3>
                        <ul class="contact-hours">
                            <li><span>Lundi – vendredi</span><strong>9h – 18h</strong></li>
                            <li><span>Samedi</span><strong>10h – 17h</strong></li>
                            <li><span>Dimanche</span><strong>Fermé</strong></li>
                        </ul>
                        <p class="contact-hours-note">
                            Les messages reçus le week-end sont traités le lundi matin.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Most contact-form messages are one of these three questions. Answering them here
                 saves the visitor a round trip and us a reply. --}}
            <div class="contact-shortcuts">
                <h3>Souvent, la réponse est déjà là</h3>
                <div class="row">
                    <div class="col-sm-4">
                        <a class="contact-shortcut" href="{{ route('tracking.index') }}">
                            <strong>Où en est ma commande ?</strong>
                            <span>Suivez son avancement avec votre numéro de commande.</span>
                            <em>Suivi de commande</em>
                        </a>
                    </div>
                    <div class="col-sm-4">
                        <a class="contact-shortcut" href="{{ route('pages.shipping') }}">
                            <strong>Délais et frais de livraison</strong>
                            <span>Zones desservies, transporteurs et livraison des pièces volumineuses.</span>
                            <em>Livraison</em>
                        </a>
                    </div>
                    <div class="col-sm-4">
                        <a class="contact-shortcut" href="{{ route('pages.returns') }}">
                            <strong>Retourner un article</strong>
                            <span>14 jours pour changer d'avis, selon les conditions de retour.</span>
                            <em>Retours</em>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
