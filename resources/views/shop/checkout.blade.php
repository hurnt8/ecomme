@extends('layouts.shop')

@section('title', 'Bestellung')

@section('content')
    <header id="fh5co-header" class="fh5co-cover fh5co-cover-sm fh5co-cover-compact" role="banner" style="background-image:url('{{ asset('images/hero-maison.jpg') }}');">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 text-center">
                    <div class="display-t">
                        <div class="display-tc animate-box" data-animate-effect="fadeIn">
                            <h1>Bestellung</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div id="fh5co-product" class="checkout">
        <div class="container">
            <ol class="checkout-steps">
                <li class="is-done"><a href="{{ route('cart.index') }}"><span>1</span> Warenkorb</a></li>
                <li class="is-current"><span>2</span> Lieferung &amp; Zahlung</li>
                <li><span>3</span> Bestätigung</li>
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
                    <form method="POST" action="{{ route('checkout.store') }}" id="checkout-form">
                        @csrf

                        <section class="checkout-section">
                            <h3><span class="checkout-section-num">1</span> Kontaktdaten</h3>
                            <div class="form-group">
                                <label for="customer_name">Vollständiger Name</label>
                                <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name') }}" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="customer_email">E-Mail</label>
                                <input type="email" name="customer_email" id="customer_email" value="{{ old('customer_email') }}" class="form-control" required>
                                <small class="checkout-hint">Bestätigung und Sendungsverfolgung gehen an diese Adresse.</small>
                            </div>
                        </section>

                        <section class="checkout-section">
                            <h3><span class="checkout-section-num">2</span> Lieferadresse</h3>
                            <div class="form-group">
                                <label for="address_line1">Adresse</label>
                                <input type="text" name="address_line1" id="address_line1" value="{{ old('address_line1') }}" class="form-control" required>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="postal_code">Postleitzahl</label>
                                        <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code') }}" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="city">Ort</label>
                                        <input type="text" name="city" id="city" value="{{ old('city') }}" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="country">Land</label>
                                <select name="country" id="country" class="form-control" x-model="country" required>
                                    @foreach ($countries as $code => $label)
                                        <option value="{{ $code }}" @selected(old('country', 'FR') === $code)>{{ $label }}</option>
                                    @endforeach
                                </select>
                                <small class="checkout-hint checkout-hint-warning" x-show="!eurozone.includes(country)" x-cloak>
                                    Außerhalb der Eurozone: es fallen internationale Versandkosten an.
                                </small>
                            </div>
                        </section>

                        <section class="checkout-section">
                            <h3><span class="checkout-section-num">3</span> Zahlung</h3>
                            <div class="checkout-payment">
                                <strong>Banküberweisung</strong>
                                <p>
                                    Unsere Bankverbindung (IBAN) wird Ihnen per E-Mail und auf der Bestätigungsseite
                                    mitgeteilt. Ihre Bestellung wird bearbeitet, sobald die Überweisung eingegangen und bestätigt ist.
                                </p>
                            </div>
                        </section>

                    </form>
                </div>

                <div class="col-md-5 checkout-summary-col">
                    {{-- The lines fold away so the totals stay reachable without scrolling past
                         every product; open by default where the sidebar has the room, closed on
                         a phone, where the recap sits under the form. --}}
                    <aside class="checkout-summary" x-data="{ itemsOpen: window.matchMedia('(min-width: 992px)').matches }">
                        <button type="button" class="checkout-summary-toggle"
                                @click="itemsOpen = !itemsOpen"
                                :aria-expanded="itemsOpen ? 'true' : 'false'">
                            <span>
                                Ihre Bestellung
                                <small>({{ $items->sum('quantity') }} Artikel)</small>
                            </span>
                            <i class="icon-arrow-down" :class="{ 'is-open': itemsOpen }" aria-hidden="true"></i>
                        </button>

                        <ul class="checkout-items" x-show="itemsOpen" x-cloak>
                            @foreach ($items as $item)
                                <li>
                                    <span class="checkout-item-image">
                                        <img src="{{ $item->product->thumbnail_url }}" alt="{{ $item->product->name }}">
                                        <span class="checkout-item-qty">{{ $item->quantity }}</span>
                                    </span>
                                    <span class="checkout-item-body">
                                        <span class="checkout-item-name">{{ $item->product->name }}</span>
                                        @if ($item->color || $item->size)
                                            <small>{{ collect([$item->color, $item->size])->filter()->join(' · ') }}</small>
                                        @endif
                                        @if ($item->wasCapped)
                                            <small class="checkout-item-notice">Menge angepasst: Lagerbestand begrenzt auf {{ $item->quantity }}.</small>
                                        @endif
                                    </span>
                                    <span class="checkout-item-total">{{ number_format($item->lineTotal, 0) }}&nbsp;{{ $settings->currency_symbol }}</span>
                                </li>
                            @endforeach
                        </ul>

                        <div class="checkout-totals">
                            <div class="checkout-total-row">
                                <span>Zwischensumme</span>
                                <span>{{ number_format($summary['subtotal'], 2) }}&nbsp;{{ $settings->currency_symbol }}</span>
                            </div>
                            <div class="checkout-total-row">
                                <span>Versand</span>
                                <span x-text="shipping === 0 ? 'Kostenlos' : shipping.toFixed(2) + ' {{ $settings->currency_symbol }}'"></span>
                            </div>
                            <div class="checkout-total-row">
                                <span>Steuern</span>
                                <span x-text="tax.toFixed(2) + ' {{ $settings->currency_symbol }}'"></span>
                            </div>
                            <div class="checkout-total-row is-grand">
                                <span>Gesamt</span>
                                <span x-text="total.toFixed(2) + ' {{ $settings->currency_symbol }}'"></span>
                            </div>
                        </div>

                        <ul class="checkout-reassurance">
                            <li><i class="icon-wallet"></i> 14 Tage Widerrufsrecht</li>
                            <li><i class="icon-credit-card"></i> Keine Bankdaten werden auf der Website gespeichert</li>
                        </ul>
                    </aside>
                </div>

                {{-- Outside the <form>, bound back to it with the form attribute, so it can sit
                     after the recap: the fields come first as asked, but the shopper still meets
                     the totals before confirming rather than after. A col-md-7 following the
                     col-md-5 recap wraps onto its own line, landing back under the form column on
                     desktop. --}}
                <div class="col-md-7 checkout-actions-col">
                    <button type="submit" form="checkout-form" class="btn btn-primary btn-lg checkout-submit">Bestellung abschließen</button>
                    <a href="{{ route('cart.index') }}" class="checkout-back">&larr; Zurück zum Warenkorb</a>
                </div>
            </div>
        </div>
    </div>
@endsection
