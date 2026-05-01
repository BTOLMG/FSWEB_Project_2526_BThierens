@extends('layouts.layoutMain')

@section('extra_imports')
    <link rel="stylesheet" href="{{ asset('files/css/kaart/kaart.css') }}">


    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css"/>
    <script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>


    <script src="{{ asset('files/js/kaart.js') }}" defer></script>
@endsection

@section('content')
    <div class="layout">
        <div class="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-title-row">
                    <div>
                        <h2 class="sidebar-title">Aanbieders</h2>
                        <p class="sidebar-sub">In jouw regio</p>
                    </div>
                    <span class="result-badge" id="result-count">laden…</span>
                </div>

                <div class="search-wrapper">
                    <img src="{{ asset('files/img/search-icon.png') }}" alt="Search Icon" class="search-icon">
                    <input type="text" id="kaart-search"
                        placeholder="Zoek op naam, gemeente of thema…"
                        class="search-input">
                </div>
            </div>

            <div class="active-filters" id="kaart-active-filters" style="display:none"></div>

            <div class="filters">
                <div class="filter-accordion open">
                    <button type="button" class="filter-accordion-header">
                        <span><i class="fa fa-circle-dot"></i> Straal</span>
                        <i class="fa fa-chevron-down filter-accordion-icon"></i>
                    </button>
                    <div class="filter-accordion-body">
                        <div class="radius-control">
                            <div class="radius-row">
                                <span class="radius-label" id="radius-label">Geen straal actief</span>
                                <button type="button" class="radius-clear-btn" id="radius-clear"
                                    style="display:none" title="Straal verwijderen">
                                    <i class="fa fa-xmark"></i>
                                </button>
                            </div>
                            <input type="range" id="radius-slider" class="radius-slider"
                                min="1" max="50" step="1" value="10">
                            <div class="radius-meta">
                                <span class="radius-hint">Sleep om radius in te stellen</span>
                                <span class="radius-km" id="radius-km">10 km</span>
                            </div>
                            <div class="radius-actions">
                                <button type="button" class="radius-btn" id="btn-mijn-locatie">
                                    <i class="fa fa-location-crosshairs"></i> Mijn locatie
                                </button>
                                <button type="button" class="radius-btn radius-btn-outline" id="btn-klik-kaart">
                                    <i class="fa fa-map-pin"></i> Klik op kaart
                                </button>
                            </div>
                            <p class="radius-instruction" id="radius-instruction" style="display:none">
                                <i class="fa fa-hand-pointer"></i> Klik ergens op de kaart om het middelpunt te plaatsen.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="filter-accordion">
                    <button type="button" class="filter-accordion-header">
                        <span><i class="fa fa-tag"></i> Categorie</span>
                        <i class="fa fa-chevron-down filter-accordion-icon"></i>
                    </button>
                    <div class="filter-accordion-body">
                        <ul class="filter-checklist" id="filter-categorie-list"></ul>
                    </div>
                </div>

                <div class="filter-accordion">
                    <button type="button" class="filter-accordion-header">
                        <span><i class="fa fa-map-location-dot"></i> Gemeente</span>
                        <i class="fa fa-chevron-down filter-accordion-icon"></i>
                    </button>
                    <div class="filter-accordion-body">
                        <div class="filter-search-wrapper">
                            <i class="fa fa-search filter-search-icon"></i>
                            <input type="text" class="filter-search-input" id="gemeente-zoek"
                                placeholder="Zoek gemeente…">
                        </div>
                        <ul class="filter-checklist filter-checklist-scroll" id="filter-gemeente-list"></ul>
                    </div>
                </div>

            </div>

            <div class="card-list custom-scroll" id="kaart-card-list">
                <div class="loading" id="kaart-loading">
                    <i class="fa fa-spinner fa-spin"></i> Laden…
                </div>
            </div>
        </div>

        <section class="map-section">
            <div id="map"></div>
        </section>
    </div>
@endsection
