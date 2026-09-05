@props(['label', 'name', 'type' => 'text', 'value' => null, 'required' => false])

<div>
    <label for="{{ $name }}" class="block text-sm font-medium text-neutral-700 mb-1">{{ $label }}</label>

    @if ($type === 'textarea')
        <textarea name="{{ $name }}" id="{{ $name }}" rows="4"
                  {{ $attributes->merge(['class' => 'w-full rounded-md border border-neutral-300 bg-white px-3 py-2 text-sm transition-colors placeholder:text-neutral-400 focus:border-brand-400 focus:outline-none focus:ring-2 focus:ring-brand-200']) }}
                  @if ($required) required @endif>{{ old($name, $value) }}</textarea>
    @else
        <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" value="{{ old($name, $value) }}"
               {{ $attributes->merge(['class' => 'w-full rounded-md border border-neutral-300 bg-white px-3 py-2 text-sm transition-colors placeholder:text-neutral-400 focus:border-brand-400 focus:outline-none focus:ring-2 focus:ring-brand-200']) }}
               @if ($required) required @endif>
    @endif

    @error($name)
        <p class="mt-1 text-xs text-clay-600">{{ $message }}</p>
    @enderror
</div>
