@extends('layout.master')

@section('content')
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lista de Multimedia</title>
  <style>
    /* Estilos personalizados para la paginación */
    .pagination {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 1rem;
        padding: 1rem;
        background-color: rgb(234 88 12); /* bg-orange-600 */
        border-radius: 0.5rem;
    }
    
    .pagination > * {
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        background-color: rgb(39 39 42); /* bg-zinc-800 */
        color: rgb(234 88 12); /* text-orange-600 */
        transition: all 0.2s;
        text-decoration: none;
    }
    
    .pagination > *:hover {
        background-color: rgb(39 39 42); /* bg-zinc-800 */
        color: rgb(234 88 12); /* text-orange-600 */
        transform: scale(1.05);
    }
    
    .pagination .active {
        background-color: rgb(39 39 42); /* bg-zinc-800 */
        color: rgb(234 88 12); /* text-orange-600 */
        font-weight: bold;
    }
    
    .pagination .disabled {
        opacity: 0.5;
        cursor: not-allowed;
        pointer-events: none;
    }

    /* Estilos para los enlaces de la paginación */
    .pagination a {
        text-decoration: none;
    }

    /* Estilos para el texto de la paginación */
    .pagination span {
        display: inline-block;
    }
  </style>
</head>
<body>
<div class="w-[100vw] h-[100vh] bg-[url(/img/imglogin.jpg)] bg-no-repeat bg-cover bg-fixed pt-5 relative">
    <div class="bg-black/20 backdrop-blur-sm w-[100vw] absolute inset-0 z-0"></div>

    <div class="w-[80%] md:w-[90%] h-[80vh] bg-orange-600 m-auto mt-5 p-8 pt-3 rounded-xl relative shadow-xl overflow-hidden flex flex-col">

      <div class="w-[15%] h-[10%] md:h-[5%] mb-5 md:mb-5 lg:mb-7 lg:mt-1 xl:mb-10 xl:w-[14%] 2xl:mb-12">
          <a href="{{ route('home') }}" class="block">
          <svg class="w-[30%] fill-zinc-800 hover:bg-zinc-800 hover:fill-orange-600 transition-all duration-500 ease-in-out rounded-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g id="arrow-left"><path d="M11,18.75a.74.74,0,0,1-.53-.22l-6-6a.75.75,0,0,1,0-1.06l6-6a.75.75,0,0,1,1.06,1.06L6.06,12l5.47,5.47a.75.75,0,0,1,0,1.06A.74.74,0,0,1,11,18.75Z"/><path d="M19,12.75H5a.75.75,0,0,1,0-1.5H19a.75.75,0,0,1,0,1.5Z"/></g></svg>
          </a>
      </div>

      <div class="mb-2 relative bg-zinc-700 rounded-md w-[100%] p-5 flex items-center gap-4">
        <h1 class="text-2xl md:text-base xl:text-3xl lg:text-lg font-semibold text-zinc-800 bg-orange-600 p-1 px-4 rounded-full">Lista de Multimedia</h1>
        <div class="relative w-[25%]">
          <input class="rounded-full pl-5 pr-12 py-2 bg-zinc-800 text-orange-600 w-full" type="text" id="search" placeholder="Buscar...">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-orange-500 absolute right-4 top-1/2 -translate-y-1/2" viewBox="0 0 24 24"><g id="search"><path d="M10.77,18.3a7.53,7.53,0,1,1,7.53-7.53A7.53,7.53,0,0,1,10.77,18.3Zm0-13.55a6,6,0,1,0,6,6A6,6,0,0,0,10.77,4.75Z"/><path d="M20,20.75a.74.74,0,0,1-.53-.22L15.34,16.4a.75.75,0,0,1,1.06-1.06l4.13,4.13a.75.75,0,0,1,0,1.06A.74.74,0,0,1,20,20.75Z"/></g></svg>
        </div>
        <div class="relative inline-flex items-center">
          <button class="bg-zinc-800 rounded-full w-24 h-10 p-2 inline-flex items-center justify-center gap-1 filter-btn">
            <svg class="w-6 h-6 fill-orange-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g id="filter-fill"><path d="M20.17,3.91a.76.76,0,0,0-.67-.41H4.5a.76.76,0,0,0-.67.41.73.73,0,0,0,.07.78L9.25,12v7.75a.76.76,0,0,0,.75.75h4a.76.76,0,0,0,.75-.75V12L20.1,4.69A.73.73,0,0,0,20.17,3.91Z"/></g></svg>
            <svg class="w-6 h-6 fill-orange-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g id="angle-down"><path d="M12,14.5a.74.74,0,0,1-.53-.22L8,10.78A.75.75,0,0,1,9,9.72l3,3,3-3A.75.75,0,0,1,16,10.78l-3.5,3.5A.74.74,0,0,1,12,14.5Z"/></g></svg>
          </button>

          <div class="absolute left-full top-1/2 -translate-y-[60%] ml-2 bg-zinc-700 rounded-lg p-2 flex items-center gap-1 opacity-0 invisible scale-x-0 origin-left transition-all duration-200 ease-in-out
                    xl:left-full xl:top-1/2 xl:-translate-y-[60%] xl:flex-row
                    lg:left-full lg:top-1/2 lg:-translate-y-[60%] lg:flex-row
                    md:left-0 md:top-full md:translate-y-0 md:flex-col md:mt-2
                    sm:left-0 sm:top-full sm:translate-y-0 sm:flex-col sm:mt-2" id="dropdown-content">
            <button class="bg-zinc-800 text-center rounded-lg text-orange-600 px-2 py-2 hover:bg-orange-600 hover:text-zinc-800 text-sm min-w-[100px] h-10" onclick="filterTable('name')">Por Nombre</button>
            <button class="bg-zinc-800 text-center rounded-lg text-orange-600 px-2 py-2 hover:bg-orange-600 hover:text-zinc-800 text-sm min-w-[100px] h-10" onclick="filterTable('date')">Por Fecha</button>
            <button class="bg-zinc-800 text-center rounded-lg text-orange-600 px-2 py-2 hover:bg-orange-600 hover:text-zinc-800 text-sm min-w-[100px] h-10" onclick="filterTable('type')">Por Tipo</button>
            <button class="bg-zinc-800 text-center rounded-lg text-orange-600 px-2 py-2 hover:bg-orange-600 hover:text-zinc-800 text-sm min-w-[100px] h-10" onclick="resetTable()">Todos</button>
          </div>
        </div>
      </div>
        
      <div class="overflow-y-auto flex-1 pr-2">
        <table class="w-full border-separate bg-zinc-800 mb-5 rounded-md p-5">
            <thead class="sticky top-0 bg-zinc-800 z-10">
              <tr>
                  <th class="bg-zinc-800 text-orange-600 rounded-md">Nombre</th>
                  <th class="bg-zinc-800 text-orange-600 rounded-md">Fecha</th>
                  <th class="bg-zinc-800 text-orange-600 rounded-md">Tipo</th>
                  <th class="bg-zinc-800 text-orange-600 rounded-md">Acciones</th>
              </tr>
           </thead>
         <tbody id="multimedia-list" class="bg-zinc-700 text-orange-600 rounded-md text-center">
            <!-- Fila inicial con botón de agregar -->
            <tr class="hover:bg-zinc-600 transition-colors duration-200 add-row">
                <td colspan="4" class="py-4">
                    <a href="{{ route('multimedia.create') }}" class="flex items-center justify-center space-x-2">
                        <div class="w-12 h-12 border-4 border-orange-600 rounded-full flex items-center justify-center hover:border-orange-500 group">
                            <svg class="w-8 h-8 fill-orange-600 group-hover:fill-orange-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <g id="plus"><path d="M12.75,11.25V5a.75.75,0,0,0-1.5,0v6.25H5a.75.75,0,0,0,0,1.5h6.25V19a.76.76,0,0,0,.75.75.75.75,0,0,0,.75-.75V12.75H19a.75.75,0,0,0,.75-.75.76.76,0,0,0-.75-.75Z"/></g>
                            </svg>
                        </div>
                        <span class="text-lg text-orange-600 group-hover:text-orange-500">Agregar nuevo multimedia</span>
                    </a>
                </td>
            </tr>
            @foreach($multimedias as $multimedia)
            <tr data-id="{{ $multimedia->id }}" class="hover:bg-zinc-600 transition-colors duration-200">
                <td class="p-2">{{ $multimedia->text }}</td>
                <td class="p-2">{{ $multimedia->media_date->format('Y-m-d') }}</td>
                <td class="p-2">
                    <span class="text-sm">{{ ucfirst($multimedia->type) }}</span>
                </td>
                <td class="p-2">
                    <!-- Preview Section -->
                    <div class="flex flex-row justify-center gap-1 mb-1">
                        <div class="relative bg-zinc-700 rounded-lg p-1 group">
                            @if($multimedia->type === 'image')
                                <img src="{{ asset('storage/' . $multimedia->path) }}" 
                                     alt="Preview" 
                                     class="w-16 h-16 object-cover rounded-lg"
                                     onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-16 h-16 bg-zinc-600 rounded-lg flex items-center justify-center\'><svg class=\'w-8 h-8 fill-orange-600\' xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\'><path d=\'M19,3H5A2,2,0,0,0,3,5V19a2,2,0,0,0,2,2H19a2,2,0,0,0,2-2V5A2,2,0,0,0,19,3ZM5,19V5H19V19Z\'/></svg></div>'">
                            @elseif($multimedia->type === 'video')
                                <div class="w-16 h-16 bg-zinc-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-8 h-8 fill-orange-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <path d="M12,2A10,10,0,1,0,22,12,10,10,0,0,0,12,2Zm0,18a8,8,0,1,1,8-8A8,8,0,0,1,12,20ZM10,9.5v5a.5.5,0,0,0,.5.5.5.5,0,0,0,.5-.5v-5a.5.5,0,0,0-.5-.5A.5.5,0,0,0,10,9.5Zm4,0v5a.5.5,0,0,0,.5.5.5.5,0,0,0,.5-.5v-5a.5.5,0,0,0-.5-.5A.5.5,0,0,0,14,9.5Z"/>
                                    </svg>
                                </div>
                            @elseif($multimedia->type === 'audio')
                                <div class="w-16 h-16 bg-zinc-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-8 h-8 fill-orange-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <path d="M12,2A10,10,0,1,0,22,12,10,10,0,0,0,12,2Zm0,18a8,8,0,1,1,8-8A8,8,0,0,1,12,20ZM10,9.5v5a.5.5,0,0,0,.5.5.5.5,0,0,0,.5-.5v-5a.5.5,0,0,0-.5-.5A.5.5,0,0,0,10,9.5Zm4,0v5a.5.5,0,0,0,.5.5.5.5,0,0,0,.5-.5v-5a.5.5,0,0,0-.5-.5A.5.5,0,0,0,14,9.5Z"/>
                                    </svg>
                                </div>
                            @else
                                <div class="w-16 h-16 bg-zinc-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-8 h-8 fill-orange-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <path d="M19,3H5A2,2,0,0,0,3,5V19a2,2,0,0,0,2,2H19a2,2,0,0,0,2-2V5A2,2,0,0,0,19,3ZM5,19V5H19V19Z"/>
                                        <text x="8" y="18" class="text-xs fill-current">{{ strtoupper(pathinfo($multimedia->path, PATHINFO_EXTENSION)) }}</text>
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- Action Buttons -->
                    <div class="flex justify-center space-x-2">
                        <a href="{{ asset('storage/' . $multimedia->path) }}" 
                           target="_blank" 
                           class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-full text-sm">
                            Ver
                        </a>
                        <form action="{{ route('multimedia.destroy', $multimedia) }}" method="POST" class="inline" id="deleteForm-{{ $multimedia->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" 
                                    onclick="confirmDelete('{{ $multimedia->id }}', '{{ $multimedia->text }}')"
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-full text-sm">
                                Eliminar
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
         </tbody>
         </table>
    </div>
 
      <div class="mt-4 bg-orange-600 p-4 rounded-lg">
         {{ $multimedias->links('pagination::tailwind') }}
      </div>
    </div>

    @if(session('success'))
    <div id="successMessage" class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
        {{ session('success') }}
    </div>
    @endif

    <!-- Diálogo de confirmación -->
    <div id="deleteConfirmDialog" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-zinc-800 p-6 rounded-lg shadow-xl max-w-md w-full mx-4">
            <h3 class="text-xl font-semibold text-orange-600 mb-4">Confirmar Eliminación</h3>
            <p class="text-orange-600 mb-6">¿Estás seguro de que deseas eliminar el archivo "<span id="multimediaTitle" class="font-semibold"></span>"? Esta acción no se puede deshacer.</p>
            <div class="flex justify-end space-x-4">
                <button onclick="closeDeleteDialog()" 
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
        // Código para el mensaje de éxito
        const successMessage = document.getElementById('successMessage');
        if (successMessage) {
            setTimeout(() => {
                successMessage.style.opacity = '0';
                successMessage.style.transition = 'opacity 0.5s ease-in-out';
                setTimeout(() => {
                    successMessage.remove();
                }, 500);
            }, 3000);
        }

        let multimediaToDelete = null;

        function confirmDelete(id, title) {
            multimediaToDelete = id;
            document.getElementById('multimediaTitle').textContent = title;
            document.getElementById('deleteConfirmDialog').classList.remove('hidden');
            document.getElementById('deleteConfirmDialog').classList.add('flex');
        }

        function closeDeleteDialog() {
            document.getElementById('deleteConfirmDialog').classList.add('hidden');
            document.getElementById('deleteConfirmDialog').classList.remove('flex');
            multimediaToDelete = null;
        }

        function deleteMultimedia() {
            if (multimediaToDelete) {
                const form = document.getElementById('deleteForm-' + multimediaToDelete);
                if (form) {
                    form.submit();
                }
            }
            closeDeleteDialog();
        }

        // Cerrar el diálogo si se hace clic fuera de él
        document.getElementById('deleteConfirmDialog').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteDialog();
            }
        });

        // Función para mostrar/ocultar el dropdown
        document.querySelector('.filter-btn').addEventListener('click', function(e) {
            e.stopPropagation();
            const dropdownContent = document.getElementById('dropdown-content');
            dropdownContent.classList.toggle('opacity-0');
            dropdownContent.classList.toggle('invisible');
            dropdownContent.classList.toggle('scale-x-0');
        });

        // Cerrar el dropdown al hacer clic fuera
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.relative')) {
                const dropdownContent = document.getElementById('dropdown-content');
                dropdownContent.classList.add('opacity-0', 'invisible', 'scale-x-0');
            }
        });

        // Función de búsqueda
        document.getElementById('search').addEventListener('keyup', function() {
            const searchText = this.value.toLowerCase();
            const rows = document.querySelectorAll('#multimedia-list tr:not(.add-row)');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchText) ? '' : 'none';
            });
        });

        // Función de filtrado
        function filterTable(type) {
            const rows = document.querySelectorAll('#multimedia-list tr:not(.add-row)');
            const tbody = document.getElementById('multimedia-list');
            const sortedRows = Array.from(rows).sort((a, b) => {
                const aValue = a.querySelector(`td:nth-child(${type === 'name' ? 1 : type === 'date' ? 2 : 3})`).textContent.trim();
                const bValue = b.querySelector(`td:nth-child(${type === 'name' ? 1 : type === 'date' ? 2 : 3})`).textContent.trim();
                
                if (type === 'date') {
                    return new Date(aValue) - new Date(bValue);
                }
                return aValue.localeCompare(bValue);
            });

            // Remove existing rows
            rows.forEach(row => row.remove());
            
            // Add sorted rows
            sortedRows.forEach(row => tbody.appendChild(row));
        }

        // Función para resetear la tabla
        function resetTable() {
            const rows = document.querySelectorAll('#multimedia-list tr:not(.add-row)');
            const tbody = document.getElementById('multimedia-list');
            const sortedRows = Array.from(rows).sort((a, b) => {
                const aId = parseInt(a.dataset.id);
                const bId = parseInt(b.dataset.id);
                return bId - aId; // Sort by ID in descending order (newest first)
            });

            // Remove existing rows
            rows.forEach(row => row.remove());
            
            // Add sorted rows
            sortedRows.forEach(row => tbody.appendChild(row));
        }
  </script>
</body>
</html>
@endsection