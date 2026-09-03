@props(['label', 'variant' => 'new'])

{{-- Reuses the template's existing .sale badge style (circular, top-left); .sale-promo (app.css)
     recolors it for the promo variant so "Nouveau" and "Promo" aren't the same color on a card
     that can show either. --}}
<span class="sale @if ($variant === 'promo') sale-promo @endif">{{ $label }}</span>
