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
                <h1 class="text-2xl text-zinc-800 font-semibold">Mis últimos reportes</h1>
            </div>
            <div class="bg-orange-600 rounded-lg p-4 mb-4">
                <div class="flex justify-between">
                    <a href="{{ route('reporte.create') }}" class="bg-zinc-800 text-orange-600 px-4 py-2 rounded-full hover:bg-zinc-700 transition-colors duration-200">Crear reporte</a>
                    <a href="{{ route('reporte.index') }}" class="bg-zinc-800 text-orange-600 px-4 py-2 rounded-full hover:bg-zinc-700 transition-colors duration-200">Ver todos mis reportes</a>
                </div>
        </div>
            <div class="bg-zinc-800 rounded-lg p-4">
                <table class="w-full border-separate border-spacing-1">
            <thead>
                <tr>
                            <th class="text-orange-600 p-2 text-left bg-zinc-700">Título</th>
                            <th class="text-orange-600 p-2 text-left bg-zinc-700">Fecha</th>
                            <th class="text-orange-600 p-2 text-left bg-zinc-700">Archivos</th>
                            <th class="text-orange-600 p-2 text-left bg-zinc-700">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @if($reportes->count())
                  @foreach($reportes as $reporte)
                            <tr class="group">
                                <td class="text-orange-600 p-2 bg-zinc-700 group-hover:bg-zinc-600 transition-colors duration-200">{{ $reporte->title }}</td>
                                    <td class="text-orange-600 p-2 bg-zinc-700 group-hover:bg-zinc-600 transition-colors duration-200">{{ $reporte->report_date->format('d/m/Y') }}</td>
                                    <td class="text-orange-600 p-2 bg-zinc-700 group-hover:bg-zinc-600 transition-colors duration-200">
                                        @if($reporte->media_files->count() > 0)
                                            <span class="text-sm">{{ $reporte->media_files->count() }} archivos</span>
                                        @else
                                            <span class="text-sm">Sin archivos</span>
                                        @endif
                                    </td>
                                    <td class="text-orange-600 p-2 bg-zinc-700 group-hover:bg-zinc-600 transition-colors duration-200">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('reporte.create', ['view' => $reporte->id]) }}" 
                                               class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-full text-sm">
                                                Ver
                                            </a>
                                            <a href="{{ route('reporte.edit', $reporte->id) }}" 
                                               class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-full text-sm">
                                                Editar
                                            </a>
                                            <form action="{{ route('reporte.destroy', $reporte->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" 
                                                        onclick="confirmDelete({{ $reporte->id }}, '{{ $reporte->title }}')" 
                                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-full text-sm">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                    </tr>
                  @endforeach
                @else
                  <tr>
                                <td colspan="4" class="text-orange-600 p-2 text-center bg-zinc-700">No has creado ningún reporte aún</td>
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
                <h1 class="text-2xl text-zinc-800 font-semibold">Mis últimos archivos multimedia</h1>
            </div>
            <div class="bg-orange-600 rounded-lg p-4 mb-4">
                <div class="flex justify-between">
                    <a href="{{ route('multimedia.create') }}" class="bg-zinc-800 text-orange-600 px-4 py-2 rounded-full hover:bg-zinc-700 transition-colors duration-200">Agregar archivo multimedia</a>
                    <a href="{{ route('multimedia.index') }}" class="bg-zinc-800 text-orange-600 px-4 py-2 rounded-full hover:bg-zinc-700 transition-colors duration-200">Ver todos mis archivos</a>
                </div>
        </div>
            <div class="bg-zinc-800 rounded-lg p-4">
                <table class="w-full border-separate border-spacing-1">
            <thead>
                <tr>
                            <th class="text-orange-600 p-2 text-left bg-zinc-700">Nombre</th>
                            <th class="text-orange-600 p-2 text-left bg-zinc-700">Tipo</th>
                            <th class="text-orange-600 p-2 text-left bg-zinc-700">Fecha</th>
                            <th class="text-orange-600 p-2 text-left bg-zinc-700">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @if($multimedias->count())
                @foreach($multimedias as $multimedia)
                      <tr class="group">
                                    <td class="text-orange-600 p-2 bg-zinc-700 group-hover:bg-zinc-600 transition-colors duration-200">
                                        {{ $multimedia->text ?: pathinfo($multimedia->path, PATHINFO_FILENAME) }}
                                    </td>
                                    <td class="text-orange-600 p-2 bg-zinc-700 group-hover:bg-zinc-600 transition-colors duration-200">
                                        @if($multimedia->type)
                                            {{ $multimedia->type }}
                                        @else
                                            {{ strtoupper(pathinfo($multimedia->path, PATHINFO_EXTENSION)) }}
                                        @endif
                                    </td>
                                    <td class="text-orange-600 p-2 bg-zinc-700 group-hover:bg-zinc-600 transition-colors duration-200">
                                        {{ $multimedia->media_date ? $multimedia->media_date->format('d/m/Y') : $multimedia->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="text-orange-600 p-2 bg-zinc-700 group-hover:bg-zinc-600 transition-colors duration-200">
                                        <div class="flex space-x-2">
                                            <a href="{{ $multimedia->file_url }}" 
                                               target="_blank"
                                               class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-full text-sm">
                                                Ver
                                            </a>
                                            <form action="{{ route('multimedia.destroy', $multimedia->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" 
                                                        onclick="confirmDeleteMultimedia({{ $multimedia->id }}, '{{ $multimedia->text ?: pathinfo($multimedia->path, PATHINFO_FILENAME) }}')" 
                                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-full text-sm">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                  </tr>
                @endforeach
              @else
                <tr>
                                <td colspan="4" class="text-orange-600 p-2 text-center bg-zinc-700">No has subido ningún archivo multimedia aún</td>
                </tr>
              @endif
            </tbody>
        </table>
        </div>
    </div>
</div>
</div>

<!-- Diálogo de confirmación para reportes -->
<div id="deleteConfirmDialog" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-zinc-800 p-6 rounded-lg shadow-xl max-w-md w-full mx-4">
        <h3 class="text-xl font-semibold text-orange-600 mb-4">Confirmar Eliminación</h3>
        <p class="text-orange-600 mb-6">¿Estás seguro de que deseas eliminar el reporte "<span id="reportTitle" class="font-semibold"></span>"? Esta acción no se puede deshacer.</p>
        <div class="flex justify-end space-x-4">
            <button onclick="closeDeleteDialog()" 
                    class="bg-zinc-700 hover:bg-zinc-600 text-orange-600 px-4 py-2 rounded-lg transition-colors duration-200">
                Cancelar
            </button>
            <button onclick="deleteReport()" 
                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                Eliminar
            </button>
        </div>
    </div>
</div>

<!-- Diálogo de confirmación para multimedia -->
<div id="deleteMultimediaDialog" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-zinc-800 p-6 rounded-lg shadow-xl max-w-md w-full mx-4">
        <h3 class="text-xl font-semibold text-orange-600 mb-4">Confirmar Eliminación</h3>
        <p class="text-orange-600 mb-6">¿Estás seguro de que deseas eliminar el archivo "<span id="multimediaTitle" class="font-semibold"></span>"? Esta acción no se puede deshacer.</p>
        <div class="flex justify-end space-x-4">
            <button onclick="closeDeleteMultimediaDialog()" 
                    class="bg-zinc-700 hover:bg-zinc-600 text-orange-600 px-4 py-2 rounded-lg transition-colors duration-200">
                Cancelar
            </button>
            <button onclick="deleteMultimedia()" 
                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                Eliminar
            </button>
        </div>
    </div>
</div>

<script>
let reportToDelete = null;
let multimediaToDelete = null;

function confirmDelete(id, title) {
    reportToDelete = id;
    document.getElementById('reportTitle').textContent = title;
    document.getElementById('deleteConfirmDialog').classList.remove('hidden');
    document.getElementById('deleteConfirmDialog').classList.add('flex');
}

function closeDeleteDialog() {
    document.getElementById('deleteConfirmDialog').classList.add('hidden');
    document.getElementById('deleteConfirmDialog').classList.remove('flex');
    reportToDelete = null;
}

function deleteReport() {
    if (reportToDelete) {
        const form = document.querySelector(`form[action*="/${reportToDelete}"]`);
        if (form) {
            form.submit();
        }
    }
    closeDeleteDialog();
}

function confirmDeleteMultimedia(id, title) {
    multimediaToDelete = id;
    document.getElementById('multimediaTitle').textContent = title;
    document.getElementById('deleteMultimediaDialog').classList.remove('hidden');
    document.getElementById('deleteMultimediaDialog').classList.add('flex');
}

function closeDeleteMultimediaDialog() {
    document.getElementById('deleteMultimediaDialog').classList.add('hidden');
    document.getElementById('deleteMultimediaDialog').classList.remove('flex');
    multimediaToDelete = null;
}

function deleteMultimedia() {
    if (multimediaToDelete) {
        const form = document.querySelector(`form[action*="/${multimediaToDelete}"]`);
        if (form) {
            form.submit();
        }
    }
    closeDeleteMultimediaDialog();
}

// Cerrar los diálogos si se hace clic fuera de ellos
document.getElementById('deleteConfirmDialog').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteDialog();
    }
});

document.getElementById('deleteMultimediaDialog').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteMultimediaDialog();
    }
});
</script>
@endsection