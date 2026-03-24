<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'De Sociale Kaart' }}</title>
    <link href="{{ asset('files/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('files/css/colors.css') }}" rel="stylesheet">
    @yield('extra_imports')
  </head>
  <header>
    @include('components.navWithMenu')
  </header>

  <body>
    @yield('content')
  </body>

  <footer>
    @include('components.footer.footer')
  </footer>
</html>
