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

        <a class="nav-link {{ Route::is('index') ? 'active' : '' }}" href="{{ route('index') }}"><img class="nav-img"
                src="{{ asset('files/img/menu/Home_Menu.png') }}">Home</a>
        <a class="nav-link {{ $currentCategory == 'noodgeval' ? 'active' : '' }}"
            href="{{ route('search', ['zoekterm' => 'noodgeval']) }}"><img class="nav-img"
                src="{{ asset('files/img/menu/Noodgeval_Menu.png') }}">Noodgeval</a>
        <a class="nav-link {{ $currentCategory == 'op-eigen-benen-staan' ? 'active' : '' }}"
            href="{{ route('search', ['zoekterm' => 'op-eigen-benen-staan']) }}"><img class="nav-img"
                src="{{ asset('files/img/menu/OpEigenBenenStaan_Menu.png') }}">Op eigen benen staan</a>
        <a class="nav-link {{ $currentCategory == 'mijn-gezondheid' ? 'active' : '' }}"
            href="{{ route('search', ['zoekterm' => 'mijn-gezondheid']) }}"><img class="nav-img"
                src="{{ asset('files/img/menu/MijnGezondheid_Menu.png') }}">Mijn gezondheid</a>
        <a class="nav-link {{ $currentCategory == 'mijn-rechten' ? 'active' : '' }}"
            href="{{ route('search', ['zoekterm' => 'mijn-rechten']) }}"><img class="nav-img"
                src="{{ asset('files/img/menu/MijnRechten_Menu.png') }}">Mijn rechten</a>
        <a class="nav-link {{ $currentCategory == 'klacht-indienen' ? 'active' : '' }}"
            href="{{ route('search', ['zoekterm' => 'klacht-indienen']) }}"><img class="nav-img"
                src="{{ asset('files/img/menu/KlachtIndienen_Menu.png') }}">Klacht indienen</a>
        <a class="nav-link {{ Route::is('favorites') ? 'active' : '' }}" href="{{ route('favorites') }}"><img
                class="nav-img" src="{{ asset('files/img/menu/OpgeslagenHulp_Menu.png') }}">Opgeslagen hulp</a>
    </nav>
    {{-- <div class="bottomMenu">
        <button class="needHelp">HULP NODIG?</button>
    </div> --}}
</div>

<!-- Overlay -->
<div class="overlay" id="overlay"></div>
