@extends('layouts.guest')

@section('title', 'Connexion administrateur')

@section('content')
    <div class="bg-white rounded-lg shadow-sm border border-neutral-200 p-8">
        <h1 class="text-lg font-semibold text-neutral-900 mb-1">Atelier Maison</h1>
        <p class="text-sm text-neutral-500 mb-6">Espace administrateur</p>

        @if ($errors->any())
            <div class="mb-4 rounded-md bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-neutral-700 mb-1">E-mail</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full rounded-md border border-neutral-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-neutral-800">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-neutral-700 mb-1">Mot de passe</label>
                <input id="password" type="password" name="password" required
                       class="w-full rounded-md border border-neutral-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-neutral-800">
            </div>

            <button type="submit"
                    class="w-full rounded-md bg-neutral-900 text-white text-sm font-medium py-2 hover:bg-neutral-800 transition-colors">
                Se connecter
            </button>
        </form>
    </div>
@endsection
