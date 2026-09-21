@extends('layouts.shop')

@section('title', 'Panier')

@section('content')
    <header id="fh5co-header" class="fh5co-cover fh5co-cover-sm fh5co-cover-compact" role="banner" style="background-image:url('{{ asset('images/hero-objets.jpg') }}');">
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
            {{-- Swapped for the re-rendered partial after every change sent in the background
                 (resources/js/modules/cart.js), so the page never reloads. --}}
            <div data-cart-body>
                @include('partials.shop.cart-body')
            </div>

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
