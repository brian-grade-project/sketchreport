@extends('layout.master')

@section('title', 'Acerca de Nosotros')

@section('content')

{{-- Primera sección con imagen de fondo --}}
<div class="w-screen h-screen bg-[url('{{ asset('img/saber-escribir-escritor-periodista.jpg') }}')] bg-no-repeat bg-cover relative">
    <div class="bg-black/80 backdrop-blur-sm absolute inset-0"></div>
    <div class="relative z-10 w-full h-full flex flex-col items-center justify-center">
        {{-- Botones de navegación --}}
        <nav class="w-full flex flex-row p-3 absolute top-0 left-0">
             <ul class="flex flex-row text-xl sm:text-2xl lg:space-x-8 md:space-x-2 p-3 ml-2">
                <li> <a class="md:text-xl text-orange-600 hover:transition-all duration-500 ease-in-out hover:text-zinc-800 hover:bg-orange-600 pointer rounded-full px-3 py-2" href="{{ route('home') }}">Inicio</a></li>
                <li> <a class="md:text-xl text-orange-600 hover:transition-all duration-500 ease-in-out hover:text-zinc-800 hover:bg-orange-600 pointer rounded-full px-3 py-2" href="#caracteristicas">Información</a></li>
                <li> <a class="md:text-xl text-orange-600 hover:transition-all duration-500 ease-in-out hover:text-zinc-800 hover:bg-orange-600 pointer rounded-full px-3 py-2" href="#contacto">Contacto</a></li>
            </ul>
        </nav>

        {{-- Contenido principal de la primera sección (logo y texto) --}}
        <div class="flex flex-col items-center text-center px-4 max-w-4xl">
             <img src="{{ asset('img/logotipo1.svg') }}" class="w-64 sm:w-72 md:w-80 lg:w-96 xl:w-104 2xl:w-112 mb-8" alt="Logo"></img>
             <p class="text-white text-base sm:text-lg md:text-xl leading-relaxed font-light px-4 sm:px-6 md:px-8">
                El avance del mundo digital ha mejorado nuestra vida cotidiana y laboral, proporcionando herramientas para aumentar el rendimiento en diferentes áreas, estando el periodismo incluido. Los sistemas de información con sus bases de datos organizadas son ampliamente utilizados por su rapidez, seguridad y precisión en la solución de problemas y necesidades específicas. es alli donde <span class="text-orange-600 font-bold">SketchReport</span> hace presencia. Este sistema permitirá llevar un registro detallado de noticias, material multimedia y eventos, facilitando la visualización de evidencias en tiempo real, lo que ayudará a mejorar la eficacia y reducir la incertidumbre característica de esta rama.
             </p>
        </div>
    </div>
</div>

{{-- Segunda sección con descripción de la aplicación --}}
<div id="caracteristicas" class="w-screen min-h-screen relative flex flex-col">
    <div class="w-full h-64 sm:h-72 md:h-80 lg:h-96 bg-orange-600 flex items-center justify-center">
        <div class="flex items-center justify-between w-full h-full">
            <div class="w-1/2 flex items-center h-full pl-4">
                <p class="text-zinc-900 text-xl sm:text-2xl md:text-3xl lg:text-4xl leading-relaxed italic relative pl-8">
                    <span class="absolute left-0 top-1/2 transform -translate-y-1/2 w-3 sm:w-4 h-3 sm:h-4 bg-zinc-900 rounded-full"></span>
                    Crea, registra, almacena y exporta tus propios reportes a través de una cómoda interfaz
                </p>
            </div>
            <div class="w-1/2 flex items-center justify-end h-full">
                <img src="{{ asset('img/workspace-766045_1280.jpg') }}" class="h-full object-cover" alt="Workspace"></img>
            </div>
        </div>
    </div>
    <div class="w-full h-64 sm:h-72 md:h-80 lg:h-96 bg-zinc-900 flex items-center justify-center">
        <div class="flex items-center justify-between w-full h-full">
            <div class="w-1/2 flex items-center justify-start h-full">
                <img src="{{ asset('img/camera-581126_1280.jpg') }}" class="h-full object-cover" alt="Camera"></img>
            </div>
            <div class="w-[48%] flex items-center h-full pr-4 sm:pr-6 md:pr-8">
                 <p class="text-orange-600 text-xl sm:text-2xl md:text-3xl lg:text-4xl leading-relaxed italic relative pr-8 text-right">
                    <span class="absolute right-0 top-1/2 transform -translate-y-1/2 w-3 sm:w-4 h-3 sm:h-4 bg-orange-600 rounded-full"></span>
                    Almacena de forma ordenada o<br>
                    adjunta contenido multimedia a los<br>
                    reportes que crees o almacenes
                 </p>
            </div>
        </div>
    </div>
    <div class="w-full h-64 sm:h-72 md:h-80 lg:h-96 bg-orange-600 flex items-center justify-center">
        <div class="flex items-center justify-between w-full h-full">
            <div class="w-1/2 flex items-center h-full pl-4">
                 <p class="text-zinc-900 text-xl sm:text-2xl md:text-3xl lg:text-4xl leading-relaxed italic relative pl-8">
                    <span class="absolute left-0 top-1/2 transform -translate-y-1/2 w-3 sm:w-4 h-3 sm:h-4 bg-zinc-900 rounded-full"></span>
                    Mejora tu eficiencia al acceder y editar en cualquier momento tu información a través de las plataformas
                 </p>
            </div>
            <div class="w-1/2 flex items-center justify-end h-full">
                 <img src="{{ asset('img/press-2333329_1280.jpg') }}" class="h-full object-cover" alt="Press"></img>
            </div>
        </div>
    </div>
