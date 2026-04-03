@props([
    'backgroundColor' => 'var(--primary-white-color)',
    'img' => '',
    'imgBackgroundColor' => 'none',
    'title' => 'Titel',
    'description' => 'description',
    'link' => '#',
    'titleTextColor' => '',
    'descriptionTextColor' => ''
])

<head>
    <link href="{{ asset('files/css/index/small_card.css') }}" rel="stylesheet">
</head>

<a href="{{ $link }}" class="small-card-link" style="background-color: {{ $backgroundColor }}">
    <div class="small-card">
        <div class="small-card-img" style="background-color: {{ $imgBackgroundColor }}">
            <img src="{{ $img }}" alt="{{ $title }}">
        </div>
        <div class="small-card-content">
            <h3 style="color: {{ $titleTextColor }}">{{ $title }}</h3>
            <p style="color: {{ $descriptionTextColor }}">{{ $description }}</p>
        </div>
    </div>
</a>
