@props([
    'thema' => null,
    'afstand' => null,
    'title' => null,
    'beschrijving' => null,
    'openingstijden' => null,
    'extraInfoList' => null,
    'adressen' => null,
    'mail' => null,
    'telefoon' => null,
    'website' => null,
    'link' => null,
    'isVerified' => false,
    'isOrganisatie' => false,
    'actorId' => null,
])

<head>
    <link href="{{ asset('files/css/search/card.css') }}" rel="stylesheet">
</head>

<div class="card">
    <div class="card-info">
        <div class="card-data">
            @if ($thema)
                <span class="thema">{{ $thema }}</span>
            @endif
            @if ($afstand)
                <span class="afstand"> • {{ $afstand }} km afstand</span>
            @endif
        </div>

        <button class="favoriet-button" title="Toevoegen aan favorieten" data-id="{{ $actorId }}" onclick="toggleFavoriet(this)">
            <i class="fa fa-heart"></i>
        </button>
    </div>

    <div class="card-title">
        @if ($isVerified)
            <span class="verified"></span>
        @endif
        <h2>{{ $title }}</h2>
    </div>

    <div class="card-body">
        <div class="body-left">
            <p>{{ $beschrijving }}</p>

            <div class="extra-info-container">
                @if ($extraInfoList)
                    @foreach ($extraInfoList as $info)
                        <p class="extra-info">{{ $info }}</p>
                    @endforeach
                @endif
            </div>
        </div>

        <div class="body-right">
            @if ($openingstijden)
                <p><strong>Openingstijden:</strong> {{ $openingstijden }}</p>
            @endif
            @if ($mail)
                <p><strong>Mail:</strong> <a href="mailto:{{ $mail }}">{{ $mail }}</a></p>
            @endif
            @if ($telefoon)
                <p><strong>Telefoon:</strong> <a href="tel:{{ $telefoon }}">{{ $telefoon }}</a></p>
            @endif
            @if ($website)
                <p><strong>Website:</strong> <a href="{{ $website }}" target="_blank">{{ $website }}</a></p>
            @endif
        </div>
    </div>
    <div class="card-footer">
        @if (!empty($adressen))
            @if (count($adressen) === 1)
                <p><strong>Adres:</strong> {{ $adressen[0] }}</p>
            @else
                <p><strong>Adressen:</strong></p>
                <ul>
                    @foreach ($adressen as $adres)
                        <li>{{ $adres }}</li>
                    @endforeach
                </ul>
            @endif
        @endif

        <a href="{{ route("details", ["id" => $actorId]) }}" class="details-link">Bekijk details</a>
    </div>
</div>
