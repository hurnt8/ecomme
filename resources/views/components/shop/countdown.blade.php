@props(['until'])

<div
    class="fh5co-countdown"
    x-data="{
        end: new Date('{{ $until->toIso8601String() }}').getTime(),
        remaining: 0,
        tick() {
            this.remaining = Math.max(0, this.end - Date.now());
        },
        get days() { return Math.floor(this.remaining / 86400000); },
        get hours() { return Math.floor((this.remaining % 86400000) / 3600000); },
        get minutes() { return Math.floor((this.remaining % 3600000) / 60000); },
        get seconds() { return Math.floor((this.remaining % 60000) / 1000); },
        pad(n) { return String(n).padStart(2, '0'); },
    }"
    x-init="tick(); setInterval(() => tick(), 1000)"
    x-show="remaining > 0"
    x-cloak
>
    <span class="fh5co-countdown-label">Endet in</span>
    <span class="fh5co-countdown-clock">
        <span x-show="days > 0"><span x-text="days"></span>T </span><span x-text="pad(hours)"></span>:<span x-text="pad(minutes)"></span>:<span x-text="pad(seconds)"></span>
    </span>
</div>
