<!DOCTYPE html>
<html data-theme="lofi">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title', 'Bienvenido')</title>
        
        <!-- Estilos -->
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <main>
            @include('layout.sidebar')
            @yield('content')
        </main>
        @include('layout.footer')
    </body>
</html>