@extends('layouts.layoutMain')

@php

$faker = Faker\Factory::create('nl_BE');

$dataList = [];

$count = 5;

for ($i = 0; $i < $count; $i++) {
    $adressenList = [];
    for ($j=0; $j < rand(1, 3); $j++) {
        $adressenList[] = $faker->address;
    }

    $extraInfoList = [];
    for ($k=0; $k < rand(0, 3); $k++) {
        $extraInfoList[] = $faker->word;
    }

    $dataList[] = [
        'thema' => $faker->word,
        'afstand' => rand(1, 40) . ' km',
        'title' => $faker->company,
        'beschrijving' => $faker->paragraph,
        'openingstijden' => $faker->time('H:i') . ' - ' . $faker->time('H:i'),
        'extraInfoList' => $extraInfoList,
        'adressen' => $adressenList,
        'mail' => $faker->email,
        'telefoon' => $faker->phoneNumber,
        'website' => $faker->url,
        'favoriet' => $faker->boolean,
        'verified' => $faker->boolean,
        'organisatie' => $faker->boolean,
    ];
}
// echo '<br><br><br><br><br><br><br><br><br><br><br>';
// for ($i = 0; $i < $count; $i++) {
//     echo $dataList[$i]['title'] . '<br>';
//     echo $dataList[$i]['afstand'] . '<br>';
//     echo $dataList[$i]['openingstijden'] . '<br>';
//     echo $dataList[$i]['adres'] . '<br>';
//     echo $dataList[$i]['mail'] . '<br>';
//     echo $dataList[$i]['telefoon'] . '<br>';
//     echo $dataList[$i]['website'] . '<br>';
//     echo $dataList[$i]['verified'] ? 'Geverifieerd' : 'Niet geverifieerd';
//     echo '<br><br>';
// }

@endphp


@section('extra_imports')
    <link rel="stylesheet" href="{{ asset('files/css/search/search.css') }}">
    <script src="{{ asset('files/js/search.js') }}" defer></script>
@endsection

@section('content')
    <div class="margin-side">
        <div class="search-banner">
            <h1>Hulp in jouw buurt</h1>
            @if ($zoekterm !== null && $count > 0)
                <p>We vonden {{ $count }} resultaten voor "{{ $zoekterm }}"</p>
            @elseif ($count == 0)
                <p>We vonden geen resultaten voor "{{ $zoekterm }}"</p>
            @endif
        </div>

        <div class="search-filter-main-divider">
            <div class="filters">hier komen allemaal gekke filters</div>

            <div class="main-content">
                @foreach ($dataList as $data)
                    <x-search.card
                        :thema="$data['thema']"
                        :afstand="$data['afstand']"
                        :title="$data['title']"
                        :beschrijving="$data['beschrijving']"
                        :openingstijden="$data['openingstijden']"
                        :extraInfoList="$data['extraInfoList']"
                        :adressen="$data['adressen']"
                        :mail="$data['mail']"
                        :telefoon="$data['telefoon']"
                        :website="$data['website']"
                        :link="'#'"
                        :isFavoriet="$data['favoriet']"
                        :isVerified="$data['verified']"
                        :isOrganisatie="$data['organisatie']"
                    />
                @endforeach
            </div>
        </div>
    </div>
@endsection
