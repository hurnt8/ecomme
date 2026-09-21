@extends('layouts.shop')

@section('title', 'Réinitialiser le mot de passe')

@section('content')
    <x-shop.page-hero title="Nouveau mot de passe" image="hero-objets.jpg" />

    <div id="fh5co-about">
        <div class="container">
            <div class="row animate-box">
                <div class="col-md-6 col-md-offset-3">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="row form-group">
                            <div class="col-md-12">
                                <label for="email">E-mail</label>
                                <input id="email" type="email" name="email" value="{{ old('email', $email) }}" class="form-control" required autofocus>
                                @error('email')<span style="color:var(--shop-accent);font-size:12px;">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-12">
                                <label for="password">Nouveau mot de passe</label>
                                <input id="password" type="password" name="password" class="form-control" required>
                                @error('password')<span style="color:var(--shop-accent);font-size:12px;">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-12">
                                <label for="password_confirmation">Confirmer le mot de passe</label>
                                <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <input type="submit" value="Réinitialiser le mot de passe" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
