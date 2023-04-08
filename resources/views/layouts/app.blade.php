<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Icons --}}
    <link rel="icon" href="{{asset('assets/img/icon-site/icon-small-svg.svg')}}">

    {{-- Title --}}
    <title>{{config('app.name')}} @yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
       
        {{-- loader page --}}
        @include('components.loader')

        {{-- Page is load --}}
        <div id="page-loaded" class="h-100 d-none">
            {{-- Nav --}}
            @if(Auth::check())
                @include('components.navbar')
            @endif

            {{-- main --}}
            <main>
                @yield('content')
            </main>

            {{-- footer --}}
            @include('components.footer')
        </div>

    </div>
</body>
</html>
