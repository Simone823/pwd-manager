<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Icons website--}}
    <link rel="icon" href="{{asset('/favicon.ico')}}" type="image/x-icon">
    <link rel="shortcut icon" href="{{asset('assets/img/icon-site/icon-192x192.png')}}" sizes="192x192" />
    <link rel="apple-touch-icon" href="{{asset('assets/img/icon-site/icon-apple-touch.png')}}" />

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    {{-- Fontawesome 6.4.0 --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Scripts stack -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    @stack('scripts-js')

    {{-- Title --}}
    <title>{{config('app.name')}} @yield('title')</title>
</head>
<body>

    {{-- loader page --}}
    @include('components.loader')

    <div id="app" class="is-loading">
        {{-- Nav --}}
        @auth
            @include('components.navbar')
        @endauth

        {{-- main --}}
        <main>
            {{-- flash message --}}
            @include('components.flashMessage')

            @yield('content')
        </main>

        {{-- footer --}}
        @include('components.footer')
    </div>

</body>
</html>