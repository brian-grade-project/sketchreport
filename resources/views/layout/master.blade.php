<!DOCTYPE html>
<html data-theme="lofi">
    <head>
        <title>@yield('title', 'Bienvenido')</title>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link href="{{ asset('css/daisyui.min.css') }}" rel="stylesheet" type="text/css" >
        <script src="{{ asset('js/cdn.tailwindcss.com.js') }}"></script>
    </head>
    <body>
        
        <main class="">
            @include('layout.sidebar')
            @yield('content')
        </main>
        @include('layout.footer')
    </body>
</html>