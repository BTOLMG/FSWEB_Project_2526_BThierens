<!-- Navbar -->
<head>
<link href="{{ asset('files/css/header_offcanvas.css') }}" rel="stylesheet">
</head>

<nav class="navbar">
    <button class="navbar-toggler" id="menuButton">
        <span></span>
    </button>
    <a href="{{route('index')}}" class="navbar-title">De Sociale Kaart</a>

    <a href="{{route('faq')}}" class="navbar-item">Hulp</a>
    <a href="{{route('about')}}" class="navbar-item">Over ons</a>
    @include('components.navbar.navbarUserOrLogin')

</nav>
