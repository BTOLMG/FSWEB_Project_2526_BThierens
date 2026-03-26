<!-- Offcanvas menu -->
<head>
<link href="{{ asset('files/css/header_offcanvas.css') }}" rel="stylesheet">
</head>

<div class="offcanvas" id="offcanvasMenu">
    <div class="offcanvas-header">
        @include('components.offcanvasMenu.offcanvasMenuHeader')
        <button id='closeMenuButton'>X</button>
    </div>
    <nav>
        <a class="nav-link active" href="#"><img class="nav-img" src="{{ asset('files/img/menu/Home_Menu.png') }}">Home</a>
        <a class="nav-link" href=""><img class="nav-img" src="{{ asset('files/img/menu/Noodgeval_Menu.png') }}">Noodgeval</a>
        <a class="nav-link" href=""><img class="nav-img" src="{{ asset('files/img/menu/OpEigenBenenStaan_Menu.png') }}">Op eigen benen staan</a>
        <a class="nav-link" href=""><img class="nav-img" src="{{ asset('files/img/menu/MijnGezondheid_Menu.png') }}">Mijn gezondheid</a>
        <a class="nav-link" href=""><img class="nav-img" src="{{ asset('files/img/menu/MijnRechten_Menu.png') }}">Mijn rechten</a>
        <a class="nav-link" href=""><img class="nav-img" src="{{ asset('files/img/menu/KlachtIndienen_Menu.png') }}">Klacht indienen</a>
    </nav>
</div>

<!-- Overlay -->
<div class="overlay" id="overlay"></div>