</div>

{{-- Tercera sección: Contacto --}}
<div id="contacto" class="w-screen h-screen flex flex-col lg:flex-row">
    {{-- Columna izquierda --}}
    <div class="w-full lg:w-[58%] bg-zinc-900 relative">
        <div class="absolute right-0 top-0 bottom-0 w-24 sm:w-32 md:w-40 lg:w-48 bg-orange-600"></div>
        <div class="p-4 sm:p-6 md:p-8 flex flex-col items-center h-full">
            <div class="mt-8 sm:mt-10 md:mt-12 text-center pr-0 sm:pr-24 md:pr-48">
                <h2 class="text-orange-600 text-xl sm:text-2xl italic mb-1">¿Alguna Duda? ¿Sugerencias? ¿Soporte Técnico?</h2>
                <p class="text-orange-600 text-3xl sm:text-4xl md:text-5xl font-bold">Déjanos un mensaje</p>
            </div>
            
            {{-- Círculo con imagen de usuario y formularios --}}
            <div class="mt-6 sm:mt-8 flex flex-col space-y-4 pr-0 sm:pr-24 md:pr-48 w-full max-w-md sm:max-w-md md:max-w-md lg:max-w-md">
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
    {{-- Columna derecha --}}
    <div class="w-full lg:w-[42%] bg-[url('{{ asset('img/pencils-762555_1280.jpg') }}')] bg-cover bg-center relative">
        <div class="bg-black/60 backdrop-blur-sm absolute inset-0"></div>
        <div class="relative z-10 h-full flex flex-col items-center justify-end pb-8 sm:pb-12 md:pb-16">
            <h2 class="text-orange-600 text-4xl sm:text-5xl md:text-6xl font-bold italic mb-4">Síguenos</h2>
            <div class="flex space-x-8 sm:space-x-12 md:space-x-16">
                <div class="w-10 sm:w-11 md:w-12 h-10 sm:h-11 md:h-12 bg-orange-600 rounded-full flex items-center justify-center">
                    <img src="{{ asset('img/instagram.svg') }}" alt="Instagram" class="w-8 sm:w-9 md:w-10 h-8 sm:h-9 md:h-10 text-white">
                </div>
                <div class="w-10 sm:w-11 md:w-12 h-10 sm:h-11 md:h-12 bg-orange-600 rounded-full flex items-center justify-center">
                    <img src="{{ asset('img/facebook.svg') }}" alt="Facebook" class="w-8 sm:w-9 md:w-10 h-8 sm:h-9 md:h-10 text-white">
                </div>
                <div class="w-10 sm:w-11 md:w-12 h-10 sm:h-11 md:h-12 bg-orange-600 rounded-full flex items-center justify-center">
                    <img src="{{ asset('img/discord.svg') }}" alt="Discord" class="w-8 sm:w-9 md:w-10 h-8 sm:h-9 md:h-10 text-white">
                </div>
            </div>
            <p class="text-orange-600 mt-4 text-xl sm:text-2xl font-light">2025-Políticas de privacidad</p>
        </div>
    </div>
</div>

@endsection