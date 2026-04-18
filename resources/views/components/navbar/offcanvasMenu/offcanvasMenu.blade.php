<!-- Offcanvas menu -->

<head>
    <link href="{{ asset('files/css/header_offcanvas.css') }}" rel="stylesheet">
</head>

<div class="offcanvas" id="offcanvasMenu">
    <div class="offcanvas-header">
        @include('components.navbar.navbarUserOrLogin')
        <button id='closeMenuButton'>X</button>
    </div>
    <nav>
        @php $currentCategory = request()->get('zoekterm'); @endphp

        <a class="nav-link {{ Route::is('index') ? 'active' : '' }}"
            href="{{ route('index') }}">
            <i class="fa-fw fa-solid fa-house"></i><p>Home</p></a>
        <a class="nav-link {{ $currentCategory == 'noodgeval' ? 'active' : '' }}"
            href="{{ route('search', ['zoekterm' => 'Dringende medische hulpverlening']) }}">
            <i class="fa-fw fa-solid fa-triangle-exclamation"></i><p>Noodgeval</p></a>
        <a class="nav-link {{ $currentCategory == 'op-eigen-benen-staan' ? 'active' : '' }}"
            href="{{ route('search', ['zoekterm' => 'op-eigen-benen-staan']) }}">
            <i class="fa-fw fa-solid fa-person-walking"></i><p>Op eigen benen staan</p></a>
        <a class="nav-link {{ $currentCategory == 'mijn-gezondheid' ? 'active' : '' }}"
            href="{{ route('search', ['zoekterm' => 'mijn-gezondheid']) }}">
            <i class="fa-fw fa-solid fa-heart-pulse"></i><p>Mijn gezondheid</p></a>
        <a class="nav-link {{ $currentCategory == 'mijn-rechten' ? 'active' : '' }}"
            href="{{ route('search', ['zoekterm' => 'mijn-rechten']) }}">
            <i class="fa-fw fa-solid fa-gavel"></i><p>Mijn rechten</p></a>
        <a class="nav-link {{ $currentCategory == 'klacht-indienen' ? 'active' : '' }}"
            href="{{ route('search', ['zoekterm' => 'klacht-indienen']) }}">
            <i class="fa-fw fa-solid fa-comment-medical"></i><p>Klacht indienen</p></a>
        <a class="nav-link {{ Route::is('favorites') ? 'active' : '' }}"
            href="{{ route('favorites') }}">
            <i class="fa-fw fa-solid fa-star"></i><p>Opgeslagen hulp</p></a>
    </nav>
    {{-- <div class="bottomMenu">
        <button class="needHelp">HULP NODIG?</button>
    </div> --}}
</div>

<!-- Overlay -->
<div class="overlay" id="overlay"></div>
