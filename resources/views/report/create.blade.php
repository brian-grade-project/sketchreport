@extends('layout.master')

@section('title', isset($isReadOnly) && $isReadOnly ? 'Ver Reporte' : (isset($isEdit) ? 'Editar Reporte' : 'Crear Reporte'))

@section('content')
<div class="w-[100vw] min-h-[100vh] bg-[url(/img/imglogin.jpg)] bg-no-repeat bg-cover pt-5 pb-10 relative">
    <div class="bg-black/20 backdrop-blur-sm absolute inset-0 w-full h-full"></div>
    <div class="w-[80%] min-h-[90%] bg-zinc-800 m-auto mt-5 mb-10 relative overflow-y-auto rounded-3xl flex">

    <form id="reportForm" class="flex flex-row flex-auto flex-wrap relative float-left lg:w-[62%] md:w-[60%] p-4" 
          action="{{ isset($reporte) ? route('reporte.update', $reporte->id) : route('reporte.store') }}" 
          method="POST" 
          enctype="multipart/form-data">
        @csrf
        @if(isset($reporte))
            @method('PUT')
        @endif

        <div class="absolute left-[2%] top-[2%] w-[15%] h-[10%]">
           <a href="{{ route('home') }}" class="block">
           <svg class="w-[40%] fill-orange-600 hover:bg-orange-600 hover:fill-zinc-800 transition-all duration-500 ease-in-out rounded-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g id="arrow-left"><path d="M11,18.75a.74.74,0,0,1-.53-.22l-6-6a.75.75,0,0,1,0-1.06l6-6a.75.75,0,0,1,1.06,1.06L6.06,12l5.47,5.47a.75.75,0,0,1,0,1.06A.74.74,0,0,1,11,18.75Z"/><path d="M19,12.75H5a.75.75,0,0,1,0-1.5H19a.75.75,0,0,1,0,1.5Z"/></g></svg>
           </a>
        </div>

            <div class="relative ml-16 lg:w-60 md:w-[48%]">
                <label for="title" class="text-xl text-orange-600 block ml-5 mt-10 pb-1 font-light">Título del reporte</label>
                <input type="text" class="bg-white rounded-full w-full p-1" name="title" id="title" 
                    value="{{ isset($reporte) ? $reporte->title : '' }}"
                    {{ isset($isReadOnly) && $isReadOnly ? 'readonly' : '' }}
                    placeholder="Ingrese título">
            </div>
        
            <div class="relative ml-14 w-[25%]">
                <label for="report_date" class="text-xl text-orange-600 block mt-10 ml-4 font-light pb-1">Fecha</label>
                <input type="date" class="bg-white rounded-full w-full p-1" name="report_date" id="report_date"
                    value="{{ isset($reporte) ? $reporte->report_date->format('Y-m-d') : '' }}"
                    {{ isset($isReadOnly) && $isReadOnly ? 'readonly' : '' }}>
            </div>

            <div class="relative float-left mt-8 ml-16 w-[86%]">
                <label for="content" class="text-xl text-orange-600 block pb-1 font-light">Contenido del reporte</label>
                <textarea class="bg-white rounded-lg w-full p-4 min-h-[200px] resize-y" name="content" id="content" 
                    {{ isset($isReadOnly) && $isReadOnly ? 'readonly' : '' }}
                    placeholder="Ingrese el contenido del reporte">{{ isset($reporte) ? $reporte->text : '' }}</textarea>
            </div>

            @if(!isset($isReadOnly) || !$isReadOnly)
            <div class="relative float-left mt-8 ml-16 w-[40%]">
                <label for="media" class="text-xl text-orange-600 block pb-1 font-light">Archivos multimedia</label>
                <input type="file" multiple class="resize-none bg-white rounded w-full h-10 rounded-full" name="media[]" id="media" accept="image/*,video/*,audio/*,.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt">
            </div>
            @endif

            <!-- Preview Section -->
            <div id="previewSection" class="relative float-left ml-16 w-[86%] mt-8 bg-zinc-800/50 p-4 rounded-lg">
                <h3 class="text-xl text-orange-600 mb-4 font-light">Vista Previa de Archivos</h3>
                <div id="previewContainer" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @if(isset($reporte) && $reporte->media_files)
                        @foreach($reporte->media_files as $media)
                            <div class="relative bg-zinc-700 rounded-lg p-2 group">
                                @if(str_starts_with($media->file_type, 'image/'))
                                    <img src="{{ asset('storage/' . $media->file_path) }}" 
                                         alt="Preview" 
                                         class="w-full aspect-square object-cover rounded-lg">
                                @elseif(str_starts_with($media->file_type, 'video/'))
                                    <video src="{{ asset('storage/' . $media->file_path) }}" 
                                           class="w-full aspect-square object-cover rounded-lg"
                                           controls></video>
                                @elseif(str_starts_with($media->file_type, 'audio/'))
                                    <audio src="{{ asset('storage/' . $media->file_path) }}" 
                                           class="w-full"
                                           controls></audio>
                                @else
                                    <div class="w-full aspect-square bg-zinc-600 rounded-lg flex items-center justify-center">
                                        <svg class="w-16 h-16 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2,0,0,0,2-2V9.414a1 1,0,0,0-.293-.707l-5.414-5.414A1 1,0,0,0,12.586 3H7a2 2,0,0,0-2 2v14a2 2,0,0,0,2 2z"></path>
                                            <text x="8" y="18" class="text-xs fill-current">{{ strtoupper(pathinfo($media->file_path, PATHINFO_EXTENSION)) }}</text>
                                        </svg>
                                    </div>
                                @endif
                                <div class="mt-2 text-white text-sm truncate">{{ basename($media->file_path) }}</div>
                            </div>
                        @endforeach
                    @endif

                    @if(!isset($isReadOnly) || !$isReadOnly)
                    <!-- Botón de agregar más -->
                    <div class="relative bg-zinc-700 rounded-lg p-2">
                        <button type="button" onclick="document.getElementById('media').click()" 
                                class="w-full aspect-square bg-zinc-600 rounded-lg flex items-center justify-center hover:bg-zinc-500 transition-colors duration-200 group">
                            <div class="w-12 h-12 border-4 border-orange-600 rounded-full flex items-center justify-center group-hover:border-orange-500">
                                <svg class="w-8 h-8 fill-orange-600 group-hover:fill-orange-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g id="plus"><path d="M12.75,11.25V5a.75.75,0,0,0-1.5,0v6.25H5a.75.75,0,0,0,0,1.5h6.25V19a.76.76,0,0,0,.75.75.75.75,0,0,0,.75-.75V12.75H19a.75.75,0,0,0,.75-.75.76.76,0,0,0-.75-.75Z"/></g></svg>
                            </div>
                        </button>
                        <div class="mt-2 text-white text-sm text-center">Agregar archivo</div>
                    </div>
                    @endif
                </div>
            </div>

            @if(!isset($isReadOnly) || !$isReadOnly)
            <div class="relative w-[100%] flex flex-row mt-16 mb-8">
                <div class="relative block ml-16 lg:w-[25%] md:w-[25%] rounded-full">
                    <button type="submit" class="btn-sm text-center bg-orange-600 w-full rounded-full text-xl font-light h-full hover:bg-orange-700 hover:text-white hover:font-semibold">
                        {{ isset($isEdit) ? 'Actualizar' : 'Guardar' }}
                    </button>
                </div>

                <div class="relative block ml-16 lg:w-[45%] md:w-[45%] rounded-full">
                    <button type="button" id="saveAndExportBtn" class="btn-sm text-center bg-orange-600 w-full rounded-full text-xl font-light h-full hover:bg-orange-700 hover:text-white hover:font-semibold">
                        {{ isset($isEdit) ? 'Actualizar y Exportar' : 'Guardar y Exportar' }}
                    </button>
                </div>
            </div>
            @endif
    </form>   

    <div class="bg-orange-600 w-2/6 flex-grow float-right overflow-clip relative m-0 p-0">
        <div class="w-32 h-32 md:w-36 md:h-36 lg:w-40 lg:h-40 xl:w-44 xl:h-44 2xl:w-48 2xl:h-48 bg-zinc-800 absolute rounded-full 
            ml-[15%] md:ml-[20%] lg:ml-[25%] xl:ml-[30%] 2xl:ml-[30%]
            mt-[10%] md:mt-[15%] lg:mt-[20%] xl:mt-[20%] 2xl:mt-[20%]
            flex items-center justify-center">
            <img src="/img/file-import2.svg" alt="file_import" class="w-20 h-20 md:w-24 md:h-24 lg:w-28 lg:h-28 xl:w-32 xl:h-32 2xl:w-36 2xl:h-36 object-contain">
        </div>
        <div class="w-[60%] h-[100%] bg-zinc-800 rotate-45 relative top-60 right-0 left-28"></div>
    </div>
            </div>
            </div>

