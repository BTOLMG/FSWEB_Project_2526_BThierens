@extends('layouts.layoutMain')

@section('extra_imports')
    <link rel="stylesheet" href="{{ asset('files/css/search/search.css') }}">
    <script src="{{ asset('files/js/search.js') }}" defer></script>
    <script src="{{ asset('files/js/favorites.js') }}" defer></script>
@endsection

@section('content')
    <div class="margin-side">
        <div class="search-banner">
            <h1>Hulp in jouw buurt</h1>
            @if ($meta['zoekterm'] !== null && $actoren->count() > 0)
                <p>We vonden {{ $actoren->count() }} resultaten voor "{{ $meta['zoekterm'] }}"</p>
            @elseif ($actoren->count() == 0)
                <p>We vonden geen resultaten voor "{{ $meta['zoekterm'] }}"</p>
            @endif
        </div>

        <div class="search-filter-main-divider">
            <div class="filters">hier komen allemaal gekke filters</div>

            <div class="main-content">
                @foreach ($actoren as $actor)
                    @php
                        $mail     = $actor->contactgegevens->firstWhere('type', 'mail')?->waarde;
                        $telefoon = $actor->contactgegevens->firstWhere('type', 'telefoonnr')?->waarde;
                        $website  = $actor->contactgegevens->firstWhere('type', 'online')?->waarde;

                        $adres = collect([
                            trim(($actor->straatnaam ?? '') . ' ' . ($actor->huisnummer ?? '') . ' ' . ($actor->busnummer ?? '')) . ', ' .
                            trim(($actor->postcode ?? '') . ' ' . ($actor->gemeente ?? '')),
                        ])->filter()->values()->toArray();

                        $openingstijden = $actor->openingsuren
                            ->map(fn($u) => ucfirst($u->dag_van_de_week) . ': ' . Str::substr($u->startuur, 0, 5) . ' - ' . Str::substr($u->einduur, 0, 5))
                            ->join(', ');

                        $extraInfoList = $actor->rubrieken->pluck('naam')->toArray();
                    @endphp

                    <x-search.card
                        :thema="$actor->categorie->naam"
                        afstand=""
                        :title="$actor->publieke_naam"
                        :beschrijving="$actor->aangeboden_diensten ?? ''"
                        :openingstijden="$openingstijden"
                        :extraInfoList="$extraInfoList"
                        :adressen="$adres"
                        :mail="$mail ?? ''"
                        :telefoon="$telefoon ?? ''"
                        :website="$website ?? ''"
                        :link="'#'"
                        :isVerified="false"
                        :isOrganisatie="true"
                        :actorId="$actor->id"
                    />
                @endforeach
            </div>
        </div>
    </div>
@endsection
