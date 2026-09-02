@csrf

<div class="max-w-xl space-y-4">
    <x-admin.field label="Nom" name="name" :value="$category->name" required />

    <x-admin.field label="Slug (laisser vide pour le générer automatiquement)" name="slug" :value="$category->slug" />

    <x-admin.field label="Description" name="description" type="textarea" :value="$category->description" />

    <div>
        <label class="block text-sm font-medium text-neutral-700 mb-1">Catégorie parente</label>
        <select name="parent_id" class="w-full rounded-md border border-neutral-300 px-3 py-2 text-sm">
            <option value="">Aucune (catégorie racine)</option>
            @foreach ($categories as $option)
                <option value="{{ $option->id }}" @selected(old('parent_id', $category->parent_id) == $option->id)>{{ $option->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium text-neutral-700 mb-1">Image</label>
        <input type="file" name="image" accept="image/*" class="text-sm">
        @if ($category->image)
            <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($category->image) }}" alt="" class="w-20 h-20 object-cover rounded mt-2">
        @endif
    </div>

    <x-admin.field label="Ordre d'affichage" name="sort_order" type="number" min="0" :value="$category->sort_order ?? 0" />

    <x-admin.checkbox label="Active (visible en boutique)" name="is_active" :checked="$category->exists ? $category->is_active : true" />

    <button type="submit" class="rounded-md bg-neutral-900 text-white text-sm px-5 py-2 hover:bg-neutral-800">
        {{ $category->exists ? 'Enregistrer' : 'Créer la catégorie' }}
    </button>
</div>
