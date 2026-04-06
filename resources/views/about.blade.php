@extends('layouts.layoutMain')

@section('extra_imports')
    <link rel="stylesheet" href="{{ asset('files/css/about/about.css') }}">
    <link rel="stylesheet" href="{{ asset('files/css/index/small_card.css') }}">
    {{-- <script src="{{ asset('files/js/faq.js') }}" defer></script> --}}
@endsection

@section('content')
    <div class="title-banner">
        <h1>
            Uw gids door<br><span style="color: var(--primary-blue-color)">De Sociale kaart</span>.
        </h1>
        <p>
            De Vlaamse Sociale Kaart informeert elke burger en zorgverstrekker over het beschikbare zorg- en hulpaanbod in
            Vlaanderen en Brussel. Van kinderopvang en huisartsen tot gespecialiseerde verslavingshulp
        </p>
        <button class="contact-btn">
            Contacteer ons team
        </button>
    </div>


    <div class="padding-side" style="background-color: var(--secondary-broken-white-color)">
        <div class="content-header">
            <h2>Inleiding</h2>
            <p>
                U kan zoeken naar antwoorden op zorgvragen zoals, “waar vind ik kinderopvang in mijn gemeente?”, “welke
                huisartsen zijn er in mijn buurt?”, “waar vindt een verslaafd familielid hulp?”, enz. Ook hulpverleners kunnen
                het instrument gebruiken om gericht door te verwijzen. De lokale besturen krijgen een overzicht van de welzijns-
                en zorgactoren op hun grondgebied. Neem zeker steeds contact op met de zorgaanbieder zelf om uw zorgvraag op te
                lossen.
            </p>
        </div>
        <div class="content">
            <div class="left">
                <h2>Wie staat op de sociale kaart?</h2>
                <p> Welke zorgvoorzieningen en gezondheidszorgverstrekkers wel/niet opgenomen worden in de Sociale Kaart
                    wordt
                    verankerd in het <a rel="noopener" target="_blank"
                        href="https://codex.vlaanderen.be/Zoeken/Document.aspx?DID=1031834&amp;param=inhoud">Decreet
                        houdende de
                        Sociale Kaart van 3 mei '19</a> (B.S. 26/06/19), artikel 2. Op basis van het decreet wordt de scope
                    van
                    de Sociale Kaart bepaald. </p>

                <div class="card-data">
                    <div class="card-header">
                        <img class="header-icon" src="{{ asset('files/img/about/data-icon.png') }}">
                        <h3>Beschikbare Data</h3>
                    </div>
                    <ul class="data-list">
                        <li><img class="li-icon" src="{{ asset('files/img/about/check-icon.png') }}"> Adresgegevens</li>
                        <li><img class="li-icon" src="{{ asset('files/img/about/check-icon.png') }}"> Contactgegevens</li>
                        <li><img class="li-icon" src="{{ asset('files/img/about/check-icon.png') }}"> Aanbodomschrijving
                        </li>
                        <li><img class="li-icon" src="{{ asset('files/img/about/check-icon.png') }}"> Doelgroepen</li>
                        <li><img class="li-icon" src="{{ asset('files/img/about/check-icon.png') }}"> Openingsuren</li>
                        <li><img class="li-icon" src="{{ asset('files/img/about/check-icon.png') }}"> Toegankelijkheid</li>
                    </ul>
                </div>
            </div>
            <div class="right">
                <h2>Kwaliteit door Connectie</h2>
                <p>We combineren <span style="font-weight: bold">authentieke gegevensbronnen</span> met handmatige updates
                    voor
                    maximale betrouwbaarheid.</p>

                <div class="grid">
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
                    <x-index.small-card backgroundColor="var(--secondary-lightyellow-color)" title="AUTHENTIEKE BRONNEN"
                        description="KBO, Erkenningsdata (WVG), RIZIV, Adresregister/Urbis."
                        titleTextColor="var(--secondary-darkyellow-color)"
                        descriptionTextColor="var(--secondary-blue-text-color)" />

                    <x-index.small-card backgroundColor="var(--primary-lightblue-color)" title="PARTNERSHIPS"
                        description="Departement Zorg, VGC, Kenniscentrum WWZ, Zorggraden, Opgroeien, VAPH."
                        titleTextColor="var(--primary-darkblue-color)"
                        descriptionTextColor="var(--secondary-blue-text-color)" />

                </div>
            </div>
        </div>
    </div>

    <div class="padding-side contact">
        <div class="contact-header">
            <h1>Team Sociale Kaart</h1>
            <p>Onze regiobeheerders zorgen ervoor dat de kaart in elke uithoek van Vlaanderen actueel blijft.</p>
        </div>

        <div class="contact-grid">
            <div class="contact-card">
                <div class="icon-wrapper">
                    <img src="{{ asset('files/img/index/marker-icon.png') }}" alt="Locatie">
                </div>
                <div class="contact-content">
                    <h3>Regio Antwerpen</h3>
                    <p>Phebe Devadder</p>
                    <a href="mailto:phebe.devadder@vlaanderen.be" class="contact-email">
                        <img src="{{ asset('files/img/about/mail-icon.png') }}" alt="Mail">
                        phebe.devadder@vlaanderen.be
                    </a>
                </div>
            </div>

            <div class="contact-card">
                <div class="icon-wrapper">
                    <img src="{{ asset('files/img/index/marker-icon.png') }}" alt="Locatie">
                </div>
                <div class="contact-content">
                    <h3>Regio Limburg</h3>
                    <p>Jan Theys</p>
                    <a href="mailto:jan.theys@vlaanderen.be" class="contact-email">
                        <img src="{{ asset('files/img/about/mail-icon.png') }}" alt="Mail">
                        jan.theys@vlaanderen.be
                    </a>
                </div>
            </div>

            <div class="contact-card">
                <div class="icon-wrapper">
                    <img src="{{ asset('files/img/index/marker-icon.png') }}" alt="Locatie">
                </div>
                <div class="contact-content">
                    <h3>Regio Oost-Vlaanderen</h3>
                    <p>Christophe Pyra</p>
                    <a href="mailto:christophe.pyra@vlaanderen.be" class="contact-email">
                        <img src="{{ asset('files/img/about/mail-icon.png') }}" alt="Mail">
                        christophe.pyra@vlaanderen.be
                    </a>
                </div>
            </div>


            <div class="contact-card">
                <div class="icon-wrapper">
                    <img src="{{ asset('files/img/index/marker-icon.png') }}" alt="Locatie">
                </div>
                <div class="contact-content">
                    <h3>Regio Vlaams-Brabant</h3>
                    <p>Leen Lauwers</p>
                    <a href="mailto:leen.lauwers@vlaanderen.be" class="contact-email">
                        <img src="{{ asset('files/img/about/mail-icon.png') }}" alt="Mail">
                        leen.lauwers@vlaanderen.be
                    </a>
                    <br>
                    <p>Jan Theys</p>
                    <a href="mailto:jan.theys@vlaanderen.be" class="contact-email">
                        <img src="{{ asset('files/img/about/mail-icon.png') }}" alt="Mail">
                        jan.theys@vlaanderen.be
                    </a>
                </div>
            </div>

            <div class="contact-card">
                <div class="icon-wrapper">
                    <img src="{{ asset('files/img/index/marker-icon.png') }}" alt="Locatie">
                </div>
                <div class="contact-content">
                    <h3>Regio West-Vlaanderen</h3>
                    <p>Sven De Meulenaere</p>
                    <a href="mailto:sven.demeulenaere@vlaanderen.be" class="contact-email">
                        <img src="{{ asset('files/img/about/mail-icon.png') }}" alt="Mail">
                        sven.demeulenaere@vlaanderen.be
                    </a>
                </div>
            </div>

            <div class="contact-card">
                <div class="icon-wrapper">
                    <img src="{{ asset('files/img/index/marker-icon.png') }}" alt="Locatie">
                </div>
                <div class="contact-content">
                    <h3>Brussels Hoofdstedelijk Gewest</h3>
                    <p>Germaine Vanderstappen</p>
                    <a href="mailto:germaine.vanderstappen@kenniscentrumwwz.be" class="contact-email">
                        <img src="{{ asset('files/img/about/mail-icon.png') }}" alt="Mail">
                        germaine.vanderstappen@kenniscentrumwwz.be
                    </a>
                </div>
            </div>

            <div class="contact-card">
                <div class="icon-wrapper">
                    <img src="{{ asset('files/img/index/marker-icon.png') }}" alt="Locatie">
                </div>
                <div class="contact-content">
                    <h3>Ondersteuning</h3>
                    <p>Bieke Formesyn</p>
                    <a href="mailto:bieke.formesyn@vlaanderen.be" class="contact-email">
                        <img src="{{ asset('files/img/about/mail-icon.png') }}" alt="Mail">
                        bieke.formesyn@vlaanderen.be
                    </a>
                </div>
            </div>

            <div class="contact-card">
                <div class="icon-wrapper">
                    <img src="{{ asset('files/img/index/marker-icon.png') }}" alt="Locatie">
                </div>
                <div class="contact-content">
                    <h3>Ondersteuning</h3>
                    <p>Karine Olislaegers</p>
                    <a href="mailto:karine.olislaegers@vlaanderen.be" class="contact-email">
                        <img src="{{ asset('files/img/about/mail-icon.png') }}" alt="Mail">
                        karine.olislaegers@vlaanderen.be
                    </a>
                </div>
            </div>

            <div class="contact-card">
                <div class="icon-wrapper">
                    <img src="{{ asset('files/img/index/marker-icon.png') }}" alt="Locatie">
                </div>
                <div class="contact-content">
                    <h3>Coördinator</h3>
                    <p>Patricia Werbrouck</p>
                    <a href="mailto:patricia.werbrouck@vlaanderen.be" class="contact-email">
                        <img src="{{ asset('files/img/about/mail-icon.png') }}" alt="Mail">
                        patricia.werbrouck@vlaanderen.be
                    </a>
                </div>
            </div>
        </div>

    </div>
@endsection
