@extends('layouts.shop')

@section('title', 'Panier')

@php
    $threshold = (float) $settings->free_shipping_threshold;
    $missingForFreeShipping = max($threshold - $subtotal, 0);
@endphp

@section('content')
    <header id="fh5co-header" class="fh5co-cover fh5co-cover-sm fh5co-cover-compact" role="banner" style="background-image:url('{{ asset('template/images/img_bg_3.jpg') }}');">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 text-center">
                    <div class="display-t">
                        <div class="display-tc animate-box" data-animate-effect="fadeIn">
                            <h1>Panier</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div id="fh5co-product" class="cart">
        <div class="container">
            @if ($items->isEmpty())
                <div class="cart-empty">
                    <i class="icon-shopping-cart"></i>
                    <h3>Votre panier est vide</h3>
                    <p>Parcourez la boutique et ajoutez les pièces qui vous plaisent.</p>
                    <a href="{{ route('catalog') }}" class="btn btn-primary btn-lg">Découvrir la boutique</a>
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
                                            {{-- Same joined stepper as the product page, submitting on change so the
                                                 separate "OK" button the table needed is gone. --}}
                                            <form method="POST" action="{{ route('cart.update', $item->key) }}"
                                                  x-data="{ quantity: {{ $item->quantity }}, max: {{ $item->product->stock }} }">
                                                @csrf
                                                @method('PATCH')
                                                <div class="product-quantity">
                                                    <button type="button" class="btn btn-default"
                                                            @click="quantity = Math.max(1, quantity - 1); $nextTick(() => $el.form.submit())"
                                                            aria-label="Diminuer la quantité">&minus;</button>
                                                    <input type="number" name="quantity" x-model.number="quantity"
                                                           min="1" max="{{ $item->product->stock }}"
                                                           class="form-control text-center"
                                                           aria-label="Quantité"
                                                           @change="$el.form.submit()">
                                                    <button type="button" class="btn btn-default"
                                                            @click="quantity = Math.min(max, quantity + 1); $nextTick(() => $el.form.submit())"
                                                            aria-label="Augmenter la quantité">+</button>
                                                </div>
                                            </form>

                                            <form method="POST" action="{{ route('cart.destroy', $item->key) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="cart-line-remove">Retirer</button>
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
                            <h3>Récapitulatif</h3>

                            <div class="cart-summary-row">
                                <span>Sous-total</span>
                                <strong>{{ number_format($subtotal, 0) }}&nbsp;{{ $settings->currency_symbol }}</strong>
                            </div>

                            <div class="cart-summary-row is-muted">
                                <span>Livraison</span>
                                <span>Calculée à l'étape suivante</span>
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

                            <a href="{{ route('checkout.index') }}" class="btn btn-primary btn-lg btn-block">Passer commande</a>

                            <ul class="cart-reassurance">
                                <li><i class="icon-wallet"></i> Retour gratuit sous 30 jours</li>
                                <li><i class="icon-credit-card"></i> Paiement sécurisé par virement</li>
                            </ul>
                        </aside>
                    </div>
                </div>
            @endif

            @if ($recommended->isNotEmpty())
                <div class="row animate-box" style="margin-top:60px;">
                    <div class="col-md-8 col-md-offset-2 text-center fh5co-heading">
                        <span>Recommandations</span>
                        <h2>Vous aimerez aussi</h2>
                    </div>
                </div>
                <div class="row">
                    @foreach ($recommended as $product)
                        <x-shop.product-card :product="$product" />
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
