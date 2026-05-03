@extends('layouts.layoutMain')

@section('extra_imports')
    <link rel="stylesheet" href="{{ asset('files/css/account/account.css') }}">
    <script src="{{ asset('files/js/account.js') }}" defer></script>
@endsection

@section('content')
    <div class="beheer-layout">

        <main class="beheer-main">

            <div class="beheer-header">
                <h1>Mijn Gegevens Bijwerken</h1>
                <p>Zorg ervoor dat jongeren en partners altijd over de meest actuele informatie beschikken.</p>
            </div>

            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('account.update', $actor) }}" method="POST">
                @csrf

                <div class="form-section">
                    <div class="form-section-label">
                        <h3>Organisatie Profiel</h3>
                        <p>Deze gegevens vormen de kern van je zichtbaarheid op de kaart.</p>
                    </div>
                    <div class="form-section-fields">
                        <div class="field field-full">
                            <label>Organisatienaam</label>
                            <input type="text" name="publieke_naam"
                                value="{{ old('publieke_naam', $actor->publieke_naam) }}">
                        </div>
                        <div class="field-row">
                            <div class="field">
                                <label>Telefoon</label>
                                <input type="text" name="telefoonnr" placeholder="bijv. 02 123 45 67"
                                    value="{{ old('telefoonnr', optional($actor->contactgegevens->where('type', 'telefoonnr')->first())->waarde) }}">
                            </div>
                            <div class="field">
                                <label>Email</label>
                                <input type="email" name="mail" placeholder="info@organisatie.be"
                                    value="{{ old('mail', optional($actor->contactgegevens->where('type', 'mail')->first())->waarde) }}">
                            </div>
                        </div>
                        <div class="field field-full">
                            <label>Website</label>
                            <div class="input-prefix-wrap">
                                <i class="fa fa-link"></i>
                                <input type="url" name="website" placeholder="https://www.uworganisatie.be"
                                    value="{{ old('website', optional($actor->contactgegevens->where('type', 'online')->first())->waarde) }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <div class="form-section-label">
                        <h3>Hoofdlocatie</h3>
                        <p>Geef het adres op waar iedereen fysiek terecht kunnen.</p>
                    </div>
                    <div class="form-section-fields">
                        <div class="field-row field-row-address">
                            <div class="field field-grow">
                                <label>Straatnaam</label>
                                <input type="text" name="straatnaam" id="straatnaam" placeholder="bijv. Kerkstraat"
                                    value="{{ old('straatnaam', $actor->straatnaam) }}">
                            </div>
                            <div class="field field-narrow">
                                <label>Nummer</label>
                                <input type="text" name="huisnummer" id="huisnummer" placeholder="12"
                                    value="{{ old('huisnummer', $actor->huisnummer) }}">
                            </div>
                            <div class="field field-narrow">
                                <label>Bus</label>
                                <input type="text" name="busnummer" id="busnummer" placeholder="A"
                                    value="{{ old('busnummer', $actor->busnummer) }}">
                            </div>
                        </div>

                        <div class="field-row field-row-narrow">
                            <div class="field">
                                <label>Postcode</label>
                                <input type="text" name="postcode" id="postcode"
                                    value="{{ old('postcode', $actor->postcode) }}">
                            </div>
                            <div class="field field-grow">
                                <label>Stad / Gemeente</label>
                                <input type="text" name="gemeente" id="gemeente"
                                    value="{{ old('gemeente', $actor->gemeente) }}">
                            </div>
                        </div>

                        <div class="field-row">
                            <div class="field">
                                <label>Breedtegraad (lat)</label>
                                <input type="text" name="lat" id="lat" placeholder="bijv. 50.8503"
                                    value="{{ old('lat', $actor->lat) }}">
                            </div>
                            <div class="field">
                                <label>Lengtegraad (lon)</label>
                                <input type="text" name="lon" id="lon" placeholder="bijv. 4.3517"
                                    value="{{ old('lon', $actor->lon) }}">
                            </div>
                        </div>
                        <div class="geo-action-row">
                            <button type="button" id="geocode-btn" class="btn btn-geo">
                                <i class="fa fa-map-marker-alt"></i>
                                Coördinaten automatisch ophalen
                            </button>
                            <span id="geo-status" class="geo-status"></span>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <div class="form-section-label">
                        <h3>Doelgroep</h3>
                        <p>Voor welke leeftijdsgroep is dit aanbod bedoeld?</p>
                    </div>
                    <div class="form-section-fields">
                        <div class="field field-full">
                            <label>Leeftijdscategorie</label>
                            <select name="leeftijdscategorie">
                                <option value="">— Selecteer een categorie —</option>
                                @foreach ([
            'kinderen' => 'kinderen',
            'jongeren' => 'jongeren',
            'jongvolwassenen' => 'jongvolwassenen',
            'volwassenen' => 'volwassenen',
            'ouderen' => 'ouderen',
        ] as $val => $label)
                                    <option value="{{ $val }}"
                                        {{ old('leeftijdscategorie', $actor->leeftijdscategorie) === $val ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="field-row field-row-ages">
                            <div class="field">
                                <label>Minimumleeftijd</label>
                                <div class="input-unit-wrap">
                                    <input type="number" name="leeftijd_min" min="0" max="99"
                                        placeholder="0" value="{{ old('leeftijd_min', $actor->leeftijd_min) }}">
                                    <span class="input-unit">jaar</span>
                                </div>
                            </div>
                            <div class="field">
                                <label>Maximumleeftijd</label>
                                <div class="input-unit-wrap">
                                    <input type="number" name="leeftijd_max" min="0" max="99"
                                        placeholder="99" value="{{ old('leeftijd_max', $actor->leeftijd_max) }}">
                                    <span class="input-unit">jaar</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <div class="form-section-label">
                        <h3>Rubrieken</h3>
                        <p>Selecteer de rubrieken die van toepassing zijn op jullie organisatie.</p>
                    </div>
                    <div class="form-section-fields">

                        <div class="rubriek-chips" id="rubriek-chips">
                            @foreach ($alleRubrieken as $rubriek)
                                @if (in_array($rubriek->id, $gekoppeldeIds))
                                    <span class="rubriek-chip" data-id="{{ $rubriek->id }}">
                                        {{ $rubriek->naam }}
                                        <button type="button" onclick="verwijderRubriek('{{ $rubriek->id }}')">
                                            <i class="fa fa-xmark"></i>
                                        </button>
                                    </span>
                                @endif
                            @endforeach
                        </div>

                        <div class="rubriek-dropdown-wrap" id="rubriek-dropdown-wrap">
                            <button type="button" class="rubriek-dropdown-trigger" id="rubriek-trigger"
                                onclick="toggleRubriekDropdown()">
                                <i class="fa fa-tag"></i>
                                <span id="rubriek-trigger-label">Rubriek toevoegen…</span>
                                <i class="fa fa-chevron-down" id="rubriek-chevron"></i>
                            </button>

                            <div class="rubriek-dropdown" id="rubriek-dropdown">
                                <div class="rubriek-zoek-wrap">
                                    <i class="fa fa-search"></i>
                                    <input type="text" id="rubriek-zoek" placeholder="Zoek rubriek…"
                                        oninput="filterRubrieken(this.value)" autocomplete="off">
                                </div>
                                <ul class="rubriek-lijst" id="rubriek-lijst">
                                    @foreach ($alleRubrieken as $rubriek)
                                        <li class="rubriek-option {{ in_array($rubriek->id, $gekoppeldeIds) ? 'selected' : '' }}"
                                            data-id="{{ $rubriek->id }}"
                                            onclick="toggleRubriek('{{ $rubriek->id }}', '{{ $rubriek->naam }}')">
                                            <span class="rubriek-option-check"><i class="fa fa-check"></i></span>
                                            <span class="rubriek-option-naam">
                                                {{ str_repeat('- ', $rubriek->level - 1) }}{{ $rubriek->naam }}
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                                <p class="rubriek-geen" id="rubriek-geen" style="display:none">Geen overeenkomsten.</p>
                            </div>
                        </div>

                        <div id="rubriek-inputs">
                            @foreach ($alleRubrieken as $rubriek)
                                <input type="checkbox" name="rubrieken[]" value="{{ $rubriek->id }}"
                                    id="rubriek-input-{{ $rubriek->id }}"
                                    {{ in_array($rubriek->id, $gekoppeldeIds) ? 'checked' : '' }} style="display:none">
                            @endforeach
                        </div>

                    </div>
                </div>

                <div class="form-section">
                    <div class="form-section-label">
                        <h3>Aangeboden Diensten</h3>
                        <p>Beschrijf welke diensten of activiteiten je organisatie aanbiedt.</p>
                    </div>
                    <div class="form-section-fields">
                        <div class="field field-full">
                            <label>Diensten</label>
                            <textarea name="aangeboden_diensten" rows="4"
                                placeholder="bijv. Huiswerkbegeleiding, sportactiviteiten, creatieve workshops …">{{ old('aangeboden_diensten', $actor->aangeboden_diensten) }}</textarea>
                            <span class="field-hint">Scheiden met komma's of elke dienst op een nieuwe regel.</span>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <div class="form-section-label">
                        <h3>Betaalwijze</h3>
                        <p>Hoe wordt deelname betaald of gefinancierd?</p>
                    </div>
                    <div class="form-section-fields">
                        <div class="form-section-fields">
                            <div class="radio-group">
                                @foreach ([
            'gratis' => 'Gratis',
            'sociaal tarief' => 'Sociaal tarief',
            'online betaling' => 'Online betaling',
        ] as $val => $label)
                                    <label class="radio-option">
                                        <input type="radio" name="betaalwijze" value="{{ $val }}"
                                            {{ old('betaalwijze', $actor->betaalwijze) === $val ? 'checked' : '' }}>
                                        <span class="radio-circle"></span>
                                        <span class="radio-label">{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>

                            <button type="button" class="btn btn-secondary" style="align-self: start; margin-top: 4px;"
                                onclick="document.querySelectorAll('input[name=betaalwijze]').forEach(r => r.checked = false)">
                                <i class="fa fa-xmark"></i> Wissen
                            </button>
                        </div>
                    </div>
                </div>


                <div class="form-section">
                    <div class="form-section-label">
                        <h3>Openingsuren</h3>
                        <p>Geef aan wanneer iederen bij jullie terecht kunnen.</p>
                    </div>
                    <div class="form-section-fields">
                        <div class="opening-grid">
                            <span class="opening-head"></span>
                            <span class="opening-head">Open?</span>
                            <span class="opening-head">Van</span>
                            <span class="opening-head">Tot</span>

                            @foreach (['maandag', 'dinsdag', 'woensdag', 'donderdag', 'vrijdag', 'zaterdag', 'zondag'] as $dag)
                                @php
                                    $uur = $openingsuren[$dag] ?? null;
                                    $isOpen = $uur !== null;
                                @endphp

                                <span class="opening-dag">{{ ucfirst($dag) }}</span>

                                <label class="toggle opening-toggle">
                                    <input type="checkbox" name="openingsuren[{{ $dag }}][open]" value="1"
                                        {{ $isOpen ? 'checked' : '' }} onchange="toggleUren(this)">
                                    <span class="toggle-track"><span class="toggle-thumb"></span></span>
                                </label>

                                <div class="field opening-time">
                                    <input type="time" name="openingsuren[{{ $dag }}][van]"
                                        value="{{ $uur?->startuur ? \Str::substr($uur->startuur, 0, 5) : '' }}"
                                        {{ !$isOpen ? 'disabled' : '' }}>
                                </div>

                                <div class="field opening-time">
                                    <input type="time" name="openingsuren[{{ $dag }}][tot]"
                                        value="{{ $uur?->einduur ? \Str::substr($uur->einduur, 0, 5) : '' }}"
                                        {{ !$isOpen ? 'disabled' : '' }}>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <div class="form-section-label">
                        <h3>Login Gegevens</h3>
                        <p>Laat leeg om je huidige wachtwoord te behouden.</p>
                    </div>
                    <div class="form-section-fields">
                        <div class="field field-full">
                            <label>Email (kan niet worden gewijzigd)</label>
                            <input type="email" value="{{ $user->email }}" disabled>
                        </div>
                        <div class="field">
                            <label>Nieuw Wachtwoord</label>
                            <input type="password" name="password" placeholder="Minimaal 8 tekens">
                        </div>
                        <div class="field">
                            <label>Bevestig Nieuw Wachtwoord</label>
                            <input type="password" name="password_confirmation" placeholder="Herhaal wachtwoord">
                        </div>
                    </div>
                </div>

                <div class="form-section"
                    style="border: 1.5px solid var(--primary-blue-color); background: oklch(from var(--primary-blue-color) 0.97 calc(c * 0.08) h);">
                    <div class="form-section-label">
                        <h3>Zichtbaarheid</h3>
                        <p>Bepaal of jouw organisatie zichtbaar is voor bezoekers op de kaart en in de zoekresultaten.</p>
                    </div>
                    <div class="form-section-fields" style="justify-content:center;">
                        <div class="field">
                            <label>Online tonen</label>
                            <div style="display:flex; align-items:center; gap:12px; margin-top:4px;">
                                <label class="toggle">
                                    <input type="hidden" name="isVisible" value="0">
                                    <input type="checkbox" name="isVisible" value="1"
                                        {{ old('isVisible', $actor->isVisible) ? 'checked' : '' }}
                                        onchange="
                               const lbl = document.getElementById('visible-label');
                               lbl.textContent = this.checked ? 'Zichtbaar voor bezoekers' : 'Verborgen voor bezoekers';
                               lbl.style.color = this.checked ? '#16a34a' : 'var(--secondary-lightgray-color)';
                           ">
                                    <span class="toggle-track"><span class="toggle-thumb"></span></span>
                                </label>
                                <span id="visible-label"
                                    style="font-size:13px; font-weight:600; color:{{ $actor->isVisible ? '#16a34a' : 'var(--secondary-lightgray-color)' }};">
                                    {{ $actor->isVisible ? 'Zichtbaar voor bezoekers' : 'Verborgen voor bezoekers' }}
                                </span>
                            </div>
                            <p class="field-hint">
                                Zet dit uit als jullie gegevens tijdelijk niet getoond mogen worden, bijvoorbeeld bij een
                                verhuis.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="form-footer">
                    <div class="form-footer-meta">
                        <span class="status-dot"></span>
                        Laatst bijgewerkt op {{ $actor->last_updated->format('d/m/Y') }}
                    </div>
                    <div class="form-footer-actions">
                        <a href="{{ route('account.index') }}" class="btn btn-secondary">Annuleren</a>
                        <button type="submit" class="btn btn-primary">Opslaan</button>
                    </div>
                </div>
            </form>

            <div class="logout-wrap">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-ghost">Uitloggen</button>
                </form>
            </div>

        </main>
    </div>
@endsection
