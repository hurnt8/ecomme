@props(['product'])

{{-- A product tile for the home page carousels, after the guerrinibois.fr cards: square photo,
     discount tag, an "Ajouter au panier" bar that slides up on hover (always shown on touch
     screens, see app.css), then the name and price. --}}
@php
    $url = route('product.show', $product->slug);
    $discount = $product->compare_at_price && (float) $product->compare_at_price > (float) $product->price
        ? (int) round((1 - (float) $product->price / (float) $product->compare_at_price) * 100)
        : 0;
@endphp

<div class="home-product">
    <div class="home-product-thumb">
        <a href="{{ $url }}" class="home-product-image">
            <img src="{{ $product->thumbnail_url }}" alt="{{ $product->name }}" loading="lazy">
        </a>

        @if ($discount > 0)
            <span class="home-product-tag">-{{ $discount }}%</span>
        @elseif ($product->is_new)
            <span class="home-product-tag is-new">Nouveau</span>
        @endif

        <form method="POST" action="{{ route('cart.store') }}" class="home-product-add" data-cart-form>
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="quantity" value="1">
            <button type="submit">Ajouter au panier</button>
        </form>
    </div>

    <h3 class="home-product-title"><a href="{{ $url }}">{{ $product->name }}</a></h3>
    <x-shop.price :price="$product->price" :compare-at-price="$product->compare_at_price" />
</div>
