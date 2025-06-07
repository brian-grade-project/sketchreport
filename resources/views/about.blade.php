@extends('layout.master')

@section('title', 'Acerca de Nosotros')

@section('content')

{{-- Primera sección con imagen de fondo --}}
<div class="w-screen h-screen bg-[url('{{ asset('img/saber-escribir-escritor-periodista.jpg') }}')] bg-no-repeat bg-cover relative">
    <div class="bg-black/80 backdrop-blur-sm absolute inset-0"></div>
    <div class="relative z-10 w-full h-full flex flex-col items-center justify-center">
        {{-- Botones de navegación replicados de la vista de inicio --}}
        <nav class="w-full flex flex-row p-3 absolute top-0 left-0">
             <ul class="flex flex-row text-2xl lg:space-x-8 md:space-x-2 p-3 ml-2">
                <li> <a class="md:text-xl text-orange-600 hover:transition-all duration-500 ease-in-out hover:text-zinc-800 hover:bg-orange-600 pointer rounded-full px-3  py-2" href="{{ route('home') }}">Inicio</a></li>
                <li> <a class="md:text-xl text-orange-600  hover:transition-all duration-500 ease-in-out hover:text-zinc-800 hover:bg-orange-600 pointer rounded-full px-3  py-2" href="{{ route('about') }}">Información</a></li>
                <li> <a class="md:text-xl text-orange-600  hover:transition-all duration-500 ease-in-out hover:text-zinc-800 hover:bg-orange-600 pointer rounded-full px-3  py-2" href="#">Enlaces</a></li>
            </ul>
        </nav>

        {{-- Contenido principal de la primera sección (logo y texto) --}}
        <div class="flex flex-col items-center text-center px-4 max-w-4xl">
             <img src="{{ asset('img/logotipo1.svg') }}" class="w-80 md:w-96 lg:w-104 xl:w-112 mb-8"></img>
             <p class="text-white text-lg md:text-xl leading-relaxed font-light">
                El avance del mundo digital ha mejorado nuestra vida cotidiana y laboral, proporcionando herramientas para aumentar el rendimiento en diferentes áreas, estando el periodismo incluido. Los sistemas de información con sus bases de datos organizadas son ampliamente utilizados por su rapidez, seguridad y precisión en la solución de problemas y necesidades específicas. es alli donde <span class="text-orange-600 font-bold">SketchReport</span> hace presencia. Este sistema permitirá llevar un registro detallado de noticias, material multimedia y eventos, facilitando la visualización de evidencias en tiempo real, lo que ayudará a mejorar la eficacia y reducir la incertidumbre característica de esta rama.
             </p>
        </div>
    </div>
</div>

{{-- Segunda sección con descripción de la aplicación (reestructurada) --}}
<div class="w-screen min-h-screen relative flex flex-col">
    {{-- Eliminar bg-[url(...)] y el overlay si no se necesita --}}
    <div class="w-full h-96 bg-orange-600 flex items-center justify-center">
        {{-- Contenido para la primera parte (orange-600) --}}
        <div class="flex items-center justify-between w-full h-full">
            {{-- Texto en la esquina izquierda --}}
            <div class="w-1/2 flex items-center h-full pl-4">
                <p class="text-zinc-900 text-2xl md:text-3xl lg:text-4xl leading-relaxed italic relative pl-8">
                    <span class="absolute left-0 top-1/2 transform -translate-y-1/2 w-4 h-4 bg-zinc-900 rounded-full"></span>
                    Crea, registra, almacena y exporta tus propios reportes a través de una cómoda interfaz
                </p>
            </div>
            {{-- Imagen en la esquina derecha --}}
            <div class="w-1/2 flex items-center justify-end h-full">
                <img src="{{ asset('img/workspace-766045_1280.jpg') }}" class="h-full object-cover"></img>
            </div>
        </div>
    </div>
    <div class="w-full h-96 bg-zinc-900 flex items-center justify-center">
        {{-- Contenido para la segunda parte (zinc-900) --}}
        <div class="flex items-center justify-between w-full h-full">
            {{-- Imagen en la esquina izquierda --}}
            <div class="w-1/2 flex items-center justify-start h-full">
                <img src="{{ asset('img/camera-581126_1280.jpg') }}" class="h-full object-cover"></img>
            </div>
            {{-- Texto en la esquina derecha --}}
            <div class="w-[48%] flex items-center h-full pr-8">
                 <p class="text-orange-600 text-2xl md:text-3xl lg:text-4xl leading-relaxed italic relative pr-8 text-right">
                    <span class="absolute right-0 top-1/2 transform -translate-y-1/2 w-4 h-4 bg-orange-600 rounded-full"></span>
                    Almacena de forma ordenada o<br>
                    adjunta contenido multimedia a los<br>
                    reportes que crees o almacenes
                 </p>
            </div>
        </div>
    </div>
    <div class="w-full h-96 bg-orange-600 flex items-center justify-center">
        {{-- Contenido para la tercera parte (orange-600) --}}
        <div class="flex items-center justify-between w-full h-full">
            {{-- Texto en la esquina izquierda --}}
            <div class="w-1/2 flex items-center h-full pl-4">
                 <p class="text-zinc-900 text-2xl md:text-3xl lg:text-4xl leading-relaxed italic relative pl-8">
                    <span class="absolute left-0 top-1/2 transform -translate-y-1/2 w-4 h-4 bg-zinc-900 rounded-full"></span>
                    Mejora tu eficiencia al acceder y editar en cualquier momento tu información a través de las plataformas
                 </p>
            </div>
            {{-- Imagen en la esquina derecha --}}
            <div class="w-1/2 flex items-center justify-end h-full">
                 <img src="{{ asset('img/press-2333329_1280.jpg') }}" class="h-full object-cover"></img>
            </div>
        </div>
    </div>
