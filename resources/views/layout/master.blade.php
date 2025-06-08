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
        @auth
            @include('layout.header')
        @endauth
        <main>
            @auth
                @include('layout.sidebar')
            @endauth
            @yield('content')
        </main>
        @auth
            @include('layout.footer')
        @endauth

        <!-- Contenedor de mensajes -->
        <div id="successMessage" class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg hidden"></div>

        <!-- Scripts -->
        <script>
            function showNotification(message, type = 'success') {
                const messageContainer = document.getElementById('successMessage');
                messageContainer.textContent = message;
                messageContainer.classList.remove('hidden');
                messageContainer.classList.remove('bg-green-500', 'bg-red-500');
                messageContainer.classList.add(type === 'success' ? 'bg-green-500' : 'bg-red-500');

                // Ocultar el mensaje después de 3 segundos
                setTimeout(() => {
                    messageContainer.classList.add('hidden');
                }, 3000);
            }

            // Mostrar notificaciones de sesión si existen
            @if(session('success'))
                showNotification('{{ session('success') }}', 'success');
            @endif

            @if(session('error'))
                showNotification('{{ session('error') }}', 'error');
            @endif
        </script>
        @yield('scripts')
    </body>
</html>