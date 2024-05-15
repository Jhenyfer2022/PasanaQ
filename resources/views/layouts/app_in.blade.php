<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    <!--====== Bootstrap css ======-->
    <link rel="stylesheet" href="{{asset('/css/bootstrap.min.css')}}">
</head>
<body>
    <header>
        <!--Navbar de la pagin-->
        @include('layouts.partials.navbar')
    </header>
    <div id="app">
        
        <main class="py-4" style="background-color: #2d8596;">
            <div class="container mt-5">
                @yield('content')
            </div>
        </main>

        <!--footer de la pagina-->
        @include('layouts.partials.footer')
    </div>

    <!--====== Bootstrap js ======-->
    <script src="{{asset('/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('/js/jquery.min.js')}}"></script>
</body>
</html>
