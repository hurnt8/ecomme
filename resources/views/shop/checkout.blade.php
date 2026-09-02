@extends('layouts.shop')

@section('title', 'Commande')

@section('content')
    <header id="fh5co-header" class="fh5co-cover fh5co-cover-sm" role="banner" style="background-image:url('{{ asset('template/images/img_bg_4.jpg') }}');">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 text-center">
                    <div class="display-t">
                        <div class="display-tc animate-box" data-animate-effect="fadeIn">
                            <h1>Finaliser ma commande</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div id="fh5co-product">
        <div class="container">
            @if ($errors->any())
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
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

            <div class="row"
                 x-data="{
                    country: '{{ old('country', 'FR') }}',
                    subtotal: {{ $summary['subtotal'] }},
                    freeShippingThreshold: {{ (float) $settings->free_shipping_threshold }},
                    baseShipping: {{ \App\Services\ShippingService::BASE_SHIPPING_FEE }},
                    internationalFee: {{ (float) $settings->international_shipping_fee }},
                    taxRate: {{ (float) $settings->tax_rate }},
                    eurozone: @json(\App\Support\Eurozone::COUNTRY_CODES),
                    get shipping() {
                        const base = this.subtotal >= this.freeShippingThreshold ? 0 : this.baseShipping;
                        const intl = this.eurozone.includes(this.country) ? 0 : this.internationalFee;
                        return Math.round((base + intl) * 100) / 100;
                    },
                    get tax() { return Math.round(this.subtotal * this.taxRate * 100) / 100; },
                    get total() { return Math.round((this.subtotal + this.shipping + this.tax) * 100) / 100; },
                 }">
                <div class="col-md-7">
                    <form method="POST" action="{{ route('checkout.store') }}">
                        @csrf

                        <h3>Coordonnées</h3>
                        <div class="form-group">
                            <label for="customer_name">Nom complet</label>
                            <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name') }}" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="customer_email">E-mail</label>
                            <input type="email" name="customer_email" id="customer_email" value="{{ old('customer_email') }}" class="form-control" required>
                        </div>

                        <h3>Adresse de livraison</h3>
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
                            <p class="text-muted" x-show="!eurozone.includes(country)" x-cloak style="margin-top:5px;">
                                Frais de livraison internationaux applicables hors zone euro.
                            </p>
                        </div>

                        <h3>Paiement</h3>
                        <p>
                            Virement bancaire. Nos coordonnées bancaires (IBAN) vous seront communiquées par e-mail
                            et sur la page de confirmation — votre commande sera préparée dès réception et
                            validation du virement.
                        </p>

                        <button type="submit" class="btn btn-primary btn-outline btn-lg">Valider ma commande</button>
                    </form>
                </div>

                <div class="col-md-5">
                    <div style="border:1px solid #e5e5e5;padding:25px;">
                        <h3 style="margin-top:0;">Récapitulatif</h3>
                        <ul class="list-unstyled">
                            @foreach ($items as $item)
                                <li style="margin-bottom:10px;">
                                    {{ $item->product->name }} × {{ $item->quantity }}
                                    <span style="float:right;">{{ number_format($item->lineTotal, 0) }}&nbsp;€</span>
                                    @if ($item->wasCapped)
                                        <br><small class="text-danger">Quantité ajustée : stock limité à {{ $item->quantity }}. Merci de vérifier votre panier.</small>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                        <hr>
                        <p>Sous-total <span style="float:right;">{{ number_format($summary['subtotal'], 2) }}&nbsp;€</span></p>
                        <p>Livraison <span style="float:right;" x-text="shipping.toFixed(2) + ' €'"></span></p>
                        <p>Taxes <span style="float:right;" x-text="tax.toFixed(2) + ' €'"></span></p>
                        <hr>
                        <p><strong>Total <span style="float:right;" x-text="total.toFixed(2) + ' €'"></span></strong></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