@if(!isset($isReadOnly) || !$isReadOnly)
<script>
// Agregar el event listener para el input de archivos
document.getElementById('media').addEventListener('change', handleFiles);

// Funciones auxiliares (pueden estar fuera del DOMContentLoaded si no interactúan directamente con el DOM al inicio)
// Función para crear vista previa de archivos
function createPreview(file) {
    console.log('Creating preview for:', file.name);
    const div = document.createElement('div');
    div.className = 'relative bg-zinc-700 rounded-lg p-2 group';
    
    // Botón de eliminar
    const deleteButton = document.createElement('button');
    deleteButton.className = 'absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200 hover:bg-red-600 z-10';
    deleteButton.innerHTML = '×';
    deleteButton.onclick = function(e) {
        e.preventDefault();
        e.stopPropagation();
        removeFile(file);
        div.remove();
    };
    div.appendChild(deleteButton);
    
    const preview = document.createElement('div');
    preview.className = 'aspect-square bg-zinc-600 rounded-lg overflow-hidden';
    
    const fileType = file.type.split('/')[0];
    console.log('File type:', fileType);
    
    try {
        if (fileType === 'image') {
            const img = document.createElement('img');
            img.className = 'w-full h-full object-cover';
            img.file = file;
            preview.appendChild(img);
            
            const reader = new FileReader();
            reader.onload = (e) => {
                img.src = e.target.result;
                console.log('Image preview loaded for:', file.name);
            };
            reader.onerror = (error) => {
                console.error('Error loading image:', error);
            };
            reader.readAsDataURL(file);
        } else if (fileType === 'video') {
            const video = document.createElement('video');
            video.className = 'w-full h-full object-cover';
            video.controls = true;
            video.src = URL.createObjectURL(file);
            preview.appendChild(video);
            console.log('Video preview created for:', file.name);
        } else if (fileType === 'audio') {
            const audio = document.createElement('audio');
            audio.className = 'w-full';
            audio.controls = true;
            audio.src = URL.createObjectURL(file);
            preview.appendChild(audio);
            console.log('Audio preview created for:', file.name);
        } else {
            // Para documentos y otros tipos de archivo
            const icon = document.createElement('div');
            icon.className = 'w-full h-full flex items-center justify-center';
            
            // Determinar el ícono basado en la extensión del archivo
            const extension = file.name.split('.').pop().toLowerCase();
            let iconSvg = '';
            
            switch(extension) {
                case 'pdf':
                    iconSvg = `<svg class="w-16 h-16 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        <text x="8" y="18" class="text-xs fill-current">PDF</text>
                    </svg>`;
                    break;
                case 'doc':
                case 'docx':
                    iconSvg = `<svg class="w-16 h-16 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        <text x="8" y="18" class="text-xs fill-current">DOC</text>
                    </svg>`;
                    break;
                default:
                    iconSvg = `<svg class="w-16 h-16 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        <text x="8" y="18" class="text-xs fill-current">${extension.toUpperCase()}</text>
                    </svg>`;
            }
            
            icon.innerHTML = iconSvg;
            preview.appendChild(icon);
            console.log('Document preview created for:', file.name);
        }

        const info = document.createElement('div');
        info.className = 'mt-2 text-white text-sm truncate';
        info.textContent = file.name;
        
        div.appendChild(preview);
        div.appendChild(info);
        
        return div;
    } catch (error) {
        console.error('Error creating preview:', error);
        return null;
    }
}

