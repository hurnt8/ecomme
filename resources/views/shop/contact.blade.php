@extends('layouts.shop')

@section('title', 'Contact')
@section('meta_description', 'Contactez ' . $settings->site_name . ' pour toute question sur nos produits ou votre commande.')

@section('content')
    <x-shop.page-hero title="Contact" subtitle="Une question ? Écrivez-nous" image="img_bg_4.jpg" />

    <div id="fh5co-contact">
        <div class="container">
            <div class="row">
                <div class="col-md-5 col-md-push-1 animate-box">
                    <div class="fh5co-contact-info">
                        <h3>Nos coordonnées</h3>
                        <ul>
                            @if ($settings->contact_address)
                                <li class="address">{{ $settings->contact_address }}</li>
                            @endif
                            @if ($settings->contact_phone)
                                <li class="phone"><a href="tel:{{ $settings->contact_phone }}">{{ $settings->contact_phone }}</a></li>
                            @endif
                            @if ($settings->contact_email)
                                <li class="email"><a href="mailto:{{ $settings->contact_email }}">{{ $settings->contact_email }}</a></li>
                            @endif
                            @if ($settings->whatsapp_number)
                                <li class="url"><a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings->whatsapp_number) }}" target="_blank" rel="noopener">WhatsApp</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 animate-box">
                    <h3>Envoyez-nous un message</h3>
                    <form method="POST" action="{{ route('contact.store') }}">
                        @csrf
                        <div class="row form-group">
                            <div class="col-md-12">
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Votre nom">
                                @error('name')<span style="color:#c0392b;font-size:12px;">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-12">
                                <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Votre adresse e-mail">
                                @error('email')<span style="color:#c0392b;font-size:12px;">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-12">
                                <input type="text" name="subject" value="{{ old('subject') }}" class="form-control" placeholder="Sujet de votre message">
                                @error('subject')<span style="color:#c0392b;font-size:12px;">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-12">
                                <textarea name="message" cols="30" rows="10" class="form-control" placeholder="Votre message">{{ old('message') }}</textarea>
                                @error('message')<span style="color:#c0392b;font-size:12px;">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Envoyer le message" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
