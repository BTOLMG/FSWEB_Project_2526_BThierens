@extends('layouts.layoutMain')

@section('extra_imports')
    <link rel="stylesheet" href="{{ asset('files/css/info_privacy/info_privacy.css') }}">
@endsection

@section('content')

    <div class="info_privacy-banner">
        <h1>
            <span style="color: var(--primary-blue-color)">De spelregels.</span>
            Helder. Eerlijk. Toegankelijk.
        </h1>
        <div class="vertical-line qoute">
            <p>
                "Hoe kun je in ons geloven als we niet transparant zijn over je privacy?
                Vertrouwen verdien je niet met mooie woorden,
                maar met openheid over de gegevens die je met ons deelt."
            </p>
        </div>
    </div>



    <section id="cookies">
        cookies
    </section>

    <section id="privacy">
        privacy
    </section>

    <section id="toegankelijkheid">
        toegankelijkheid
    </section>
@endsection
