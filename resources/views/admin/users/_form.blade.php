@php
    $isEdit = $user->exists;
@endphp

<div class="max-w-2xl rounded-lg border border-neutral-200 bg-white p-5">
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <x-admin.field label="Nom" name="name" :value="$user->name" required />
        <x-admin.field label="Adresse e-mail" name="email" type="email" :value="$user->email" required />
    </div>

    <fieldset class="mt-6">
        <legend class="mb-2 text-sm font-medium text-neutral-900">Rôle</legend>

        <div class="space-y-2">
            @foreach ($roles as $role)
                <label class="flex cursor-pointer gap-3 rounded-md border border-neutral-200 p-3 transition-colors hover:bg-neutral-50">
                    <input type="radio" name="role" value="{{ $role->value }}" class="mt-0.5"
                           @checked(old('role', $user->role?->value ?? \App\Enums\UserRole::Supervisor->value) === $role->value)>
                    <span>
                        <span class="block text-sm font-medium text-neutral-900">{{ $role->label() }}</span>
                        <span class="block text-xs text-neutral-500">{{ $role->description() }}</span>
                    </span>
                </label>
            @endforeach
        </div>

        @error('role')
            <p class="mt-1 text-xs text-clay-600">{{ $message }}</p>
        @enderror
    </fieldset>

    <div class="mt-6 border-t border-neutral-200 pt-5">
        <h2 class="mb-1 text-sm font-medium text-neutral-900">Mot de passe</h2>
        <p class="mb-3 text-xs text-neutral-500">
            {{ $isEdit
                ? 'Laissez vide pour conserver le mot de passe actuel.'
                : 'Communiquez-le à la personne concernée, qui pourra le changer depuis son compte.' }}
        </p>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <x-admin.field label="Mot de passe" name="password" type="password" :value="null" :required="! $isEdit" />
            <x-admin.field label="Confirmation" name="password_confirmation" type="password" :value="null" :required="! $isEdit" />
        </div>
    </div>

    <div class="mt-6 flex items-center gap-3">
        <button type="submit" class="rounded-md bg-brand-400 px-4 py-2 text-sm font-medium text-neutral-900 transition-colors hover:bg-brand-500">
            {{ $isEdit ? 'Enregistrer' : 'Créer l\'utilisateur' }}
        </button>
        <a href="{{ route('admin.utilisateurs.index') }}" class="text-sm text-neutral-500 hover:text-neutral-900">Annuler</a>
    </div>
</div>
