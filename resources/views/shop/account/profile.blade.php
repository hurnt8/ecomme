@extends('layouts.shop')

@section('title', 'Mon profil')

@section('content')
    <x-shop.page-hero title="Mon profil" image="hero-objets.jpg" />

    <div id="fh5co-about">
        <div class="container">
            <div class="row animate-box">
                <div class="col-md-6 col-md-offset-3">
                    <p style="margin-bottom:20px;"><a href="{{ route('account.index') }}">&larr; Retour à mes commandes</a></p>

                    <form method="POST" action="{{ route('account.profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="row form-group">
                            <div class="col-md-12">
                                <label for="name">Nom</label>
                                <input id="name" type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="form-control" required>
                                @error('name')<span style="color:#c0392b;font-size:12px;">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-12">
                                <label for="email">E-mail</label>
                                <input id="email" type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="form-control" required>
                                @error('email')<span style="color:#c0392b;font-size:12px;">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <h3 style="margin-top:30px;">Changer de mot de passe</h3>
                        <p style="font-size:13px;color:#8f8f8f;">Laissez ces champs vides pour conserver votre mot de passe actuel.</p>

                        <div class="row form-group">
                            <div class="col-md-12">
                                <label for="current_password">Mot de passe actuel</label>
                                <input id="current_password" type="password" name="current_password" class="form-control">
                                @error('current_password')<span style="color:#c0392b;font-size:12px;">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-12">
                                <label for="password">Nouveau mot de passe</label>
                                <input id="password" type="password" name="password" class="form-control">
                                @error('password')<span style="color:#c0392b;font-size:12px;">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-12">
                                <label for="password_confirmation">Confirmer le nouveau mot de passe</label>
                                <input id="password_confirmation" type="password" name="password_confirmation" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <input type="submit" value="Enregistrer" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
