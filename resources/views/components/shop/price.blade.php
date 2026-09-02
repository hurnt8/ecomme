@props(['price', 'compareAtPrice' => null, 'currency' => $settings->currency ?? 'EUR'])

@php
    $symbol = $currency === 'EUR' ? '€' : $currency;
    $onSale = $compareAtPrice && (float) $compareAtPrice > (float) $price;
@endphp

<span {{ $attributes->class(['price']) }}>
    @if ($onSale)
        <small><del>{{ number_format((float) $compareAtPrice, 0) }}&nbsp;{{ $symbol }}</del></small>
    @endif
    {{ number_format((float) $price, 0) }}&nbsp;{{ $symbol }}
</span>
