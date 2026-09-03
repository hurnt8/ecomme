@extends('layouts.shop')

@section('title', 'Connexion')

@section('content')
    <x-shop.page-hero title="Connexion" subtitle="Accédez à votre compte" />

    <div id="fh5co-about">
        <div class="container">
            <div class="row animate-box">
                <div class="col-md-6 col-md-offset-3">
                    @if ($errors->any())
                        <p style="color:#c0392b;">{{ $errors->first() }}</p>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row form-group">
                            <div class="col-md-12">
                                <label for="email">E-mail</label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-12">
                                <label for="password">Mot de passe</label>
                                <input id="password" type="password" name="password" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <input type="submit" value="Se connecter" class="btn btn-primary">
                        </div>
                    </form>

                    <p><a href="{{ route('password.request') }}">Mot de passe oublié ?</a></p>
                    <p>Pas encore de compte ? <a href="{{ route('register') }}">Créer un compte</a></p>
                </div>
            </div>
        </div>
    </div>
@endsection
