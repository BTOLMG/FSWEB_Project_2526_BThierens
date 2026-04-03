@extends('layouts.layoutMain')


@section('extra_imports')
    <link href="{{ asset('files/css/index/index.css') }}" rel="stylesheet">
@stop

@section('content')
    <div class="banner">
        <h1>Hoe kunnnen we je helpen?</h1>
        <form action="{{ route('search') }}" method="GET" class="search-form">
            <div class="search-wrapper">
                <img src="{{ asset('files/img/search-icon.png') }}" alt="Search Icon" class="search-icon">

                <input type="text" name="data" placeholder="Zoek een organisatie, hulpmiddel of thema..." required>

                <button type="submit">ZOEKEN</button>
            </div>
        </form>
    </div>



    <div class="cards-grid">
        {{--
        'backgroundColor' => 'var(--primary-white-color)',
        'img' => '',
        'imgBackgroundColor' => 'none',
        'title' => 'Titel',
        'description' => 'description',
        'link' => '#',
        'titleTextColor' => '',
        'descriptionTextColor' => ''
        --}}
        <x-index.small-card
            img="{{ asset('files/img/search-icon.png') }}"
            imgBackgroundColor="oklch(from var(--primary-blue-color) 0.9 calc(c * 0.25) calc(h - 8))"
            title="Hulp in de buurt"
            description="Vind diensten bij jou om de hoek"
            link="{{ route('search', ['data' => 'hulp-in-de-buurt']) }}"
        />

        <x-index.small-card
            imgBackgroundColor="var(--secondary-yellow-color)"
            img="{{ asset('files/img/search-icon.png') }}"
            title="Favorieten"
            description="Bekijk je bewaarde hulpmiddelen"
            link="#"
        />

        <x-index.small-card
            backgroundColor="#fef2f2"
            imgBackgroundColor="var(--primary-red-color)"
            img="{{ asset('files/img/search-icon.png') }}"
            title="Noodnummers"
            description="Onmiddellijke hulp nodig?"
            titleTextColor="oklch(from var(--primary-red-color) 0.30 calc(c * 0.8) calc(h + 2))"
            descriptionTextColor="var(--primary-red-color)"
            link="#"
        />
    </div>

    <p>Hier vind je een overzicht van alle sociale voorzieningen in jouw regio.</p>
    <a href="{{ route('search') }}" class="btn">Zoek nu</a>





@stop
