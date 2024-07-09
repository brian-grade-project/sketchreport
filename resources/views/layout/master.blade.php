<!DOCTYPE html>
<html>
    <head>
        <title>@yield('')</title>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
        <script src="https://cdn.tailwindcss.com"></script>
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