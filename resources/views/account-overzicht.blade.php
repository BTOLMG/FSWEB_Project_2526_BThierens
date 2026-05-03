@extends('layouts.layoutMain')

@section('extra_imports')
    <link rel="stylesheet" href="{{ asset('files/css/account/account.css') }}">
    <script src="{{ asset('files/js/account.js') }}" defer></script>
@endsection

@section('content')
<div class="beheer-layout">
    <main class="beheer-main">

        <div class="beheer-header">
            <h1>Mijn Actoren</h1>
            <p>Kies een organisatie om de gegevens te bekijken en bij te werken.</p>
        </div>

        @if (session('status'))
            <div class="alert alert-success">
                <i class="fa fa-circle-check"></i> {{ session('status') }}
            </div>
        @endif

        <div class="overzicht-blok">
            <div class="overzicht-blok-header">
                <div>
                    <h2 class="overzicht-blok-titel">
                        <i class="fa fa-building"></i> Mijn organisaties
                    </h2>
                    <p class="overzicht-blok-sub">
                        {{ $actoren->count() }} {{ $actoren->count() === 1 ? 'organisatie' : 'organisaties' }} gekoppeld aan jouw account
                    </p>
                </div>
                @if ($actoren->count() > 4)
                    <div class="overzicht-search-wrap">
                        <i class="fa fa-search overzicht-search-icon"></i>
                        <input
                            type="text"
                            class="overzicht-search"
                            placeholder="Zoek op naam of gemeente…"
                            oninput="filterLijst(this, 'actor-lijst', 'actor-geen')"
                            autocomplete="off"
                        >
                    </div>
                @endif
            </div>

            <p class="overzicht-geen hidden" id="actor-geen">
                Geen actoren gevonden voor deze zoekterm.
            </p>

            <ul class="overzicht-lijst" id="actor-lijst">
                @forelse ($actoren as $actor)
                    <li class="overzicht-item"
                        data-zoekterm="{{ strtolower($actor->publieke_naam . ' ' . ($actor->gemeente ?? '') . ' ' . ($actor->categorie->naam ?? '')) }}">

                        <div class="overzicht-item-info">
                            <div class="overzicht-item-naam">
                                {{ $actor->publieke_naam }}
                                @if (!$actor->isVisible)
                                    <span class="overzicht-badge badge-verborgen">
                                        <i class="fa fa-eye-slash"></i> verborgen
                                    </span>
                                @else
                                    <span class="overzicht-badge badge-zichtbaar">
                                        <i class="fa fa-eye"></i> zichtbaar
                                    </span>
                                @endif
                            </div>
                            <div class="overzicht-item-meta">
                                @if ($actor->categorie)
                                    <span><i class="fa fa-tag"></i> {{ $actor->categorie->naam }}</span>
                                @endif
                                @if ($actor->gemeente)
                                    <span><i class="fa fa-location-dot"></i> {{ $actor->gemeente }}</span>
                                @endif
                                @if ($actor->last_updated)
                                    <span><i class="fa fa-clock"></i> Bijgewerkt op {{ \Carbon\Carbon::parse($actor->last_updated)->format('d/m/Y') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="overzicht-item-acties">
                            <a href="{{ route('details', $actor->id) }}"
                               class="overzicht-btn-view" target="_blank" title="Bekijk detailpagina">
                                <i class="fa fa-arrow-up-right-from-square"></i>
                            </a>
                            <a href="{{ route('account.edit', $actor->id) }}"
                               class="overzicht-btn-edit" title="Gegevens bewerken">
                                <i class="fa fa-pen"></i>
                            </a>
                            <form action="{{ route('account.actor.destroy', $actor->id) }}" method="POST" onsubmit="return confirm('Weet je zeker dat je deze actor wil verwijderen?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="overzicht-btn-delete" title="Verwijderen">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </li>
                @empty
                    <li class="overzicht-leeg">
                        Er zijn nog geen organisaties aan jouw account gekoppeld. Neem contact op met de administrator.
                    </li>
                @endforelse
            </ul>
        </div>

        <form action="{{ route('account.create_actor') }}" method="POST">
            @csrf
            <div class="form-section">
                <div class="form-section-label">
                    <h3>Hoofd Gegevens</h3>
                    <p>De belangrijkste informatie van de actor. De categorie is niet aanpasbaar</p>
                </div>
                <div class="form-section-fields">
                    <div class="field field-full">
                        <label>Publieke naam</label>
                        <input type="text" name="publieke_naam"
                            placeholder="Naam actor">
                    </div>
                    <div class="field field-full">
                        <label>Categorie</label>
                        <select name="categorie_id">
                            @foreach($categorieen as $categorie)
                                <option value="{{ $categorie->id }}">{{ $categorie->naam }}</option>
                            @endforeach
                        </select>
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
                        <i class="fa fa-plus"></i> Actor aanmaken
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
