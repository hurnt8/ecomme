@extends('layouts.shop')

@section('title', 'Anmelden')

@section('content')
    <x-shop.page-hero title="Connexion" subtitle="Accédez à votre compte" image="hero-objets.jpg" />

    <div id="fh5co-about">
        <div class="container">
            <div class="row animate-box">
                <div class="col-md-6 col-md-offset-3">
                    @if ($errors->any())
                        <p style="color:var(--shop-accent);">{{ $errors->first() }}</p>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row form-group">
                            <div class="col-md-12">
                                <label for="email">E-Mail</label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-12">
                                <label for="password">Passwort</label>
                                <input id="password" type="password" name="password" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <input type="submit" value="Anmelden" class="btn btn-primary">
                        </div>
                    </form>

                    <p><a href="{{ route('password.request') }}">Passwort vergessen?</a></p>
                    <p>Noch kein Konto? <a href="{{ route('register') }}">Konto erstellen</a></p>
                </div>
            </div>
        </div>
    </div>
@endsection
