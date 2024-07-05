<!DOCTYPE html>
<html>
    <head>
        <title>@yield('')</title>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>
    <body>
        @include('layout.header')
        <main>
            @include('layout.sidebar')
            @yield('content')
        </main>
        @include('layout.footer')
    </body>
</html>