@props(['label', 'name', 'type' => 'text', 'value' => null, 'required' => false])

@php
    // A password is never echoed back into the markup: old() would write the rejected password in
    // clear text into the HTML of the redisplayed form, where it lands in browser caches and in
    // any proxy log along the way.
    $previous = $type === 'password' ? null : old($name, $value);
@endphp

<div>
    <label for="{{ $name }}" class="block text-sm font-medium text-neutral-700 mb-1">{{ $label }}</label>

    @if ($type === 'textarea')
        <textarea name="{{ $name }}" id="{{ $name }}" rows="4"
                  {{ $attributes->merge(['class' => 'w-full rounded-md border border-neutral-300 bg-white px-3 py-2 text-sm transition-colors placeholder:text-neutral-400 focus:border-brand-400 focus:outline-none focus:ring-2 focus:ring-brand-200']) }}
                  @if ($required) required @endif>{{ $previous }}</textarea>
    @else
        <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" value="{{ $previous }}"
               {{ $attributes->merge(['class' => 'w-full rounded-md border border-neutral-300 bg-white px-3 py-2 text-sm transition-colors placeholder:text-neutral-400 focus:border-brand-400 focus:outline-none focus:ring-2 focus:ring-brand-200']) }}
               @if ($required) required @endif>
    @endif

    @error($name)
        <p class="mt-1 text-xs text-clay-600">{{ $message }}</p>
    @enderror
</div>