function removeFile(fileToRemove) {
    const fileInput = document.getElementById('media');
    const dt = new DataTransfer();
    const files = fileInput.files;

    for (let i = 0; i < files.length; i++) {
        if (files[i] !== fileToRemove) {
            dt.items.add(files[i]);
        }
    }

    fileInput.files = dt.files;
    console.log('File removed:', fileToRemove.name);
}

function handleFiles(e) {
    console.log('handleFiles called');
    const files = [...e.target.files];
    console.log('Files in handleFiles:', files.length);
    
    if (files.length === 0) {
        console.log('No files to process');
        return;
    }

    const previewSection = document.getElementById('previewSection');
    const previewContainer = document.getElementById('previewContainer');

    // Remove all dynamically added previews, keep existing media and the add button placeholder
    // Note: The add button is removed and re-added later, so we just clear the content here.
    while (previewContainer.lastChild) {
        previewContainer.removeChild(previewContainer.lastChild);
    }
    
    // Remover el botón de agregar si existe
    const addButton = previewContainer.querySelector('.relative.bg-zinc-700.rounded-lg.p-2');
    if (addButton) {
        addButton.remove();
    }
    
    files.forEach(file => {
        const preview = createPreview(file);
        if (preview) {
            previewContainer.appendChild(preview);
        }
    });
    
    // Agregar el botón de agregar al final
    const addButtonDiv = document.createElement('div');
    addButtonDiv.className = 'relative bg-zinc-700 rounded-lg p-2';
    addButtonDiv.innerHTML = `
        <button type="button" onclick="document.getElementById('media').click()" 
                class="w-full aspect-square bg-zinc-600 rounded-lg flex items-center justify-center hover:bg-zinc-500 transition-colors duration-200 group">
            <div class="w-12 h-12 border-4 border-orange-600 rounded-full flex items-center justify-center group-hover:border-orange-500">
                <svg class="w-8 h-8 fill-orange-600 group-hover:fill-orange-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g id="plus"><path d="M12.75,11.25V5a.75.75,0,0,0-1.5,0v6.25H5a.75.75,0,0,0,0,1.5h6.25V19a.76.76,0,0,0,.75.75.75.75,0,0,0,.75-.75V12.75H19a.75.75,0,0,0,.75-.75.76.76,0,0,0-.75-.75Z"/></g></svg>
            </div>
        </button>
        <div class="mt-2 text-white text-sm text-center">Agregar archivo</div>
    `;
    previewContainer.appendChild(addButtonDiv);
}

