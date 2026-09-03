@extends('layouts.shop')

@section('title', 'Mot de passe oublié')

@section('content')
    <x-shop.page-hero title="Mot de passe oublié" subtitle="Recevez un lien de réinitialisation par e-mail" image="img_bg_1.jpg" />

    <div id="fh5co-about">
        <div class="container">
            <div class="row animate-box">
                <div class="col-md-6 col-md-offset-3">
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="row form-group">
                            <div class="col-md-12">
                                <label for="email">E-mail</label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus>
                                @error('email')<span style="color:#c0392b;font-size:12px;">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <input type="submit" value="Envoyer le lien de réinitialisation" class="btn btn-primary">
                        </div>
                    </form>

                    <p><a href="{{ route('login') }}">&larr; Retour à la connexion</a></p>
                </div>
            </div>
        </div>
    </div>
@endsection
