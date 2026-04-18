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

                <textarea id="input-box" type="text" name="zoekterm" placeholder="Zoek een organisatie, hulpmiddel of thema..." required></textarea>

                <button type="submit">ZOEKEN</button>
            </div>

            @include('components.search.autocomplete')
        </form>
    </div>

    <div class="spacer-from-side spacer-from-bottom">
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
            <x-index.small-card img="fa-solid fa-location-dot" imgColor="oklch(from var(--primary-blue-color) calc(l * 0.8) c h)"
                imgBackgroundColor="oklch(from var(--primary-blue-color) 0.9 calc(c * 0.25) calc(h - 8))"
                title="Hulp in de buurt" description="Vind diensten bij jou om de hoek"
                link="{{ route('search', ['zoekterm' => 'hulp-in-de-buurt']) }}" />

            <x-index.small-card imgBackgroundColor="var(--secondary-yellow-color)" imgColor="oklch(from var(--secondary-yellow-color) calc(l * 0.6) c h)"
                img="fa-solid fa-star" title="Favorieten"
                description="Bekijk je bewaarde hulpmiddelen" link="{{ route('favorites') }}" />

            <x-index.small-card backgroundColor="#fef2f2" imgBackgroundColor="var(--primary-red-color)"
                img="fa-solid fa-star-of-life" title="Dringende hulpverlening"
                description="Onmiddellijke hulp nodig?"
                titleTextColor="oklch(from var(--primary-red-color) 0.30 calc(c * 0.8) calc(h + 2))"
                descriptionTextColor="var(--primary-red-color)" link="{{ route('search', ['zoekterm' => 'Dringende medische hulpverlening']) }}" />
        </div>

        <h2>Ontdek per thema</h2>
        <hr class="small-yellow-line">

        <div class="big-cards-grid">
            {{--
            'class' => '',
            'title' => '',
            'description' => '',
            'icon' => '',
            'backgroundColor' => 'white',
            'titleColor' => 'var(--primary-darkblue-color)',
            'link' => '#'
            --}}
            <x-index.big-card class="card-noodgeval" title="Ik heb dringende hulp nodig" titleColor="white"
                backgroundColor="var(--primary-red-color)"
                description="Weet waar je terecht kan voor dringende medische hulpverlening en andere noodsituaties."
                icon='fa-solid fa-triangle-exclamation'
                link="{{ route('search', ['zoekterm' => 'Dringende medische hulpverlening']) }}">

                <div class="card-footer">
                    <strong>DIRECT HULP &rarr;</strong>
                </div>
            </x-index.big-card>

            <x-index.big-card class="card-groot" title="Ik wil op eigen benen staan"
                description="Alles over wonen, budget en zelfstandigheid voor jongeren."
                backgroundColor="var(--secondary-broken-white-color)"
                icon="fa-solid fa-person-walking" iconColor="var(--primary-darkblue-color)"
                link="{{ route('search', ['zoekterm' => 'op-eigen-benen-staan']) }}">

                <div class="tags">
                    <span class="tag">WONEN</span>
                    <span class="tag">GELD</span>
                </div>
            </x-index.big-card>

            <x-index.big-card title="Mijn gezondheid" description="Fysiek, mentaal en alles daartussenin."
                backgroundColor="oklch(from var(--primary-blue-color) 0.9 calc(c * 0.25) calc(h - 8))"
                icon="fa-solid fa-heart-pulse" iconColor="oklch(from var(--primary-blue-color) calc(l * 0.8) c h)" titleColor="var(--primary-darkblue-color)"
                link="{{ route('search', ['zoekterm' => 'mijn-gezondheid']) }}">
            </x-index.big-card>

            <x-index.big-card title="Mijn rechten" description="Ken je rechten als jongere in Vlaanderen."
                backgroundColor="var(--secondary-yellow-color)" titleColor="oklch(from var(--secondary-yellow-color) calc(l * 0.6) c h)"
                icon="fa-solid fa-gavel" iconColor="oklch(from var(--secondary-yellow-color) calc(l * 0.6) c h)"
                link="{{ route('search', ['zoekterm' => 'mijn-rechten']) }}">
            </x-index.big-card>

            <x-index.big-card class="card-groot" title="Zie uw opgeslaagde hulp"
                description="Bekijk je bewaarde hulpmiddelen" backgroundColor="var(--secondary-broken-white-color)"
                icon="fa-solid fa-star" link="{{ route('favorites') }}" titleColor="var(--primary-dark-color)" iconColor="var(--primary-dark-color)">
            </x-index.big-card>

            <x-index.big-card title="Ik wil een klacht indienen" description="Weet waar je terecht kan met je verhaal."
                backgroundColor="white" link="{{ route('search', ['zoekterm' => 'klacht-indienen']) }}"
                titleColor="var(--primary-dark-color)" icon="fa-solid fa-comment-medical" iconColor="var(--primary-dark-color)">
            </x-index.big-card>
        </div>
    </div>
@stop
