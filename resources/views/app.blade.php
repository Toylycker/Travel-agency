<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>
        

        {{-- <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/bootstrap-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('css/aos.css') }}"> --}}
        {{-- <link rel="stylesheet" href="{{ asset('css/front.css') }}"> --}}
        {{-- <link rel="stylesheet" href="{{ asset('css/style.css') }}">  --}}
        {{-- <script type="text/javascript" src="{{ asset('js/bootstrap.bundle.min.js') }}"></script> --}}
        {{-- <script type="text/javascript" src="{{ asset('js/aos.js') }}"></script> --}}

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">


        <link rel="stylesheet" type="text/css" href="{{ asset('css/blobz.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-icons.css') }}">




        <!-- Scripts -->
        @routes
        @vite('resources/js/app.js')
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
