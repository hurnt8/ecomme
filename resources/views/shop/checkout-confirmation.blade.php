@extends('layouts.shop')

@section('title', 'Commande confirmée')

@section('content')
    {{-- Short, fixed hero title: the previous one interpolated the customer's name and the order
         number into the cover headings, which overflowed the banner on a phone as soon as either
         ran long. The personal thank-you moved into the page body, where it can wrap freely. --}}
    <header id="fh5co-header" class="fh5co-cover fh5co-cover-sm fh5co-cover-compact" role="banner" style="background-image:url('{{ asset('template/images/img_bg_5.jpg') }}');">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 text-center">
                    <div class="display-t">
                        <div class="display-tc animate-box" data-animate-effect="fadeIn">
                            <h1>Commande confirmée</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div id="fh5co-product" class="confirmation">
        <div class="container">
            <ol class="checkout-steps">
                <li class="is-done"><span>1</span> Panier</li>
                <li class="is-done"><span>2</span> Livraison &amp; paiement</li>
                <li class="is-current"><span>3</span> Confirmation</li>
            </ol>

            <div class="confirmation-hero">
                <i class="icon-check confirmation-check" aria-hidden="true"></i>
                <h2>Merci {{ $order->customer_name }}, votre commande est enregistrée.</h2>
                <p>Un e-mail de confirmation vient d'être envoyé à <strong>{{ $order->customer_email }}</strong>.</p>

                <div class="confirmation-reference" x-data="{ copied: false }">
                    <span class="confirmation-reference-label">Numéro de commande</span>
                    <strong>{{ $order->order_number }}</strong>
                    <button type="button"
                            @click="navigator.clipboard.writeText('{{ $order->order_number }}').then(() => { copied = true; setTimeout(() => copied = false, 2000); })">
                        <span x-show="!copied">Copier</span>
                        <span x-show="copied" x-cloak>Copié&nbsp;!</span>
                    </button>
                </div>
            </div>

            <div class="row">
                <div class="col-md-7">
                    <section class="confirmation-panel">
                        <h3>Récapitulatif</h3>

                        {{-- Line items rather than the <table> this page shared with the old cart,
                             which could not fit its columns on a phone. --}}
                        <ul class="checkout-items">
                            @foreach ($order->items as $item)
                                <li>
                                    <span class="checkout-item-image">
                                        <img src="{{ $item->product?->images->first()?->url ?? asset('template/images/product-1.jpg') }}" alt="{{ $item->product_name }}">
                                        <span class="checkout-item-qty">{{ $item->quantity }}</span>
                                    </span>
                                    <span class="checkout-item-body">
                                        <span class="checkout-item-name">{{ $item->product_name }}</span>
                                        <small>{{ number_format((float) $item->unit_price, 2) }}&nbsp;{{ $settings->currency_symbol }} l'unité</small>
                                    </span>
                                    <span class="checkout-item-total">{{ number_format((float) $item->unit_price * $item->quantity, 2) }}&nbsp;{{ $settings->currency_symbol }}</span>
                                </li>
                            @endforeach
                        </ul>

                        <div class="checkout-totals">
                            <div class="checkout-total-row">
                                <span>Sous-total</span>
                                <span>{{ number_format((float) $order->subtotal, 2) }}&nbsp;{{ $settings->currency_symbol }}</span>
                            </div>
                            <div class="checkout-total-row">
                                <span>Livraison</span>
                                <span>{{ (float) $order->shipping === 0.0 ? 'Offerte' : number_format((float) $order->shipping, 2).' '.$settings->currency_symbol }}</span>
                            </div>
                            <div class="checkout-total-row">
                                <span>Taxes</span>
                                <span>{{ number_format((float) $order->tax, 2) }}&nbsp;{{ $settings->currency_symbol }}</span>
                            </div>
                            <div class="checkout-total-row is-grand">
                                <span>Total à régler</span>
                                <span>{{ number_format((float) $order->total, 2) }}&nbsp;{{ $settings->currency_symbol }}</span>
                            </div>
                        </div>

                        <a href="{{ \Illuminate\Support\Facades\URL::signedRoute('orders.invoice', ['order' => $order->order_number]) }}"
                           class="btn btn-primary btn-outline confirmation-invoice" target="_blank" rel="noopener">
                            Télécharger la facture (PDF)
                        </a>
                    </section>

                    <section class="confirmation-panel">
                        <h3>Livraison</h3>
                        <address class="confirmation-address">{{ $order->shipping_address }}</address>
                    </section>
                </div>

                <div class="col-md-5">
                    <aside class="confirmation-payment" x-data="{ copied: false }">
                        <h3>À faire maintenant : votre virement</h3>
                        <p>
                            Effectuez un virement de <strong>{{ number_format((float) $order->total, 2) }}&nbsp;{{ $settings->currency_symbol }}</strong>
                            en indiquant la référence <strong>{{ $order->order_number }}</strong>. Votre commande est
                            préparée dès réception et validation du virement.
                        </p>

                        @if ($settings->bank_iban)
                            <dl class="confirmation-bank">
                                @if ($settings->bank_account_holder)
                                    <dt>Titulaire</dt>
                                    <dd>{{ $settings->bank_account_holder }}</dd>
                                @endif
                                @if ($settings->bank_name)
                                    <dt>Banque</dt>
                                    <dd>{{ $settings->bank_name }}</dd>
                                @endif
                                <dt>IBAN</dt>
                                <dd class="confirmation-iban">{{ $settings->bank_iban }}</dd>
                                @if ($settings->bank_bic)
                                    <dt>BIC</dt>
                                    <dd>{{ $settings->bank_bic }}</dd>
                                @endif
                            </dl>

                            <button type="button" class="btn btn-default btn-block"
                                    @click="navigator.clipboard.writeText('{{ $settings->bank_iban }}').then(() => { copied = true; setTimeout(() => copied = false, 2000); })">
                                <span x-show="!copied">Copier l'IBAN</span>
                                <span x-show="copied" x-cloak>IBAN copié&nbsp;!</span>
                            </button>
                        @endif

                        <p class="confirmation-note">
                            La facture envoyée par e-mail reprend nos coordonnées bancaires et le montant exact à virer.
                        </p>
                    </aside>

                    <div class="confirmation-next">
                        <h4>Et ensuite ?</h4>
                        <ol>
                            <li>Nous validons la réception de votre virement.</li>
                            <li>Votre commande est préparée et expédiée.</li>
                            <li>
                                Suivez-la à tout moment depuis la page
                                <a href="{{ route('tracking.index') }}">Suivi de commande</a>, avec votre numéro et
                                votre e-mail.
                            </li>
                        </ol>
                        <a href="{{ route('catalog') }}" class="btn btn-primary btn-block">Continuer mes achats</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
