@extends('layouts.layoutMain')

@section('extra_imports')
    <link rel="stylesheet" href="{{ asset('files/css/admin/admin.css') }}">
@endsection

@section('content')
    <div class="layout">
        <main class="main">
            <div class="admin-tabs">
                <a href="{{ route('admin.index') }}"
                    class="admin-tab {{ request()->routeIs('admin.index') ? 'active' : '' }}">
                    <i class="fa fa-plus"></i> Nieuwe organisatie
                </a>
                <a href="{{ route('admin.overzicht') }}"
                    class="admin-tab {{ request()->routeIs('admin.overzicht') ? 'active' : '' }}">
                    <i class="fa fa-list"></i> Overzicht
                </a>
            </div>

            <div class="header">
                <h1>Nieuwe organisatie aanmaken</h1>
                <p>Voeg een nieuwe organisatie toe aan de sociale kaart.</p>
            </div>

            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            <form action="{{ route('admin.create_actor') }}" method="POST">
                @csrf
                <div class="form-section">
                    <div class="form-section-label">
                        <h3>Login Gegevens</h3>
                        <p>De beheerder van deze organisatie kan inloggen in met deze gegevens.</br>
                            Het E-mailadres is niet aanpasbaar.</p>
                    </div>
                    <div class="form-section-fields">
                        <div class="field field-full">
                            <label>E-mailadres</label>
                            <input type="email" name="email"
                                placeholder="naam@organisatie.be">
                        </div>
                        <div class="field-row">
                            <div class="field">
                                <label>Wachtwoord</label>
                                <input type="password" name="password" placeholder="Minimaal 8 tekens">
                            </div>
                            <div class="field">
                                <label>Bevestig Wachtwoord</label>
                                <input type="password" name="password_confirmation" placeholder="Herhaal wachtwoord">
                            </div>
                        </div>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="alert alert-error">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-footer">
                    <div class="form-footer-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-plus"></i> Organisatie aanmaken
                        </button>
                    </div>
                </div>
            </form>

            <div class="logout-wrap">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-ghost">
                        <i class="fa fa-arrow-right-from-bracket"></i> Uitloggen
                    </button>
                </form>
            </div>

        </main>
    </div>
@endsection
