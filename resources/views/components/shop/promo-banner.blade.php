@props(['banner', 'showCountdown' => false])

@if ($banner->link_url)
    <a href="{{ $banner->link_url }}" class="fh5co-promo-banner" style="background-image:url('{{ $banner->image_url }}');">
        <div class="fh5co-promo-banner-overlay"></div>
        <div class="fh5co-promo-banner-text">
            <h3>{{ $banner->title }}</h3>
            @if ($banner->subtitle)
                <p>{{ $banner->subtitle }}</p>
            @endif

            @if ($showCountdown && $settings->sale_ends_at && $settings->sale_ends_at->isFuture())
                <x-shop.countdown :until="$settings->sale_ends_at" />
            @endif
        </div>
    </a>
@else
    <div class="fh5co-promo-banner" style="background-image:url('{{ $banner->image_url }}');">
        <div class="fh5co-promo-banner-overlay"></div>
        <div class="fh5co-promo-banner-text">
            <h3>{{ $banner->title }}</h3>
            @if ($banner->subtitle)
                <p>{{ $banner->subtitle }}</p>
            @endif

            @if ($showCountdown && $settings->sale_ends_at && $settings->sale_ends_at->isFuture())
                <x-shop.countdown :until="$settings->sale_ends_at" />
            @endif
        </div>
    </div>
@endif
