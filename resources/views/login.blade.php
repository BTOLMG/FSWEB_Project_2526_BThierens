@extends('layouts.layoutMain')

@section('extra_imports')
    <link rel="stylesheet" href="{{ asset('files/css/login/login.css') }}">
@endsection

@section('content')
    <div class="login-inner">
        <div class="login-hero">
            <h1>Welkom<br>terug.</h1>
            <p>Beheer de wegwijzer voor jongeren in Vlaanderen.<br>
               Log in op je organisatie-account of admin-portaal.</p>
        </div>

        <div class="login-card">
            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                <div class="login-field">
                    <label for="email">Email</label>
                    <div class="input-wrap">
                        <input type="email" id="email" name="email"
                               placeholder="naam@organisatie.be"
                               value="{{ old('email') }}" required>
                        <i class="fa-regular fa-envelope input-icon"></i>
                    </div>
                </div>

                <div class="login-field">
                    <div class="login-field-row">
                        <label for="password">Wachtwoord</label>
                    </div>
                    <div class="input-wrap">
                        <input type="password" id="password" name="password"
                               placeholder="•••••••" required>
                        <i class="fa fa-lock input-icon"></i>
                    </div>
                </div>

                <button type="submit" class="btn-login">INLOGGEN</button>

                @if ($errors->any())
                    <div class="login-error">
                        {{ $errors->first() }}
                    </div>
                @endif
            </form>

            <hr class="login-divider">

            <p class="login-signup">
                Nog geen account voor je werking?
                <a href="{{ route('contact') }}">Nieuwe organisatie aanvragen?</a>
            </p>
        </div>
    </div>
@endsection
