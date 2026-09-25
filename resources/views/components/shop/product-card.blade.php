@props(['product'])

@php
    $onSale = $product->compare_at_price && (float) $product->compare_at_price > (float) $product->price;
    $url = route('product.show', $product->slug);
@endphp

<div class="col-md-4 text-center animate-box">
    <div class="product">
        <div class="product-grid" style="background-image:url('{{ $product->thumbnail_url }}');">
            @if ($onSale)
                <x-shop.badge label="Promo" variant="promo" />
            @elseif ($product->is_new)
                <x-shop.badge label="Nouveau" />
            @endif
            {{-- Not a <p>: the HTML parser auto-closes an open <p> as soon as it sees a <form>
                 start tag (form is on the small list of elements that implicitly end a
                 paragraph), so a <form> nested here would silently end up as a stray sibling
                 after </p> instead of sitting next to the eye link — see the .fh5co-quick-actions
                 rule in app.css that gives this div the same table-cell centering .inner p had. --}}
            <div class="inner">
                <div class="fh5co-quick-actions">
                    <a href="{{ $url }}" class="icon" title="Produkt ansehen" aria-label="Produkt ansehen"><i class="icon-eye"></i></a>
                    <form method="POST" action="{{ route('cart.store') }}" class="product-quick-add" data-cart-form>
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="icon" title="In den Warenkorb" aria-label="In den Warenkorb">
                            <i class="icon-shopping-cart"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="desc">
            <h3><a href="{{ $url }}">{{ $product->name }}</a></h3>
            <x-shop.price :price="$product->price" :compare-at-price="$product->compare_at_price" />
        </div>
    </div>
</div>
