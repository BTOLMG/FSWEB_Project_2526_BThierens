@props([
    'thema' => null,
    'afstand' => null,
    'title' => null,
    'beschrijving' => null,
    'openingstijden' => null,
    'extraInfo' => null,
    'mail' => null,
    'telefoon' => null,
    'adressen' => null,
    'website' => null,
    'link' => null,
    'isFavoriet' => false,
    'isVerified' => false,
    'isOrganisatie' => false,

])

<head>
    <link href="{{ asset('files/css/search/card.css') }}" rel="stylesheet">
</head>

<div class="card">
    <div class="card-header">
        <h2>{{ $title }}</h2>
        @if ($isVerified)
            <span class="verified">Geverifieerd</span>
        @else
            <span class="not-verified">Niet geverifieerd</span>
        @endif
    </div>
    <div class="card-body">
        <p>{{ $beschrijving }}</p>
        <p><strong>Afstand:</strong> {{ $afstand }}</p>
        <p><strong>Openingstijden:</strong> {{ $openingstijden }}</p>
        <p><strong>Adres:</strong> {{ $adressen }}</p>
        <p><strong>Mail:</strong> {{ $mail }}</p>
        <p><strong>Telefoon:</strong> {{ $telefoon }}</p>
        <p><strong>Website:</strong> <a href="{{ $website }}" target="_blank">{{ $website }}</a></p>
    </div>
    <div class="card-footer">
        <a href="{{ $link }}" class="details-link">Bekijk details</a>
    </div>
</div>
