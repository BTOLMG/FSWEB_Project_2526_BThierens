@extends('layouts.layoutMain')

@section('extra_imports')
    <link rel="stylesheet" href="{{ asset('files/css/details/details.css') }}">
    <script src="{{ asset('files/js/favorites.js') }}" defer></script>
@endsection

@section('content')
    <div class="banner">
        <div class="spacer-from-side">
            <span class="details-categorie-badge">
                <i class="fa fa-tag"></i>
                {{ $actor->categorie->naam }}
            </span>
            <div class="banner-title-row">
                <h1>{{ $actor->publieke_naam }} en {{ $actor->id }}</h1>
                <button
                    class="favoriet-button"
                    title={isFavoriet ? 'Verwijder uit favorieten' : 'Toevoegen aan favorieten'}
                    type="button"
                    data-id="{{ $actor->id }}"
                    onclick="toggleFavoriet(this)"
                >
                    <i class="fa fa-heart"></i>
                </button>
            </div>
            <hr class="small-yellow-line">
            @if ($actor->aangeboden_diensten)
                <p class="details-hero-omschrijving">{{ $actor->aangeboden_diensten }}</p>
            @endif
            <div class="details-hero-adres">
                <i class="fa fa-map-marker-alt"></i>
                {{ $actor->straatnaam ?? '' }}
                {{ $actor->huisnummer ?? '' }}{{ $actor->busnummer ? ' bus ' . $actor->busnummer : '' }},
                {{ $actor->postcode ?? '' }} {{ $actor->gemeente ?? '' }}
            </div>
        </div>
    </div>

    <div class="details-body spacer-from-side">

        <div class="details-card card-contact">
            <h2>Contactgegevens</h2>
            <hr class="small-yellow-line">
            @forelse ($actor->contactgegevens as $contact)
                <div class="contact-item">
                    <span class="contact-icon">
                        @if ($contact->type === 'telefoonnr')
                            <i class="fa fa-phone"></i>
                        @elseif ($contact->type === 'mail')
                            <i class="fa fa-envelope"></i>
                        @elseif ($contact->type === 'online')
                            <i class="fa fa-globe"></i>
                        @else
                            <i class="fa fa-info-circle"></i>
                        @endif
                    </span>
                    <div class="contact-content">
                        <span class="contact-label">
                            @if ($contact->type === 'telefoonnr')
                                Telefoon
                            @elseif ($contact->type === 'mail')
                                E-mail
                            @elseif ($contact->type === 'online')
                                Website
                            @else
                                {{ ucfirst($contact->type) }}
                            @endif
                        </span>
                        <a class="contact-waarde"
                            href="
                        @if ($contact->type === 'mail') mailto:{{ $contact->waarde }}
                        @elseif($contact->type === 'online')     {{ $contact->waarde }}
                        @elseif($contact->type === 'telefoonnr') tel:{{ $contact->waarde }}
                        @else # @endif
                    "
                            @if ($contact->type === 'online') target="_blank" rel="noopener" @endif>
                            {{ $contact->waarde }}
                        </a>
                    </div>
                </div>
            @empty
                <p class="details-empty"><i class="fa fa-info-circle"></i> Geen contactgegevens beschikbaar.</p>
            @endforelse
        </div>

        <div class="details-card card-betaal">
            <h2>Betaalwijze</h2>
            <hr class="small-yellow-line">
            @if ($actor->betaalwijze)
                @php
                    $betaalIcon = match ($actor->betaalwijze) {
                        'gratis' => 'fa-gift',
                        'sociaal tarief' => 'fa-hand-holding-heart',
                        'online betaling' => 'fa-credit-card',
                        default => 'fa-coins',
                    };
                @endphp
                <div class="betaal-badge">
                    <i class="fa {{ $betaalIcon }}"></i>
                    {{ ucfirst($actor->betaalwijze) }}
                </div>
            @else
                <p class="details-empty"><i class="fa fa-info-circle"></i> Niet opgegeven.</p>
            @endif
        </div>

        <div class="details-card card-uren">
            <h2>Openingsuren</h2>
            <hr class="small-yellow-line">
            @if ($actor->openingsuren->isNotEmpty())
                <div class="uren-lijst">
                    @foreach (['maandag', 'dinsdag', 'woensdag', 'donderdag', 'vrijdag', 'zaterdag', 'zondag'] as $dag)
                        @php
                            $uur = $actor->openingsuren->firstWhere('dag_van_de_week', $dag);
                            $isOpen = $uur && !$uur->gesloten;
                        @endphp
                        <div class="uur-rij {{ $isOpen ? '' : 'uur-gesloten' }}">
                            <span class="uur-dag">{{ ucfirst($dag) }}</span>
                            <span class="uur-tijd">
                                @if ($isOpen)
                                    <i class="fa fa-clock"></i>
                                    {{ substr($uur->startuur, 0, 5) }} - {{ substr($uur->einduur, 0, 5) }}
                                @else
                                    <i class="fa fa-times"></i>
                                    Gesloten
                                @endif
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="details-empty"><i class="fa fa-info-circle"></i> Geen openingsuren opgegeven.</p>
            @endif
        </div>

        <div class="details-card card-locatie">
            <h2>Locatie</h2>
            <hr class="small-yellow-line">
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label"><i class="fa fa-road"></i> Straat</span>
                    <span class="info-value">
                        {{ $actor->straatnaam ?? '—' }}
                        {{ $actor->huisnummer ?? '' }}
                        {{ $actor->busnummer ? 'bus ' . $actor->busnummer : '' }}
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label"><i class="fa fa-map-pin"></i> Postcode</span>
                    <span class="info-value">{{ $actor->postcode ?? '—' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label"><i class="fa fa-city"></i> Gemeente</span>
                    <span class="info-value">{{ $actor->gemeente ?? '—' }}</span>
                </div>
            </div>
        </div>

        <div class="details-card card-doelgroep">
            <h2>Doelgroep</h2>
            <hr class="small-yellow-line">
            <div class="info-grid">
                @if ($actor->leeftijdscategorie)
                    <div class="info-item">
                        <span class="info-label"><i class="fa fa-users"></i> Categorie</span>
                        <span class="info-value">{{ ucfirst($actor->leeftijdscategorie) }}</span>
                    </div>
                @endif
                @if (!is_null($actor->leeftijd_min) || !is_null($actor->leeftijd_max))
                    <div class="info-item">
                        <span class="info-label"><i class="fa fa-child"></i> Leeftijd</span>
                        <span class="info-value">
                            @if (!is_null($actor->leeftijd_min) && !is_null($actor->leeftijd_max))
                                {{ $actor->leeftijd_min }} – {{ $actor->leeftijd_max }} jaar
                            @elseif (!is_null($actor->leeftijd_min))
                                Vanaf {{ $actor->leeftijd_min }} jaar
                            @else
                                Tot {{ $actor->leeftijd_max }} jaar
                            @endif
                        </span>
                    </div>
                @endif
                @if (!$actor->leeftijdscategorie && is_null($actor->leeftijd_min) && is_null($actor->leeftijd_max))
                    <p class="details-empty"><i class="fa fa-info-circle"></i> Niet opgegeven.</p>
                @endif
            </div>
        </div>

        @if ($actor->rubrieken->isNotEmpty())
            <div class="details-card card-rubrieken">
                <h2>Rubrieken</h2>
                <hr class="small-yellow-line">
                <div class="rubriek-tags">
                    @foreach ($actor->rubrieken as $rubriek)
                        <span class="rubriek-tag">
                            <i class="fa fa-bookmark"></i>
                            {{ $rubriek->naam }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection
