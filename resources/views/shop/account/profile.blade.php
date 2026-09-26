@extends('layouts.shop')

@section('title', 'Mein Profil')

@section('content')
    <x-shop.page-hero title="Mein Profil" image="hero-objets.jpg" />

    <div id="fh5co-about">
        <div class="container">
            <div class="row animate-box">
                <div class="col-md-6 col-md-offset-3">
                    <p style="margin-bottom:20px;"><a href="{{ route('account.index') }}">&larr; Zurück zu meinen Bestellungen</a></p>

                    <form method="POST" action="{{ route('account.profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="row form-group">
                            <div class="col-md-12">
                                <label for="name">Name</label>
                                <input id="name" type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="form-control" required>
                                @error('name')<span style="color:var(--shop-accent);font-size:12px;">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-12">
                                <label for="email">E-Mail</label>
                                <input id="email" type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="form-control" required>
                                @error('email')<span style="color:var(--shop-accent);font-size:12px;">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <h3 style="margin-top:30px;">Passwort ändern</h3>
                        <p style="font-size:13px;color:#8f8f8f;">Lassen Sie diese Felder leer, um Ihr aktuelles Passwort beizubehalten.</p>

                        <div class="row form-group">
                            <div class="col-md-12">
                                <label for="current_password">Aktuelles Passwort</label>
                                <input id="current_password" type="password" name="current_password" class="form-control">
                                @error('current_password')<span style="color:var(--shop-accent);font-size:12px;">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-12">
                                <label for="password">Neues Passwort</label>
                                <input id="password" type="password" name="password" class="form-control">
                                @error('password')<span style="color:var(--shop-accent);font-size:12px;">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-12">
                                <label for="password_confirmation">Neues Passwort bestätigen</label>
                                <input id="password_confirmation" type="password" name="password_confirmation" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <input type="submit" value="Speichern" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
