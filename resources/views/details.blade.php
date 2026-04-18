@extends('layouts.layoutMain')

@section('extra_imports')
@endsection

@section('content')
    <div class="details-container">
        <h1>{{ $actor->publieke_naam }}</h1>
        <p>{{ $actor->aangeboden_diensten }}</p>

        <p><strong>Categorie:</strong> {{ $actor->categorie->naam }}</p>
        <p><strong>Gemeente:</strong> {{ $actor->gemeente ?? 'Niet opgegeven' }} </br>
            <strong>Postcode:</strong> {{ $actor->postcode ?? 'Niet opgegeven' }} </br>
            <strong>Straatnaam:</strong> {{ $actor->straatnaam ?? 'Niet opgegeven' }} </br>
            <strong>Huisnummer:</strong> {{ $actor->huisnummer ?? 'Niet opgegeven' }} </br>
            <strong>Busnummer:</strong> {{ $actor->busnummer ?? 'Niet opgegeven' }}
        </p>


        <h2>Contactgegevens</h2>
        <ul>
            @foreach ($actor->contactgegevens as $contact)
                <li>{{ $contact->type }}: {{ $contact->waarde }}</li>
            @endforeach
        </ul>

        <h2>Openingsuren</h2>
        <ul>
            @foreach ($actor->openingsuren as $opening)
                <li>{{ ucfirst($opening->dag_van_de_week) }}: {{ Str::substr($opening->startuur, 0, 5) }} -
                    {{ Str::substr($opening->einduur, 0, 5) }}</li>
            @endforeach
        </ul>

        <h2>Rubrieken</h2>
        <ul>
            @foreach ($actor->rubrieken as $rubriek)
                <li>{{ $rubriek->naam }}</li>
            @endforeach
        </ul>
    </div>
@endsection
