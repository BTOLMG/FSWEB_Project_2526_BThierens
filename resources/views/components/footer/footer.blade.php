<!-- Footer -->
<head>
<link href="{{ asset('files/css/footer.css') }}" rel="stylesheet">
</head>

<a href="{{route('index')}}" class="main-footer">
    <p class="footer-title">De Sociale Kaart</p>
    <p class="footer-sub-title">&copy; {{ date('Y') }} De Sociale Kaart - Departement Zorg</p>
</a>

{{-- tODO: voeg toe dat wanneer hier op geklikt wordt het naar de correcte plaats op de pagina gaat --}}
<div class="info-footer">
    <a href="{{route('privacy')}}">Privacy</a>
    <a href="{{route('cookies')}}">Cookies</a>
    <a href="{{route('toegankelijkheid')}}">Toegankelijkheid</a>
</div>

