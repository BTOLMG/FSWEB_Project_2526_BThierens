@extends('layouts.layoutMain')

@section('extra_imports')
    <link rel="stylesheet" href="{{ asset('files/css/search/search.css') }}">
    <script src="{{ asset('files/js/search.js') }}" defer></script>
@endsection

@section('content')
    <div class="margin-side">
        <div class="search-banner">
            <h1>Hulp in jouw buurt</h1>
            @if ($meta['zoekterm'] == null)
                <p>We vonden {{ $gefilterdeActoren->count() }} resultaten</p>
            @elseif ($gefilterdeActoren->count() > 0)
                <p>We vonden {{ $gefilterdeActoren->count() }} resultaten voor "<strong>{{ $meta['zoekterm'] }}</strong>"</p>
            @else
                <p>We vonden geen resultaten voor "<strong>{{ $meta['zoekterm'] }}</strong>"</p>
            @endif
            <a class="linkToKaartPagina" href="{{route('kaart')}}">Zie deze op een kaart <i class="fa fa-location"></i> </a>
        </div>

        <div class="search-filter-main-divider">
            <div class="filters">
                <form method="GET" action="{{ route('search') }}" id="filter-form">
                    <div class="search-wrapper">
                        <img src="{{ asset('files/img/search-icon.png') }}" alt="Search Icon" class="search-icon">

                        <textarea
                            id="input-box"
                            type="text"
                            name="zoekterm"
                            placeholder="{{ $meta['zoekterm'] ?? 'Geef een zoekterm in' }}"
                        ></textarea>

                        <button type="submit">ZOEKEN</button>
                    </div>

                    @include('components.search.autocomplete')

                    @php
                        $hasFilters = !empty($meta['selectedGemeentes']) || !empty($meta['selectedRubrieken']);
                    @endphp

                    @if ($hasFilters)
                        <div class="active-filters">
                            @foreach ($meta['selectedGemeentes'] as $gemeente)
                                <span class="active-filter-chip">
                                    {{ $gemeente }}
                                    <button
                                        type="button"
                                        class="chip-remove"
                                        onclick="removeFilter('gemeentes[]', '{{ $gemeente }}')"
                                        title="Verwijder filter {{ $gemeente }}"
                                    >x</button>
                                </span>
                            @endforeach
                            @foreach ($meta['selectedRubrieken'] as $rubriek)
                                <span class="active-filter-chip chip-rubriek">
                                    {{ $rubriek }}
                                    <button
                                        type="button"
                                        class="chip-remove"
                                        onclick="removeFilter('rubrieken[]', '{{ $rubriek }}')"
                                        title="Verwijder filter {{ $rubriek }}"
                                    >x</button>
                                </span>
                            @endforeach
                        </div>
                    @endif

                    <div class="filter-header">
                        <span class="filter-title">Resultaten filteren</span>
                        @if ($hasFilters)
                            <a href="{{ route('search', ['zoekterm' => $meta['zoekterm']]) }}" class="filters-clear">
                                Filters wissen
                            </a>
                        @endif
                    </div>

                    {{-- ── Gemeente accordion ── --}}
                    <div class="accordion-panel {{ !empty($meta['selectedGemeentes']) ? 'open' : '' }}">
                        <button type="button" class="accordion-header">
                            <span>Gevestigd in</span>
                            <i class="fa fa-chevron-down accordion-icon"></i>
                        </button>
                        <div class="accordion-body">
                            <div class="accordionItem-scroll">

                                <div class="accordion-search-wrapper">
                                    <i class="fa fa-search accordion-search-icon"></i>
                                    <input
                                        type="text"
                                        class="accordion-search-input"
                                        placeholder="Zoek gemeente of postcode..."
                                        oninput="filterAccordionItems(this, 'gemeente-list', 'gemeente-geen-resultaten')"
                                    >
                                </div>

                                <ul class="accordionItem-list" id="gemeente-list">
                                    @foreach ($gemeenteAccordionItems as $label => $count)
                                        @php $checked = in_array($label, $meta['selectedGemeentes']); @endphp
                                        <li data-zoekterm="{{ strtolower($label) }}">
                                            <label class="accordionItem-item {{ $checked ? 'checked' : '' }}">
                                                <input
                                                    type="checkbox"
                                                    name="gemeentes[]"
                                                    value="{{ $label }}"
                                                    {{ $checked ? 'checked' : '' }}
                                                    onchange="this.form.submit()"
                                                >
                                                <span class="accordionItem-check"></span>
                                                <span class="accordionItem-label">{{ $label }}</span>
                                                <span class="accordionItem-count">{{ $count }}</span>
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>

                                <p class="accordion-geen-resultaten hidden" id="gemeente-geen-resultaten">
                                    Geen overeenkomsten gevonden.
                                </p>

                            </div>
                        </div>
                    </div>

                    {{-- ── Rubriek accordion ── --}}
                    <div class="accordion-panel {{ !empty($meta['selectedRubrieken']) ? 'open' : '' }}">
                        <button type="button" class="accordion-header">
                            <span>Rubrieken</span>
                            <i class="fa fa-chevron-down accordion-icon"></i>
                        </button>
                        <div class="accordion-body">
                            <div class="accordionItem-scroll">

                                <div class="accordion-search-wrapper">
                                    <i class="fa fa-search accordion-search-icon"></i>
                                    <input
                                        type="text"
                                        class="accordion-search-input"
                                        placeholder="Zoek rubriek..."
                                        oninput="filterAccordionItems(this, 'rubriek-list', 'rubriek-geen-resultaten')"
                                    >
                                </div>

                                <ul class="accordionItem-list" id="rubriek-list">
                                    @foreach ($rubriekAccordionItems as $naam => $count)
                                        @php $checked = in_array($naam, $meta['selectedRubrieken']); @endphp
                                        <li data-zoekterm="{{ strtolower($naam) }}">
                                            <label class="accordionItem-item {{ $checked ? 'checked' : '' }}">
                                                <input
                                                    type="checkbox"
                                                    name="rubrieken[]"
                                                    value="{{ $naam }}"
                                                    {{ $checked ? 'checked' : '' }}
                                                    onchange="this.form.submit()"
                                                >
                                                <span class="accordionItem-check"></span>
                                                <span class="accordionItem-label">{{ $naam }}</span>
                                                <span class="accordionItem-count">{{ $count }}</span>
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>

                                <p class="accordion-geen-resultaten hidden" id="rubriek-geen-resultaten">
                                    Geen overeenkomsten gevonden.
                                </p>

                            </div>
                        </div>
                    </div>

                </form>
            </div>

            <div class="main-content">
                @if ($gefilterdeActoren->isEmpty())
                    <div class="no-results">
                        <div class="no-results-icon"><img src="{{ asset('files/img/search-icon.png') }}" alt="Search Icon"></div>
                        <p class="no-results-title">Geen resultaten gevonden</p>
                        <p class="no-results-sub">Probeer een andere zoekterm of pas de filters aan.</p>
                        <a href="{{ route('search') }}" class="no-results-reset">Alle resultaten tonen</a>
                    </div>
                @else
                    @foreach ($gefilterdeActoren as $actor)
                        @php
                            $mail     = $actor->contactgegevens->firstWhere('type', 'mail')?->waarde;
                            $telefoon = $actor->contactgegevens->firstWhere('type', 'telefoonnr')?->waarde;
                            $website  = $actor->contactgegevens->firstWhere('type', 'online')?->waarde;

                            $adres = collect([
                                trim(($actor->straatnaam ?? '') . ' ' . ($actor->huisnummer ?? '') . ' ' . ($actor->busnummer ?? '')) . ', ' .
                                trim(($actor->postcode ?? '') . ' ' . ($actor->gemeente ?? '')),
                            ])->filter()->values()->toArray();

                            $openingstijden = $actor->openingsuren
                                ->map(fn($openingsuur) => ucfirst($openingsuur->dag_van_de_week) . ': ' . Str::substr($openingsuur->startuur, 0, 5) . ' - ' . Str::substr($openingsuur->einduur, 0, 5))
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
                @endif
            </div>
        </div>
    </div>
@endsection
