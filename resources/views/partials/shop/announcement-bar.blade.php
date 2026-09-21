@if ($settings->announcement_text)
    <div style="background:var(--shop-accent);color:#fff;text-align:center;padding:8px 15px;font-size:13px;letter-spacing:.5px;">
        {{ $settings->announcement_text }}
    </div>
@endif
