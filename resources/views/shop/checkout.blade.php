@extends('layouts.shop')

@section('title', 'Commande')

@section('content')
    <header id="fh5co-header" class="fh5co-cover fh5co-cover-sm fh5co-cover-compact" role="banner" style="background-image:url('{{ asset('template/images/img_bg_4.jpg') }}');">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 text-center">
                    <div class="display-t">
                        <div class="display-tc animate-box" data-animate-effect="fadeIn">
                            <h1>Commande</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div id="fh5co-product" class="checkout">
        <div class="container">
            <ol class="checkout-steps">
                <li class="is-done"><a href="{{ route('cart.index') }}"><span>1</span> Panier</a></li>
                <li class="is-current"><span>2</span> Livraison &amp; paiement</li>
                <li><span>3</span> Confirmation</li>
            </ol>

            @if ($errors->any())
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-danger">
                            <ul style="margin:0;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <div class="row checkout-row"
                 x-data="{
                    country: '{{ old('country', 'FR') }}',
                    subtotal: {{ $summary['subtotal'] }},
                    freeShippingThreshold: {{ (float) $settings->free_shipping_threshold }},
                    baseShipping: {{ \App\Services\ShippingService::BASE_SHIPPING_FEE }},
                    internationalFee: {{ (float) $settings->international_shipping_fee }},
                    taxRate: {{ (float) $settings->tax_rate }},
                    eurozone: {{ Illuminate\Support\Js::from(\App\Support\Eurozone::COUNTRY_CODES) }},
                    get shipping() {
                        const base = this.subtotal >= this.freeShippingThreshold ? 0 : this.baseShipping;
                        const intl = this.eurozone.includes(this.country) ? 0 : this.internationalFee;
                        return Math.round((base + intl) * 100) / 100;
                    },
                    get tax() { return Math.round(this.subtotal * this.taxRate * 100) / 100; },
                    get total() { return Math.round((this.subtotal + this.shipping + this.tax) * 100) / 100; },
                 }">
                <div class="col-md-7 checkout-form-col">
                    <form method="POST" action="{{ route('checkout.store') }}">
                        @csrf

                        <section class="checkout-section">
                            <h3><span class="checkout-section-num">1</span> Coordonnées</h3>
                            <div class="form-group">
                                <label for="customer_name">Nom complet</label>
                                <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name') }}" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="customer_email">E-mail</label>
                                <input type="email" name="customer_email" id="customer_email" value="{{ old('customer_email') }}" class="form-control" required>
                                <small class="checkout-hint">La confirmation et le suivi de commande y seront envoyés.</small>
                            </div>
                        </section>

                        <section class="checkout-section">
                            <h3><span class="checkout-section-num">2</span> Adresse de livraison</h3>
                            <div class="form-group">
                                <label for="address_line1">Adresse</label>
                                <input type="text" name="address_line1" id="address_line1" value="{{ old('address_line1') }}" class="form-control" required>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="postal_code">Code postal</label>
                                        <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code') }}" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="city">Ville</label>
                                        <input type="text" name="city" id="city" value="{{ old('city') }}" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="country">Pays</label>
                                <select name="country" id="country" class="form-control" x-model="country" required>
                                    @foreach ($countries as $code => $label)
                                        <option value="{{ $code }}" @selected(old('country', 'FR') === $code)>{{ $label }}</option>
                                    @endforeach
                                </select>
                                <small class="checkout-hint checkout-hint-warning" x-show="!eurozone.includes(country)" x-cloak>
                                    Hors zone euro : des frais de livraison internationaux s'appliquent.
                                </small>
                            </div>
                        </section>

                        <section class="checkout-section">
                            <h3><span class="checkout-section-num">3</span> Paiement</h3>
                            <div class="checkout-payment">
                                <strong>Virement bancaire</strong>
                                <p>
                                    Nos coordonnées bancaires (IBAN) vous seront communiquées par e-mail et sur la page
                                    de confirmation. Votre commande est préparée dès réception et validation du virement.
                                </p>
                            </div>
                        </section>

                        <button type="submit" class="btn btn-primary btn-lg checkout-submit">Valider ma commande</button>

                        <a href="{{ route('cart.index') }}" class="checkout-back">&larr; Retour au panier</a>
                    </form>
                </div>

                <div class="col-md-5 checkout-summary-col">
                    <aside class="checkout-summary">
                        <h3>Votre commande</h3>

                        <ul class="checkout-items">
                            @foreach ($items as $item)
                                <li>
                                    <span class="checkout-item-image">
                                        <img src="{{ $item->product->images->first()?->url }}" alt="{{ $item->product->name }}">
                                        <span class="checkout-item-qty">{{ $item->quantity }}</span>
                                    </span>
                                    <span class="checkout-item-body">
                                        <span class="checkout-item-name">{{ $item->product->name }}</span>
                                        @if ($item->color || $item->size)
                                            <small>{{ collect([$item->color, $item->size])->filter()->join(' · ') }}</small>
                                        @endif
                                        @if ($item->wasCapped)
                                            <small class="checkout-item-notice">Quantité ajustée : stock limité à {{ $item->quantity }}.</small>
                                        @endif
                                    </span>
                                    <span class="checkout-item-total">{{ number_format($item->lineTotal, 0) }}&nbsp;{{ $settings->currency_symbol }}</span>
                                </li>
                            @endforeach
                        </ul>

                        <div class="checkout-totals">
                            <div class="checkout-total-row">
                                <span>Sous-total</span>
                                <span>{{ number_format($summary['subtotal'], 2) }}&nbsp;{{ $settings->currency_symbol }}</span>
                            </div>
                            <div class="checkout-total-row">
                                <span>Livraison</span>
                                <span x-text="shipping === 0 ? 'Offerte' : shipping.toFixed(2) + ' {{ $settings->currency_symbol }}'"></span>
                            </div>
                            <div class="checkout-total-row">
                                <span>Taxes</span>
                                <span x-text="tax.toFixed(2) + ' {{ $settings->currency_symbol }}'"></span>
                            </div>
                            <div class="checkout-total-row is-grand">
                                <span>Total</span>
                                <span x-text="total.toFixed(2) + ' {{ $settings->currency_symbol }}'"></span>
                            </div>
                        </div>

                        <ul class="checkout-reassurance">
                            <li><i class="icon-wallet"></i> Retour gratuit sous 30 jours</li>
                            <li><i class="icon-credit-card"></i> Aucune donnée bancaire stockée sur le site</li>
                        </ul>
                    </aside>
                </div>
            </div>
        </div>
    </div>
@endsection
