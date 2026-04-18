@extends('layouts.layoutMain')

<script>
    const detailsLink = '{{ route("details", ["id" => ":id"]) }}';
</script>

@section('extra_imports')
    <link href="{{ asset('files/css/favorites/favorites.css') }}" rel="stylesheet">
    <script src="{{ asset('files/js/favorites.js') }}" defer></script>
    <script src="{{ asset('files/js/favorites_page.js') }}" defer></script>
@stop

@section('content')
    <div class="spacer-left spacer-right">
        <div class="favorites-title">
            <h1>Mijn bewaarde&ensp;<span class="blue-italic">Hulp & Zorg</span></h1>
        </div>
        <div class="favorites-subtitle">
            <p>Hier vind je de diensten die je hebt opgeslagen. Een handig overzicht van de hulp en zorg die je belangrijk
                vindt.</p>
        </div>
    </div>

    <div>
        <div id="favorieten-container" class="favorieten-container">
            <p id="favorites-loading">Laden...</p>
        </div>
    </div>

@endsection
