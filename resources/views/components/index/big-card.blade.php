@props([
    'class' => '',
    'title' => '',
    'description' => '',
    'icon' => '',
    'backgroundColor' => 'white',
    'titleColor' => 'var(--primary-darkblue-color)',
    'link' => '#'
])

<head>
    <link href="{{ asset('files/css/index/big_card.css') }}" rel="stylesheet">
</head>

<a href="{{ $link }}" class="big-card {{ $class }}" style="background-color: {{ $backgroundColor }}">
    <div>
        @if ($icon)
            <img class="big-card-icon" src="{{ $icon }}" alt="Card Icon">
        @endif
        <h2 style="color: {{ $titleColor }}">{{ $title }}</h2>
        <p style="color: {{ $titleColor }}; opacity: 0.8;">{{ $description }}</p>
    </div>

    {{ $slot }}
</a>
