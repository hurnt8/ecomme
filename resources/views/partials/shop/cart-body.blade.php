{{-- The cart's lines and summary. Included by the cart page and re-rendered by
     CartController::cartResponse() after every change sent in the background, which swaps it into
     [data-cart-body] — so totals and the free-shipping progress are only ever formatted here. --}}
@php
    $threshold = (float) $settings->free_shipping_threshold;
    $missingForFreeShipping = max($threshold - $subtotal, 0);
@endphp

@if ($items->isEmpty())
    <div class="cart-empty">
        <i class="icon-shopping-cart"></i>
        <h3>Ihr Warenkorb ist leer</h3>
        <p>Stöbern Sie im Shop und legen Sie hinein, was Ihnen gefällt.</p>
        <a href="{{ route('catalog') }}" class="btn btn-primary btn-lg">Shop entdecken</a>
    </div>
@else
    <div class="row">
        <div class="col-md-8">
            {{-- Line items rather than a <table>: the table was 488px wide on a 375px
                 screen, so the total and the remove button were pushed off the edge
                 entirely — you could not delete an item from a phone at all. --}}
            <ul class="cart-lines">
                @foreach ($items as $item)
                    <li class="cart-line">
                        <a class="cart-line-image" href="{{ route('product.show', $item->product->slug) }}">
                            <img src="{{ $item->product->thumbnail_url }}" alt="{{ $item->product->name }}">
                        </a>

                        <div class="cart-line-body">
                            <a class="cart-line-name" href="{{ route('product.show', $item->product->slug) }}">
                                {{ $item->product->name }}
                            </a>

                            <p class="cart-line-meta">
                                <x-shop.price :price="$item->product->price" />
                                @if ($item->color)
                                    <span>Coloris : {{ $item->color }}</span>
                                @endif
                                @if ($item->size)
                                    <span>Taille : {{ $item->size }}</span>
                                @endif
                            </p>

                            @if ($item->wasCapped)
                                <p class="cart-line-notice">Quantité ajustée : stock limité à {{ $item->quantity }}.</p>
                            @endif

                            <div class="cart-line-controls">
                                {{-- Same joined stepper as the product page. Changes are sent in the
                                     background once the shopper pauses (cartQuantity in cart.js), so a
                                     run of clicks on "+" makes one request, not one per click. --}}
                                <form method="POST" action="{{ route('cart.update', $item->key) }}" data-cart-form
                                      x-data="cartQuantity({{ $item->quantity }}, {{ $item->product->stock }})">
                                    @csrf
                                    @method('PATCH')
                                    <div class="product-quantity">
                                        <button type="button" class="btn btn-default" @click="step(-1)" aria-label="Menge verringern">&minus;</button>
                                        <input type="number" name="quantity" x-model.number="quantity"
                                               min="1" max="{{ $item->product->stock }}"
                                               class="form-control text-center"
                                               aria-label="Menge"
                                               @change="save()">
                                        <button type="button" class="btn btn-default" @click="step(1)" aria-label="Menge erhöhen">+</button>
                                    </div>
                                </form>

                                <form method="POST" action="{{ route('cart.destroy', $item->key) }}" data-cart-form>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="cart-line-remove">Entfernen</button>
                                </form>
                            </div>
                        </div>

                        <div class="cart-line-total">{{ number_format($item->lineTotal, 0) }}&nbsp;{{ $settings->currency_symbol }}</div>
                    </li>
                @endforeach
            </ul>

            <a href="{{ route('catalog') }}" class="cart-continue">&larr; Continuer mes achats</a>
        </div>

        <div class="col-md-4">
            <aside class="cart-summary">
                <h3>Übersicht</h3>

                <div class="cart-summary-row">
                    <span>Zwischensumme</span>
                    <strong>{{ number_format($subtotal, 0) }}&nbsp;{{ $settings->currency_symbol }}</strong>
                </div>

                <div class="cart-summary-row is-muted">
                    <span>Versand</span>
                    <span>Wird im nächsten Schritt berechnet</span>
                </div>

                @if ($threshold > 0)
                    <div class="cart-shipping-progress">
                        @if ($missingForFreeShipping > 0)
                            <p>Plus que <strong>{{ number_format($missingForFreeShipping, 0) }}&nbsp;{{ $settings->currency_symbol }}</strong> pour la livraison offerte.</p>
                            <div class="cart-progress-track">
                                <span style="width: {{ min(100, round($subtotal / $threshold * 100)) }}%"></span>
                            </div>
                        @else
                            <p class="is-reached"><i class="icon-paper-plane"></i> Livraison offerte&nbsp;!</p>
                        @endif
                    </div>
                @endif

                <a href="{{ route('checkout.index') }}" class="btn btn-primary btn-lg btn-block">Zur Kasse</a>

                <ul class="cart-reassurance">
                    <li><i class="icon-wallet"></i> 14 jours pour changer d'avis</li>
                    <li><i class="icon-credit-card"></i> Paiement sécurisé par virement</li>
                </ul>
            </aside>
        </div>
    </div>
@endif
