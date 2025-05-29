{{-- TODO: cambiar la ubicacion de este archivo --}}
@extends('layout.master')

@section('title', 'Inicio')

@section('content')
<div class="flex min-h-screen">
    <!-- Reportes -->
    <div class="w-1/2 px-2 border-r relative bg-[url(/img/reportes.jpg)] bg-no-repeat bg-cover">
        <div class="bg-black/20 backdrop-blur-sm absolute inset-0 z-0"></div>
        <div class="relative z-10">
            <div class="bg-orange-600 rounded-lg p-4 mb-4">
                <h1 class="text-2xl text-zinc-800 font-semibold">Ultimos reportes realizados</h1>
            </div>
            <div class="bg-orange-600 rounded-lg p-4 mb-4">
                <div class="flex justify-between">
                    <a href="{{ route('reporte.create') }}" class="bg-zinc-800 text-orange-600 px-4 py-2 rounded-full hover:bg-zinc-700 transition-colors duration-200">Crear reporte</a>
                    <a href="{{ route('reporte.index') }}" class="bg-zinc-800 text-orange-600 px-4 py-2 rounded-full hover:bg-zinc-700 transition-colors duration-200">Todos los reportes</a>
                </div>
        </div>
            <div class="bg-zinc-800 rounded-lg p-4">
                <table class="w-full border-separate border-spacing-1">
            <thead>
                <tr>
                            <th class="text-orange-600 p-2 text-left bg-zinc-700">Titulo</th>
                            <th class="text-orange-600 p-2 text-left bg-zinc-700">Contenido</th>
                            <th class="text-orange-600 p-2 text-left bg-zinc-700">Archivos adjuntos</th>
                            <th class="text-orange-600 p-2 text-left bg-zinc-700">Ultima edición</th>
                </tr>
            </thead>
            <tbody>
                @if($reportes->count())
                  @foreach($reportes as $reporte)
                            <tr class="group">
                                <td class="text-orange-600 p-2 bg-zinc-700 group-hover:bg-zinc-600 transition-colors duration-200">{{ $reporte->title }}</td>
                                <td class="text-orange-600 p-2 bg-zinc-700 group-hover:bg-zinc-600 transition-colors duration-200">{{ $reporte->text }}</td>
                                <td class="text-orange-600 p-2 bg-zinc-700 group-hover:bg-zinc-600 transition-colors duration-200">{{ $reporte->media_files->count() }}</td>
                                <td class="text-orange-600 p-2 bg-zinc-700 group-hover:bg-zinc-600 transition-colors duration-200">{{ $reporte->updated_at }}</td>
                    </tr>
                  @endforeach
                @else
                  <tr>
                            <td colspan="4" class="text-orange-600 p-2 text-center bg-zinc-700">No hay reportes agregados</td>
                  </tr>
                @endif
            </tbody>
        </table>
            </div>
        </div>
    </div>
    <!-- Multimedia -->
    <div class="w-1/2 px-2 relative bg-[url(/img/impresion-de-fotografias.jpg)] bg-no-repeat bg-cover">
        <div class="bg-black/20 backdrop-blur-sm absolute inset-0 z-0"></div>
        <div class="relative z-10">
            <div class="bg-orange-600 rounded-lg p-4 mb-4">
                <h1 class="text-2xl text-zinc-800 font-semibold">Ultimos Archivos de medios agregados</h1>
            </div>
            <div class="bg-orange-600 rounded-lg p-4 mb-4">
                <div class="flex justify-between">
                    <a href="{{ route('multimedia.create') }}" class="bg-zinc-800 text-orange-600 px-4 py-2 rounded-full hover:bg-zinc-700 transition-colors duration-200">Agregar archivo de medios</a>
                    <a href="{{ route('multimedia.index') }}" class="bg-zinc-800 text-orange-600 px-4 py-2 rounded-full hover:bg-zinc-700 transition-colors duration-200">Todos los archivos de medios</a>
                </div>
        </div>
            <div class="bg-zinc-800 rounded-lg p-4">
                <table class="w-full border-separate border-spacing-1">
            <thead>
                <tr>
                            <th class="text-orange-600 p-2 text-left bg-zinc-700">Contenido</th>
                            <th class="text-orange-600 p-2 text-left bg-zinc-700">Tipo</th>
                            <th class="text-orange-600 p-2 text-left bg-zinc-700">Ultima edición</th>
                </tr>
            </thead>
            <tbody>
                @if($multimedias->count())
                @foreach($multimedias as $multimedia)
                      <tr class="group">
                          <td class="text-orange-600 p-2 bg-zinc-700 group-hover:bg-zinc-600 transition-colors duration-200">{{ $multimedia->text }}</td>
                          <td class="text-orange-600 p-2 bg-zinc-700 group-hover:bg-zinc-600 transition-colors duration-200">{{ $multimedia->type }}</td>
                          <td class="text-orange-600 p-2 bg-zinc-700 group-hover:bg-zinc-600 transition-colors duration-200">{{ $multimedia->updated_at }}</td>
                  </tr>
                @endforeach
              @else
                <tr>
                      <td colspan="3" class="text-orange-600 p-2 text-center bg-zinc-700">No hay archivos de medias agregados</td>
                </tr>
              @endif
            </tbody>
        </table>
        </div>
    </div>
</div>
@endsection