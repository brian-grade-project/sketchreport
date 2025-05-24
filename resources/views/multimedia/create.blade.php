@extends('layout.master')

@section('title', 'Agregar Multimedia')

@section('content')

<div class="w-[100vw] min-h-[100vh] bg-[url(/img/imglogin.jpg)] bg-no-repeat bg-cover pt-5 pb-10 relative">
    <div class="bg-black/20 backdrop-blur-sm absolute inset-0 w-full h-full"></div>
    <div class="w-[80%] min-h-[90%] bg-zinc-800 m-auto mt-5 mb-10 relative overflow-y-auto rounded-3xl flex">

    <form id="multimediaForm" class="flex flex-row flex-auto flex-wrap relative float-left lg:w-[62%] md:w-[60%] p-4" action="{{ route('multimedia.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="absolute left-[2%] top-[2%] w-[15%] h-[10%]">
           <a href="{{ url()->previous() }}" class="block">
           <svg class="w-[40%] fill-orange-600 hover:bg-orange-600 hover:fill-zinc-800 transition-all duration-500 ease-in-out rounded-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g id="arrow-left"><path d="M11,18.75a.74.74,0,0,1-.53-.22l-6-6a.75.75,0,0,1,0-1.06l6-6a.75.75,0,0,1,1.06,1.06L6.06,12l5.47,5.47a.75.75,0,0,1,0,1.06A.74.74,0,0,1,11,18.75Z"/><path d="M19,12.75H5a.75.75,0,0,1,0-1.5H19a.75.75,0,0,1,0,1.5Z"/></g></svg>
           </a>
        </div>

            <div class="relative ml-16 lg:w-60 md:w-[48%]">
                <label for="titulo" class="text-xl text-orange-600 block ml-5 mt-10 pb-1 font-light">Titulo de grupo</label>
                <input type="text" class="bg-white rounded-full w-full p-1" name="titulo" id="titulo" placeholder="Ingrese titulo">
            </div>
        
            <div class="relative ml-14 w-[25%]">
                <label for="media_date" class="text-xl text-orange-600 block mt-10 ml-4 font-light pb-1">Fecha</label>
                <input type="date" class="bg-white rounded-full w-full p-1" name="media_date" id="media_date">
            </div>

            <div class="relative float-left mt-8 ml-16 w-[40%]">
              <label for="media" class="text-xl text-orange-600 block pb-1 font-light">Archivos multimedia</label>
              <input type="file" multiple class="resize-none bg-white rounded w-full h-10 rounded-full" name="media[]" id="media" accept="image/*,video/*,audio/*,.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt">
            </div>

            <script>
            function handleDrop(e) {
                console.log('Drop event triggered');
                e.preventDefault();
                e.stopPropagation();
                
                const files = e.dataTransfer.files;
                console.log('Files in drop:', files.length);
                
                if (files && files.length > 0) {
                    const fileInput = document.getElementById('media');
                    console.log('File input found:', !!fileInput);
                    
                    try {
                        // Crear un nuevo DataTransfer object
                        const dataTransfer = new DataTransfer();
                        
                        // Agregar los archivos al DataTransfer
                        for (let i = 0; i < files.length; i++) {
                            dataTransfer.items.add(files[i]);
                        }
                        
                        // Asignar los archivos al input
                        fileInput.files = dataTransfer.files;
                        console.log('Files assigned to input:', fileInput.files.length);
                        
                        // Disparar el evento change manualmente
                        const event = new Event('change', { bubbles: true });
                        fileInput.dispatchEvent(event);
                        
                        // Mostrar la vista previa
                        handleFiles({ target: { files: files } });
                    } catch (error) {
                        console.error('Error in handleDrop:', error);
                    }
                }
                return false;
            }

            // Prevenir el comportamiento por defecto del navegador
            document.ondragover = function(e) {
                e.preventDefault();
                return false;
            };

            document.ondrop = function(e) {
                e.preventDefault();
                return false;
            };

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
                
                console.log('Preview section found:', !!previewSection);
                console.log('Preview container found:', !!previewContainer);
                
                // Asegurarse de que la sección de vista previa sea visible
                previewSection.classList.remove('hidden');
                
                // No limpiar el contenedor para mantener los archivos existentes
                // previewContainer.innerHTML = '';
                
                files.forEach((file, index) => {
                    console.log(`Processing file ${index + 1}:`, file.name, 'Type:', file.type);
                    const preview = createPreview(file);
                    if (preview) {
                        previewContainer.appendChild(preview);
                        console.log(`Preview added for file ${index + 1}`);
                    } else {
                        console.log(`Failed to create preview for file ${index + 1}`);
                    }
                });
            }

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

            document.addEventListener('DOMContentLoaded', function() {
                console.log('DOM Content Loaded');
                const fileInput = document.getElementById('media');
                const form = document.getElementById('multimediaForm');

                console.log('File input found:', !!fileInput);
                console.log('Form found:', !!form);

                // Actualizar el event listener para el input de archivos
                fileInput.addEventListener('change', function(e) {
                    console.log('File input change event triggered');
                    console.log('Number of files selected:', e.target.files.length);
                    if (e.target.files.length > 0) {
                        handleFiles(e);
                    }
                });

                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const formData = new FormData(form);
                    
                    if (fileInput.files.length > 0) {
                        formData.delete('media[]');
                        for (let i = 0; i < fileInput.files.length; i++) {
                            formData.append('media[]', fileInput.files[i]);
                        }
                    }
                    
                    // Enviar el formulario normalmente
                    form.submit();
                });
            });
            </script>

            <div id="dropZone" 
                 class="relative float-left flex flex-col justify-center items-center ml-16 w-[86%] h-48 border-4 border-dashed border-orange-600 hover:bg-zinc-300/40 cursor-pointer mt-4 transition-all duration-300" 
                 style="min-height: 200px;"
                 onclick="document.getElementById('media').click()"
                 ondragover="event.preventDefault(); event.stopPropagation(); this.classList.add('bg-zinc-300/40'); return false;"
                 ondragenter="event.preventDefault(); event.stopPropagation(); this.classList.add('bg-zinc-300/40'); return false;"
                 ondragleave="event.preventDefault(); event.stopPropagation(); this.classList.remove('bg-zinc-300/40'); return false;"
                 ondrop="event.preventDefault(); event.stopPropagation(); this.classList.remove('bg-zinc-300/40'); handleDrop(event); return false;">
              <div class="w-full h-full flex flex-col justify-center items-center">
                <p class="text-xl text-orange-600 block pb-1 pt-2 font-light font-medium">Arrastra para subir</p>
                <p class="text-xl text-orange-600 block font-light text-center">Suelta en esta área tu contenido para que se pueda subir</p>
                <img src="/img/cloud-upload.svg" alt="Cloud-upload" class="flex m-auto w-[15%] lg:w-[25%] xl:w-[15%] md:w-[25%] mt-4">
              </div>
            </div>

            <!-- Preview Section -->
            <div id="previewSection" class="relative float-left ml-16 w-[86%] mt-8 bg-zinc-800/50 p-4 rounded-lg">
                <h3 class="text-xl text-orange-600 mb-4 font-light">Vista Previa de Archivos</h3>
                <div id="previewContainer" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <!-- Previews will be added here dynamically -->
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
                </div>
            </div>
            
            <div class="relative w-[100%] flex flex-row mt-16 mb-8">
                <div class="relative block ml-16 lg:w-[25%] md:w-[25%] rounded-full">
                    <button type="submit" class="btn-sm text-center bg-orange-600 w-full rounded-full text-xl font-light h-full hover:bg-orange-700 hover:text-white hover:font-semibold">Guardar</button>
                </div>

                <div class="relative block ml-16 lg:w-[45%] md:w-[45%] rounded-full">
                    <button type="submit" name="export" value="1" class="btn-sm text-center bg-orange-600 w-full rounded-full text-xl font-light h-full hover:bg-orange-700 hover:text-white hover:font-semibold">Guardar y Exportar</button>
                </div>
            </div>
    </form>   

    <div class="bg-orange-600 w-2/6 flex-grow float-right overflow-clip relative m-0 p-0">
        <div class="w-32 h-32 md:w-36 md:h-36 lg:w-40 lg:h-40 xl:w-44 xl:h-44 2xl:w-48 2xl:h-48 bg-zinc-800 absolute rounded-full 
            ml-[15%] md:ml-[20%] lg:ml-[25%] xl:ml-[30%] 2xl:ml-[30%]
            mt-[10%] md:mt-[15%] lg:mt-[20%] xl:mt-[20%] 2xl:mt-[20%]
            flex items-center justify-center">
            <img src="/img/file-import2.svg" alt="file_import" 
                class="w-20 h-20 md:w-24 md:h-24 lg:w-28 lg:h-28 xl:w-32 xl:h-32 2xl:w-36 2xl:h-36 object-contain">
        </div>
            <div class="w-[60%] h-[100%] bg-zinc-800 rotate-45 relative top-60 right-0 left-28"></div>
        </div>
    </div>
</div>

@endsection