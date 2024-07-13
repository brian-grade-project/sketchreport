@extends('layout.master')

@section('title', 'Inicio')

@section('content')
<div class="flex">
    <!-- Reportes -->
    <div class="w-1/2 px-2 border-r">
        <h1 class="text-2xl py-4">Ultimos reportes realizados</h1>
        <div class="flex justify-between py-4">
            <a href="{{ route('reporte.create') }}" class="btn btn-sm btn-primary">Crear reporte</a>
            <a href="{{ route('reporte.index') }}" class="btn btn-sm btn-primary">Todos los reportes</a>
        </div>
        <table class="table table-zebra border">
            <thead>
                <tr>
                    <th>Titulo</th>
                    <th>Contenido</th>
                    <th>Archivos adjuntos</th>
                    <th>Ultima edición</th>
                </tr>
            </thead>
            <tbody>
                @if($reportes->count())
                  @foreach($reportes as $reporte)
                    <tr>
                        <td>{{ $reporte->title }}</td>
                        <td>{{ $reporte->text }}</td>
                        <td>{{ $reporte->multimedias->count() }}</td>
                        <td>{{ $reporte->updated_at }}</td>
                    </tr>
                  @endforeach
                @else
                  <tr>
                    <td colspan="3">No hay reportes agregados</td>
                  </tr>
                @endif
            </tbody>
        </table>
    </div>
    <!-- Multimedia -->
    <div class="w-1/2 px-2">
        <h1 class="text-2xl py-4">Ultimos Archivos de medios agregados</h1>
        <div class="flex justify-between py-4">
            <a href="{{ route('multimedia.create') }}" class="btn btn-sm btn-primary">Crear reporte</a>
            <a href="{{ route('multimedia.index') }}" class="btn btn-sm btn-primary">Todos los reportes</a>
        </div>
        <table class="table table-zebra border">
            <thead>
                <tr>
                    <th>Contenido</th>
                    <th>Tipo</th>
                    <th>Ultima edición</th>
                </tr>
            </thead>
            <tbody>
                @if($multimedias->count())
                @foreach($multimedias as $multimedia)
                  <tr>
                      <td>{{ $multimedia->text }}</td>
                      <td>{{ $multimedia->type }}</td>
                      <td>{{ $multimedia->updated_at }}</td>
                  </tr>
                @endforeach
              @else
                <tr>
                  <td colspan="3">No hay archivos de medias agregados</td>
                </tr>
              @endif
            </tbody>
        </table>
    </div>
</div>
@endsection