</div>

{{-- Tercera sección: Contacto --}}
<div class="w-screen h-screen flex justify-between">
    {{-- Columna izquierda (58% ancho, fondo zinc-900) --}}
    <div class="w-[58%] bg-zinc-900 relative">
        {{-- Rectángulo naranja en el extremo derecho --}}
        <div class="absolute right-0 top-0 bottom-0 w-48 bg-orange-600"></div>
        {{-- Contenido de contacto irá aquí --}}
        <div class="p-8 flex flex-col items-center h-full">
            <div class="mt-12 text-center pr-48">
                <h2 class="text-orange-600 text-2xl italic mb-1">¿Alguna Duda? ¿Sugerencias? ¿Soporte Técnico?</h2>
                <p class="text-orange-600 text-5xl font-bold">Déjanos un mensaje</p>
            </div>
            
            {{-- Círculo con imagen de usuario y formularios --}}
            <div class="mt-8 flex flex-col space-y-4 pr-48">
                <div class="flex items-center">
                    <div class="w-16 h-16 bg-orange-600 rounded-full flex items-center justify-center">
                        <img src="{{ asset('img/user.svg') }}" alt="Usuario" class="w-12 h-12 text-white">
                    </div>
                    <div class="flex-1 pl-4">
                        <input type="text" 
                               placeholder="Escriba su nombre" 
                               class="w-full px-6 py-3 bg-zinc-800 text-white border border-orange-600 rounded-full focus:outline-none focus:border-orange-500">
                    </div>
                </div>
                <div class="flex items-center pl-12">
                    <form class="flex-1">
                        <input type="email" 
                               placeholder="Escriba su correo" 
                               class="w-full px-6 py-3 bg-zinc-800 text-white border border-orange-600 rounded-full focus:outline-none focus:border-orange-500">
                    </form>
                </div>
                <div class="flex items-center pl-12">
                    <form class="flex-1">
                        <textarea 
                            placeholder="Escriba su mensaje" 
                            rows="6"
                            class="w-full px-6 py-3 bg-zinc-800 text-white border border-orange-600 rounded-2xl focus:outline-none focus:border-orange-500 resize-y max-h-48 min-h-32"
                        ></textarea>
                    </form>
                </div>
                <div class="flex items-center pl-12">
                    <button type="submit" class="w-full px-8 py-3 bg-orange-600 text-zinc-900 font-semibold italic rounded-full hover:bg-orange-700 transition-colors duration-300">
                        Enviar Mensaje
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{-- Columna derecha (42% ancho, imagen de fondo) --}}
    <div class="w-[42%] bg-[url('{{ asset('img/pencils-762555_1280.jpg') }}')] bg-cover bg-center relative">
        {{-- Overlay oscuro y difuminado --}}
        <div class="bg-black/60 backdrop-blur-sm absolute inset-0"></div>
        {{-- Texto "Síguenos" y círculos --}}
        <div class="relative z-10 h-full flex flex-col items-center justify-end pb-16">
            <h2 class="text-orange-600 text-6xl font-bold italic mb-4">Síguenos</h2>
            <div class="flex space-x-16">
                <div class="w-12 h-12 bg-orange-600 rounded-full flex items-center justify-center">
                    <img src="{{ asset('img/instagram.svg') }}" alt="Instagram" class="w-10 h-10 text-white">
                </div>
                <div class="w-12 h-12 bg-orange-600 rounded-full flex items-center justify-center">
                    <img src="{{ asset('img/facebook.svg') }}" alt="Facebook" class="w-10 h-10 text-white">
                </div>
                <div class="w-12 h-12 bg-orange-600 rounded-full flex items-center justify-center">
                    <img src="{{ asset('img/discord.svg') }}" alt="Discord" class="w-10 h-10 text-white">
                </div>
            </div>
            <p class="text-orange-600 mt-4 text-2xl font-light">2025-Políticas de privacidad</p>
        </div>
    </div>
</div>

@endsection