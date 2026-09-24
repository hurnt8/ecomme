@extends('layouts.admin')

@section('title', 'Utilisateurs')

@section('content')
    @if ($errors->any())
        <div class="mb-4 rounded-md border border-clay-200 bg-clay-50 px-4 py-3 text-sm text-clay-700">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="flex items-center justify-between mb-4">
        <p class="text-sm text-neutral-500">
            Comptes de l'équipe. Les {{ $customerCount }} comptes clients ne figurent pas ici.
        </p>
        <a href="{{ route('admin.utilisateurs.create') }}" class="rounded-md bg-brand-400 px-4 py-2 text-sm font-medium text-neutral-900 transition-colors hover:bg-brand-500">
            + Nouvel utilisateur
        </a>
    </div>

    <div class="bg-white rounded-lg border border-neutral-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-neutral-50">
                <tr>
                    <th class="text-left px-4 py-2">Nom</th>
                    <th class="text-left px-4 py-2">E-mail</th>
                    <th class="text-left px-4 py-2">Rôle</th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-100">
                @forelse ($users as $user)
                    <tr>
                        <td class="px-4 py-2">
                            <a href="{{ route('admin.utilisateurs.edit', $user) }}" class="font-medium hover:underline">{{ $user->name }}</a>
                            @if ($user->is(auth()->user()))
                                <span class="ml-1 text-xs text-neutral-400">(vous)</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-neutral-500">{{ $user->email }}</td>
                        <td class="px-4 py-2">
                            <span @class([
                                'inline-block rounded-full px-2 py-0.5 text-xs',
                                'bg-brand-100 text-brand-700' => $user->isAdmin(),
                                'bg-steel-50 text-neutral-600' => ! $user->isAdmin(),
                            ])>{{ $user->role->label() }}</span>
                        </td>
                        <td class="px-4 py-2 text-right">
                            {{-- No delete button on your own row: the controller refuses it anyway,
                                 and offering an action that always fails is worse than hiding it. --}}
                            @unless ($user->is(auth()->user()))
                                <form method="POST" action="{{ route('admin.utilisateurs.destroy', $user) }}"
                                      onsubmit="return confirm('Supprimer le compte de {{ $user->name }} ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-neutral-400 hover:text-clay-600">Supprimer</button>
                                </form>
                            @endunless
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-neutral-400">Aucun utilisateur.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6 rounded-lg border border-neutral-200 bg-white p-5 text-sm">
        <h2 class="admin-page-title mb-3 text-base">Les rôles</h2>
        <dl class="space-y-2 text-neutral-600">
            @foreach ($roles ?? \App\Enums\UserRole::staff() as $role)
                <div>
                    <dt class="inline font-medium text-neutral-900">{{ $role->label() }} —</dt>
                    <dd class="inline">{{ $role->description() }}</dd>
                </div>
            @endforeach
        </dl>
    </div>
@endsection