// Script para manejar el botón de Guardar y Exportar
document.getElementById('saveAndExportBtn').addEventListener('click', async function(event) {
    event.preventDefault();

    const form = document.getElementById('reportForm');
    const formData = new FormData(form);
    const actionUrl = form.getAttribute('action');
    const saveBtn = form.querySelector('button[type="submit"]');
    const saveExportBtn = document.getElementById('saveAndExportBtn');

    // Deshabilitar botones
    if (saveBtn) saveBtn.disabled = true;
    saveExportBtn.disabled = true;
    saveExportBtn.textContent = 'Procesando...';

    try {
        console.log('Iniciando guardado del reporte...');
        // Paso 1: Guardar/Actualizar el reporte
        const response = await fetch(actionUrl, {
            method: form.getAttribute('method'),
            body: formData,
            headers: {
                'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin'
        });

        console.log('Respuesta recibida:', response);
        
        // Verificar si la respuesta es JSON
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            const text = await response.text();
            console.error('Respuesta no JSON:', text);
            throw new Error('La respuesta del servidor no es JSON. Tipo de contenido: ' + contentType);
        }

        const data = await response.json();
        console.log('Datos recibidos:', data);

        if (data.success) {
            console.log('Reporte guardado exitosamente');
            // Paso 2: Si el guardado fue exitoso, iniciar la descarga del ZIP
            if (data.report_id) {
                console.log('Iniciando descarga del ZIP para el reporte:', data.report_id);
                const exportUrl = '{{ route('reporte.export', ['report' => ':reportId']) }}'.replace(':reportId', data.report_id);
                
                // Crear un iframe oculto para la descarga
                const iframe = document.createElement('iframe');
                iframe.style.display = 'none';
                document.body.appendChild(iframe);
                
                // Iniciar la descarga
                iframe.src = exportUrl;
                
                // Remover el iframe después de un tiempo
                setTimeout(() => {
                    document.body.removeChild(iframe);
                }, 5000);

                // Redirigir al índice después de iniciar la descarga
                setTimeout(() => {
                    window.location.href = '{{ route('reporte.index') }}';
                }, 200);

            } else {
                throw new Error('No se recibió el ID del reporte en la respuesta');
            }
        } else {
            // Mostrar error si el guardado falló
            let errorMessage = data.message || 'Error desconocido al guardar el reporte.';
            if (data.errors) {
                for (const field in data.errors) {
                    errorMessage += '\n- ' + data.errors[field].join(', ');
                }
            }
            throw new Error(errorMessage);
        }
    } catch (error) {
        console.error('Error detallado:', error);
        alert('Error: ' + error.message);
    } finally {
        // Re-habilitar botones
        if (saveBtn) saveBtn.disabled = false;
        saveExportBtn.disabled = false;
        saveExportBtn.textContent = '{{ isset($isEdit) ? 'Actualizar y Exportar' : 'Guardar y Exportar' }}';
    }
});
</script>
@endif
@endsection