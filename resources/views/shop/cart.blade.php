@extends('layouts.shop')

@section('title', 'Panier')

@section('content')
    <header id="fh5co-header" class="fh5co-cover fh5co-cover-sm" role="banner" style="background-image:url('{{ asset('template/images/img_bg_3.jpg') }}');">
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

    <div id="fh5co-product">
        <div class="container">
            @if ($items->isEmpty())
                <div class="row text-center">
                    <div class="col-md-12">
                        <p>Votre panier est vide.</p>
                        <p><a href="{{ route('catalog') }}" class="btn btn-primary btn-outline btn-lg">Découvrir la boutique</a></p>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-md-8">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th>Prix</th>
                                    <th>Quantité</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>
                                            <a href="{{ route('product.show', $item->product->slug) }}" style="display:flex;align-items:center;gap:10px;color:#000;">
                                                <img src="{{ $item->product->images->first()?->url }}" alt="{{ $item->product->name }}" style="width:60px;height:60px;object-fit:cover;">
                                                <span>
                                                    {{ $item->product->name }}
                                                    @if ($item->color)
                                                        <br><small class="text-muted">Couleur : {{ $item->color }}</small>
                                                    @endif
                                                    @if ($item->size)
                                                        <br><small class="text-muted">Taille : {{ $item->size }}</small>
                                                    @endif
                                                </span>
                                            </a>
                                        </td>
                                        <td><x-shop.price :price="$item->product->price" /></td>
                                        <td>
                                            <form method="POST" action="{{ route('cart.update', $item->key) }}" style="display:flex;gap:5px;">
                                                @csrf
                                                @method('PATCH')
                                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}" class="form-control" style="width:70px;">
                                                <button type="submit" class="btn btn-default btn-sm">OK</button>
                                            </form>
                                        </td>
                                        <td>{{ number_format($item->lineTotal, 0) }}&nbsp;€</td>
                                        <td>
                                            <form method="POST" action="{{ route('cart.destroy', $item->key) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link" aria-label="Retirer du panier" title="Retirer">&times;</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-4">
                        <div style="border:1px solid #e5e5e5;padding:25px;">
                            <h3 style="margin-top:0;">Récapitulatif</h3>
                            <p>Sous-total <strong style="float:right;">{{ number_format($subtotal, 0) }}&nbsp;€</strong></p>
                            <p class="text-muted">Frais de livraison calculés à l'étape suivante.</p>
                            <p><a href="{{ url('/commande') }}" class="btn btn-primary btn-block">Passer commande</a></p>
                        </div>
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
                @foreach ($recommended->chunk(3) as $row)
                    <div class="row">
                        @foreach ($row as $product)
                            <x-shop.product-card :product="$product" />
                        @endforeach
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection
