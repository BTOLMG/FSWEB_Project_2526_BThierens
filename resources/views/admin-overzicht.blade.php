@extends('layouts.layoutMain')

@section('extra_imports')
    <link rel="stylesheet" href="{{ asset('files/css/admin/admin.css') }}">
    <script src="{{ asset('files/js/admin.js') }}" defer></script>
@endsection

@section('content')
<div class="layout">
    <main class="main">
        <div class="admin-tabs">
            <a href="{{ route('admin.index') }}"
               class="admin-tab {{ request()->routeIs('admin.index') ? 'active' : '' }}">
                <i class="fa fa-plus"></i> Nieuwe actor
            </a>
            <a href="{{ route('admin.overzicht') }}"
               class="admin-tab {{ request()->routeIs('admin.overzicht') ? 'active' : '' }}">
                <i class="fa fa-list"></i> Overzicht
            </a>
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
                        <i class="fa fa-building"></i> Actoren
                    </h2>
                    <p class="overzicht-blok-sub">{{ count($actoren) }} actoren in de database</p>
                </div>
                <div class="overzicht-search-wrap">
                    <i class="fa fa-search overzicht-search-icon"></i>
                    <input
                        type="text"
                        class="overzicht-search"
                        placeholder="Zoek op naam, gemeente of categorie…"
                        oninput="filterLijst(this, 'actor-lijst', 'actor-geen')"
                    >
                </div>
            </div>

            <p class="overzicht-geen hidden" id="actor-geen">
                Geen actoren gevonden voor deze zoekterm.
            </p>

            <ul class="overzicht-lijst" id="actor-lijst">
                @forelse ($actoren as $actor)
                    <li class="overzicht-item"
                        data-zoekterm="{{ strtolower($actor['naam'] . ' ' . $actor['gemeente'] . ' ' . $actor['categorie'] . ' ' . $actor['beheerder']) }}">

                        <div class="overzicht-item-info">
                            <div class="overzicht-item-naam">
                                {{ $actor['naam'] }}
                                @if (!$actor['isVisible'])
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
                                <span><i class="fa fa-tag"></i> {{ $actor['categorie'] }}</span>
                                <span><i class="fa fa-location-dot"></i> {{ $actor['gemeente'] }}</span>
                                @if ($actor['beheerder'])
                                    <span><i class="fa fa-user"></i> {{ $actor['beheerder'] }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="overzicht-item-acties">
                            <a href="{{ route('details', $actor['id']) }}"
                               class="overzicht-btn-view" target="_blank" title="Bekijk detailpagina">
                                <i class="fa fa-arrow-up-right-from-square"></i>
                            </a>
                            <form action="{{ route('admin.actor.destroy', $actor['id']) }}"
                                  method="POST"
                                  onsubmit="return bevestigVerwijder({{ $actor['naam'] }})">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="overzicht-btn-delete" title="Verwijder actor">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </li>
                @empty
                    <li class="overzicht-leeg">Nog geen actoren in de database.</li>
                @endforelse
            </ul>
        </div>

        <div class="overzicht-blok">
            <div class="overzicht-blok-header">
                <div>
                    <h2 class="overzicht-blok-titel">
                        <i class="fa fa-users"></i> Organisaties
                    </h2>
                    <p class="overzicht-blok-sub">{{ count($users) }} organisaties accounts</p>
                </div>
                <div class="overzicht-search-wrap">
                    <i class="fa fa-search overzicht-search-icon"></i>
                    <input
                        type="text"
                        class="overzicht-search"
                        placeholder="Zoek op e-mail of organisatie"
                        oninput="filterLijst(this, 'user-lijst', 'user-geen')"
                    >
                </div>
            </div>

            <p class="overzicht-geen hidden" id="user-geen">
                Geen organisaties gevonden voor deze zoekterm.
            </p>

            <ul class="overzicht-lijst" id="user-lijst">
                @forelse ($users as $user)
                    <li class="overzicht-item"
                        data-zoekterm="{{ strtolower($user['email'] . ' ' . $user['actoren']) }}">

                        <div class="overzicht-item-info">
                            <div class="overzicht-item-naam">
                                {{ $user['email'] }}
                                <span class="overzicht-badge {{ $user['rol'] === 'actorbeheerder' ? 'badge-beheerder' : 'badge-default' }}">
                                    {{ $user['rol'] }}
                                </span>
                            </div>
                            <div class="overzicht-item-meta">
                                <span><i class="fa fa-building"></i> {{ $user['actoren'] }}</span>
                            </div>
                        </div>

                        <div class="overzicht-item-acties">
                            <form action="{{ route('admin.user.destroy', $user['id']) }}"
                                  method="POST"
                                  onsubmit="return bevestigVerwijder('{{ $user['email'] }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="overzicht-btn-delete" title="Verwijder gebruiker">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </li>
                @empty
                    <li class="overzicht-leeg">Nog geen organisaties in de database.</li>
                @endforelse
            </ul>
        </div>

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
