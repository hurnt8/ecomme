@csrf

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-4">
        <x-admin.field label="Nom" name="name" :value="$product->name" required />

        <x-admin.field label="Slug (laisser vide pour le générer automatiquement)" name="slug" :value="$product->slug" />

        <x-admin.field label="Description" name="description" type="textarea" :value="$product->description" />

        <div class="grid grid-cols-2 gap-4">
            <x-admin.field label="Prix (€)" name="price" type="number" step="0.01" min="0" :value="$product->price" required />
            <x-admin.field label="Prix barré (€, optionnel)" name="compare_at_price" type="number" step="0.01" min="0" :value="$product->compare_at_price" />
        </div>

        <div class="grid grid-cols-2 gap-4">
            <x-admin.field label="Tailles (séparées par des virgules)" name="sizes" :value="$product->sizes ? implode(', ', $product->sizes) : null" placeholder="S, M, L" />
            <x-admin.field label="Couleurs (séparées par des virgules)" name="colors" :value="$product->colors ? implode(', ', $product->colors) : null" placeholder="Noir, Chêne naturel" />
        </div>

        <div>
            <label class="block text-sm font-medium text-neutral-700 mb-1">Catégorie</label>
            <select name="category_id" class="w-full rounded-md border border-neutral-300 px-3 py-2 text-sm">
                <option value="">Aucune</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <x-admin.field label="Stock" name="stock" type="number" min="0" :value="$product->stock ?? 0" />

        <div class="flex gap-6">
            <x-admin.checkbox label="Actif (visible en boutique)" name="is_active" :checked="$product->exists ? $product->is_active : true" />
            <x-admin.checkbox label="Nouveauté" name="is_new" :checked="$product->is_new" />
        </div>

        <x-admin.field label="Nombre d'avis à afficher (générés automatiquement)" name="reviews_count" type="number" min="0" max="500"
                        :value="$product->exists ? $product->reviews->count() : 0" />
    </div>

    <div class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-neutral-700 mb-1">Ajouter des images</label>
            <input type="file" name="images[]" multiple accept="image/*" class="text-sm">
            <p class="text-xs text-neutral-400 mt-1">La première image existante (ou la première ajoutée) est l'image principale.</p>
        </div>

        @if ($product->exists && $product->images->isNotEmpty())
            <div class="grid grid-cols-3 gap-2">
                @foreach ($product->images as $image)
                    <div class="relative border border-neutral-200 rounded overflow-hidden">
                        <img src="{{ $image->url }}" alt="" class="w-full h-20 object-cover">
                        @if ($image->position === 0)
                            <span class="absolute top-1 left-1 bg-neutral-900 text-white text-[10px] px-1.5 py-0.5 rounded">Principale</span>
                        @endif
                        <div class="flex divide-x divide-neutral-200 border-t border-neutral-200 text-xs">
                            @if ($image->position !== 0)
                                <form method="POST" action="{{ route('admin.produits.images.main', [$product, $image]) }}" class="flex-1">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="w-full py-1 hover:bg-neutral-50">Définir</button>
                                </form>
                            @endif
                            <form method="POST" action="{{ route('admin.produits.images.destroy', [$product, $image]) }}" class="flex-1"
                                  onsubmit="return confirm('Supprimer cette image ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full py-1 text-red-600 hover:bg-red-50">Retirer</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<div class="mt-6">
    <button type="submit" class="rounded-md bg-neutral-900 text-white text-sm px-5 py-2 hover:bg-neutral-800">
        {{ $product->exists ? 'Enregistrer' : 'Créer le produit' }}
    </button>
</div>
