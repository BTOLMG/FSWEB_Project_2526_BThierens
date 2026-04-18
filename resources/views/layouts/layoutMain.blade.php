<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'De Sociale Kaart' }}</title>

    {{-- styling --}}
    <link href="{{ asset('files/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('files/css/variables.css') }}" rel="stylesheet">

    {{-- FONT --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

    {{-- icons from fontawesome --}}
    <script src="https://kit.fontawesome.com/ed9e8c8a7a.js" crossorigin="anonymous"></script>

    @yield('extra_imports')
  </head>
  <header>
    @include('components.navbar.navWithMenu')
  </header>

  <body>
    @yield('content')
  </body>

  <footer>
    @include('components.footer.footer')
  </footer>
</html>
