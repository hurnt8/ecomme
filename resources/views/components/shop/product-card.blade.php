@props(['product'])

@php
    $onSale = $product->compare_at_price && (float) $product->compare_at_price > (float) $product->price;
    $url = route('product.show', $product->slug);
@endphp

<div class="col-md-4 text-center animate-box">
    <div class="product">
        <div class="product-grid" style="background-image:url('{{ $product->images->first()?->url }}');">
            @if ($onSale)
                <x-shop.badge label="Promo" />
            @elseif ($product->is_new)
                <x-shop.badge label="Nouveau" />
            @endif
            <div class="inner">
                <p>
                    <a href="{{ $url }}" class="icon"><i class="icon-eye"></i></a>
                </p>
            </div>
        </div>
        <div class="desc">
            <h3><a href="{{ $url }}">{{ $product->name }}</a></h3>
            <x-shop.price :price="$product->price" :compare-at-price="$product->compare_at_price" />
        </div>
    </div>
</div>
