@props(['label', 'name', 'checked' => false])

<label class="flex items-center gap-2 text-sm text-neutral-700">
    <input type="hidden" name="{{ $name }}" value="0">
    <input type="checkbox" name="{{ $name }}" value="1"
           class="rounded border-neutral-300 text-neutral-800 focus:ring-neutral-800"
           @checked(old($name, $checked))>
    {{ $label }}
</label>
