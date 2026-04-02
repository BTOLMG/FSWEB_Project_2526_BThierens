<!-- Navbar -->
<head>
<link href="{{ asset('files/css/header_offcanvas.css') }}" rel="stylesheet">
</head>

<nav class="navbar">
    <button class="navbar-toggler" id="menuButton">
        <span></span>
    </button>
    <div class="navbar-title">De Sociale Kaart</div>

    <a href="" class="navbar-item">Hulp</a>
    <a href="" class="navbar-item">Over ons</a>
    @include('components.navbar.navbarUserOrLogin')

</nav>
