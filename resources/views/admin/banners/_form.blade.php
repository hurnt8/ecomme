@csrf

@php
    $positionLabels = [
        'home_hero' => 'Accueil — bannière principale',
        'home_secondary' => 'Accueil — bannières secondaires',
        'shop_new' => 'Boutique — nouveautés',
        'shop_sale' => 'Boutique — promotions',
        'shop_all' => 'Boutique — générale',
    ];
@endphp

<div class="max-w-xl space-y-4">
    <x-admin.field label="Titre" name="title" :value="$banner->title" required />

    <x-admin.field label="Sous-titre" name="subtitle" type="textarea" :value="$banner->subtitle" />

    <div>
        <label class="block text-sm font-medium text-neutral-700 mb-1">Image {{ $banner->exists ? '' : '(requise)' }}</label>
        <input type="file" name="image" accept="image/*" class="text-sm" @unless ($banner->exists) required @endunless>
        @if ($banner->exists)
            <img src="{{ $banner->image_url }}" alt="" class="w-40 h-24 object-cover rounded mt-2">
        @endif
    </div>

    <x-admin.field label="Lien (optionnel)" name="link_url" :value="$banner->link_url" placeholder="/boutique" />

    <div>
        <label class="block text-sm font-medium text-neutral-700 mb-1">Emplacement</label>
        <select name="position" class="w-full rounded-md border border-neutral-300 px-3 py-2 text-sm" required>
            @foreach ($positions as $position)
                <option value="{{ $position }}" @selected(old('position', $banner->position) === $position)>
                    {{ $positionLabels[$position] ?? $position }}
                </option>
            @endforeach
        </select>
    </div>

    <x-admin.field label="Ordre d'affichage" name="sort_order" type="number" min="0" :value="$banner->sort_order ?? 0" />

    <x-admin.checkbox label="Active" name="is_active" :checked="$banner->exists ? $banner->is_active : true" />

    <button type="submit" class="rounded-md bg-brand-400 px-5 py-2 text-sm font-medium text-neutral-900 transition-colors hover:bg-brand-500">
        {{ $banner->exists ? 'Enregistrer' : 'Créer la bannière' }}
    </button>
</div>
