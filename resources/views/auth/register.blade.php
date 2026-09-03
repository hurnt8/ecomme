@extends('layouts.shop')

@section('title', 'Créer un compte')

@section('content')
    <x-shop.page-hero title="Créer un compte" subtitle="Suivez vos commandes plus facilement" image="img_bg_5.jpg" />

    <div id="fh5co-about">
        <div class="container">
            <div class="row animate-box">
                <div class="col-md-6 col-md-offset-3">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row form-group">
                            <div class="col-md-12">
                                <label for="name">Nom</label>
                                <input id="name" type="text" name="name" value="{{ old('name') }}" class="form-control" required autofocus>
                                @error('name')<span style="color:#c0392b;font-size:12px;">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-12">
                                <label for="email">E-mail</label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control" required>
                                @error('email')<span style="color:#c0392b;font-size:12px;">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-12">
                                <label for="password">Mot de passe</label>
                                <input id="password" type="password" name="password" class="form-control" required>
                                @error('password')<span style="color:#c0392b;font-size:12px;">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-12">
                                <label for="password_confirmation">Confirmer le mot de passe</label>
                                <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <input type="submit" value="Créer mon compte" class="btn btn-primary">
                        </div>
                    </form>

                    <p>Déjà un compte ? <a href="{{ route('login') }}">Se connecter</a></p>
                </div>
            </div>
        </div>
    </div>
@endsection
