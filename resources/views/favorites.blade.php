@extends('layouts.layoutMain')

@section('extra_imports')
    <link href="{{ asset('files/css/favorites/favorites.css') }}" rel="stylesheet">
@stop

@section('content')
    <div class="spacer-left spacer-right">
        <div class="favorites-title">
            <h1>Mijn bewaarde&ensp;<span class="blue-italic">Hulp & Zorg</span></h1>
        </div>
        <div class="favorites-subtitle">
            <p>Hier vind je de diensten die je hebt opgeslagen. Een handig overzicht van de hulp en zorg die je belangrijk vindt.</p>
        </div>
    </div>
@endsection
