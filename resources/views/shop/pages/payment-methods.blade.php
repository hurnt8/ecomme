@extends('layouts.shop')

@section('title', 'Moyens de paiement')
@section('meta_description', 'Comment régler votre commande chez ' . $settings->site_name . '.')

@section('content')
    <x-shop.page-hero title="Moyens de paiement" />

    <div id="fh5co-about">
        <div class="container">
            <div class="row animate-box">
                <div class="col-md-8 col-md-offset-2">
                    <div class="desc">
                        <h3>Virement bancaire</h3>
                        <p>Le règlement de votre commande s'effectue exclusivement par virement bancaire. Une fois votre commande validée, nos coordonnées bancaires vous sont communiquées sur la page de confirmation ainsi que par e-mail avec votre facture.</p>
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
                        <h3>Préparation de la commande</h3>
                        <p>Votre commande est mise en préparation dès réception et validation de votre virement. Le délai de traitement bancaire d'un virement est généralement de 1 à 3 jours ouvrés.</p>
                    </div>
                    <div class="desc">
                        <h3>Sécurité</h3>
                        <p>Aucune donnée bancaire n'est collectée ni stockée sur ce site : le virement s'effectue directement depuis votre espace bancaire personnel.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
