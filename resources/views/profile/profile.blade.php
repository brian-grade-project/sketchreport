@extends('layout.master')

@section('title', 'Agregar Multimedia')

@section('content')

<div class="w-[100vw] h-[100vh] bg-[url(/img/imglogin.jpg)] bg-no-repeat bg-cover pt-5 overflow-hidden" >
    <div class= "bg-black/20 backdrop-blur-sm w-[100vw]  absolute inset-0 z-0"></div>
    <div class="w-[100%] h-[100%] bg-zinc-800 mt-5 relative overflow-hidden">

        @if(session('success'))
        <div class="fixed bottom-4 right-4 z-50 animate-fade-out">
            <div class="bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
                {{ session('success') }}
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="fixed bottom-4 right-4 z-50 animate-fade-out">
            <div class="bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg">
                {{ session('error') }}
            </div>
        </div>
        @endif

        <!-- Modal de Confirmación -->
        <div id="deleteAccountModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
            <div class="bg-zinc-800 p-8 rounded-3xl shadow-xl max-w-md w-full mx-4">
                <h3 class="text-orange-600 text-2xl font-bold mb-4">Confirmar Eliminación de Cuenta</h3>
                <p class="text-orange-600 mb-6">¿Estás seguro que deseas eliminar tu cuenta? Esta acción es irreversible y se perderá todo tu contenido almacenado.</p>
                <div class="flex justify-end space-x-4">
                    <button onclick="closeDeleteModal()" class="px-6 py-2 bg-zinc-700 text-orange-600 rounded-full hover:bg-zinc-600 transition-colors duration-300">
                        Cancelar
                    </button>
                    <form id="deleteAccountForm" method="POST" action="{{ route('account.delete') }}" class="inline">
                        @csrf
                        <input type="hidden" name="_method" value="POST">
                        <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-full hover:bg-red-700 transition-colors duration-300">
                            Eliminar Cuenta
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="w-[30%] h-[97%] bg-orange-600 rounded-3xl pt-[0.5%] float-left mr-5 ">

        <div class=" w-[15%] h-[2%] md:h-[1%]   mb-8 md:mt-1 ml-5">
          <a href="{{ route('home') }}" class="block">
            <svg class="w-[65%] md:w-[75%] xl:w-[65%] 2xl:w-[60%] fill-zinc-800 hover:bg-zinc-800 hover:fill-orange-600 transition-all duration-500 ease-in-out rounded-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g id="arrow-left"><path d="M11,18.75a.74.74,0,0,1-.53-.22l-6-6a.75.75,0,0,1,0-1.06l6-6a.75.75,0,0,1,1.06,1.06L6.06,12l5.47,5.47a.75.75,0,0,1,0,1.06A.74.74,0,0,1,11,18.75Z"/><path d="M19,12.75H5a.75.75,0,0,1,0-1.5H19a.75.75,0,0,1,0,1.5Z"/></g></svg>
          </a>
        </div>

            <div class="w-[85%] h-[88%] m-auto bg-zinc-800 rounded-3xl shadow-xl/30 pt-8 flex flex-col justify-center items-center">
                <p class="text-orange-600 text-3xl font-bold text-center mb-4 ">Mi Perfil</p>

                <div class="w-40 h-40 bg-orange-600 m-auto rounded-full">


                </div>

                <p class="bg-orange-600 p-2 rounded-full text-xl font-bold mt-3 mb-3">{{ auth()->user()->username }}</p>

                <div class="w-[100%] h-[60%] bg-orange-800 rounded-3xl">
                    <form id="profile-form" class="w-full">
                        <div class="p-2 pl-2 mt-5 bg-zinc-800 rounded-full flex items-center justify-between">
                           <label for="username" class="text-xl md:text-lg font-light text-orange-600">Usuario: </label>
                           <div class="flex items-center w-[70%]">
                               <input type="text" id="username" name="username" value="{{ auth()->user()->username }}" class="w-full p-1 pl-3 bg-orange-600 rounded-full" readonly>
                               <button type="button" class="edit-btn ml-2 text-zinc-800 hover:text-orange-600 transition-colors duration-300" onclick="toggleEdit('username')">
                                   <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                       <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                   </svg>
                               </button>
                           </div>
                    </div>

                        <div class="p-2 pl-2 mt-5 bg-zinc-800 rounded-full flex items-center justify-between">
                           <label for="email" class="text-xl font-light text-orange-600">Correo: </label>
                           <div class="flex items-center w-[70%]">
                               <input type="email" id="email" name="email" value="{{ auth()->user()->email }}" class="w-full p-1 pl-3 bg-orange-600 rounded-full" readonly>
                           </div>
                    </div>

                        <div class="p-2 pl-2 mt-5 bg-zinc-800 rounded-full flex items-center justify-between">
                           <label for="telefono" class="text-xl md:text-lg font-light text-orange-600">Teléfono: </label>
                           <div class="flex items-center w-[70%]">
                               <input type="tel" id="telefono" name="phone" value="{{ auth()->user()->phone ?? '' }}" class="w-full p-1 pl-3 bg-orange-600 rounded-full" readonly>
                               <button type="button" class="edit-btn ml-2 text-zinc-800 hover:text-orange-600 transition-colors duration-300" onclick="toggleEdit('telefono')">
                                   <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                       <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                   </svg>
                               </button>
                           </div>
                    </div>
                    </form>
                </div>



            </div>

        </div>

        <div class="bg-orange-600 w-[68.5%] h-[97%] inline-block float-left rounded-3xl pt-[2%] pr-8 pl-8 pb-8 md:w-[67%]">
            <div class="w-[100%] h-[30%] bg-zinc-800 rounded-3xl mb-2 p-5">
                <p class="text-orange-600 font-bold text-2xl">SEGURIDAD:</p>
                <p class="text-orange-600 font-regular text-base/5 md:mt-2">En esta área, nos comprometemos a proteger y resguardar tanto nuestro sistema como la información y seguridad de nuestros usuarios, Implementando prácticas para garantizar un entorno seguro y confiable para todos.</p>
                <div class="relative block  mt-5 ml-2 lg:w-[25%] md:w-[25%] lg:w-[35%] rounded-full inline-block ">
                    <a href="{{ route('password.change') }}" class="btn-sm text-center bg-orange-600 w-full rounded-full text-xl font-light h-full hover:bg-orange-700 hover:text-white hover:font-semibold block">Cambiar Contraseña</a>
                </div>

            

            </div>

            <div class="w-[100%] h-[30%] bg-zinc-800 rounded-3xl mb-2 p-5">

                <p class="text-orange-600 font-bold text-2xl">SUSCRIPCIÓN:</p>
                <p class="text-orange-600 font-regular text-base/5 md:mt-2">Esta es la sección donde puedes gestionar tu plan activo. Aquí encontrarás los detalles básicos de tu suscripción actual, junto con la fecha de próxima reactivación.</p>

                <div class="p-2 pl-1 mt-2 bg-zinc-700 rounded-full mt-2 float-left w-[27%] md:w-[35%] lg:w-[30%]">
                       <label for="Estado" class="text-xl font-light text-orange-600">Estado: </label>
                       <input type="text" id="Estado" name="Estado" value="{{ auth()->user()->status ? 'Activo' : 'Inactivo' }}" class="w-[50%] p-1 pl-4 bg-orange-600 rounded-full" readonly>
                </div>

                <div class="p-2 pl-2 mt-2 bg-zinc-700 rounded-full mt-2 float-left inline-block w-[35%] lg:w-[30%]">
                       <label for="Plan" class="text-xl font-light text-orange-600">Plan: </label>
                       <input type="text" id="Plan" name="Plan" value="{{ auth()->user()->plan }}" class="w-[59%] p-1 pl-4 bg-orange-600 rounded-full" readonly>
                </div>

                <div class="p-2 lg:p-2 pl-2 mt-2 bg-zinc-700 rounded-full float-left inline-block md:w-[35%] lg:w-[40%] ">
                       <label for="Renovacion" class="text-xl md:text-lg font-light text-orange-600">Renovacion: </label>
                       <input type="text" id="Renovacion" name="Renovacion" value="Próximamente" class="w-[90%] lg:w-[50%] p-1 bg-orange-600 rounded-full" readonly>
                </div>

            </div>

            <div class="w-[100%] h-[30%] bg-zinc-800 rounded-3xl mb-2 p-5">

                <p class="text-orange-600 font-bold text-2xl">ELIMINAR CUENTA:</p>
                <p class="text-orange-600 font-regular text-base/5 md:mt-2">Esta sección permite eliminar o deshabilitar tu cuenta en nuestra aplicación. Si eliges eliminar tu cuenta, toda tu información será eliminada de nuestra base de datos de forma definitiva.</p>
                <div class="relative block  mt-5 ml-2 lg:w-[32%] md:w-[25%] rounded-full inline-block ">
                    <button class="btn-sm text-center bg-orange-600 w-full rounded-full text-xl font-light h-full hover:bg-orange-700 hover:text-white hover:font-semibold">Desactivar Cuenta</button>
                </div>

                <div class="relative block  mt-5 ml-16 lg:w-[30%] md:w-[25%] rounded-full inline-block">
                    <button onclick="showDeleteModal()" class="btn-sm text-center bg-orange-600 w-full rounded-full text-xl font-light h-full hover:bg-orange-700 hover:text-white hover:font-semibold">Eliminar Cuenta</button>
                </div>

            </div>

            <div class="relative block  mt-2 ml-20 float-right lg:w-[28%] md:w-[25%] rounded-full inline-block">
                    <button class=" p-2 btn-sm text-center text-orange-600 bg-zinc-800 w-full rounded-full text-xl font-light h-full hover:bg-orange-700 hover:text-white hover:font-semibold">Guardar Cambios</button>

                </div>

        </div>

    </div>
</div>

<div id="message-container" class="fixed top-4 right-4 z-50"></div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Función para manejar la edición de campos
    window.toggleEdit = function(fieldId) {
        const input = document.getElementById(fieldId);
        const editBtn = input.nextElementSibling;
        
        if (input.readOnly) {
            input.readOnly = false;
            input.focus();
            editBtn.classList.add('text-orange-600');
        } else {
            input.readOnly = true;
            editBtn.classList.remove('text-orange-600');
            saveChanges();
        }
    };

    // Función para guardar los cambios
    function saveChanges() {
        const form = document.getElementById('profile-form');
        const formData = new FormData(form);

        fetch('{{ route("profile.update") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                username: formData.get('username'),
                email: formData.get('email'),
                phone: formData.get('phone')
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showMessage(data.message, 'success');
            } else {
                showMessage('Error al actualizar el perfil', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('Error al actualizar el perfil', 'error');
        });
    }

    // Función para mostrar mensajes
    function showMessage(message, type = 'info') {
        const messageContainer = document.getElementById('message-container');
        const messageElement = document.createElement('div');
        messageElement.classList.add('alert', 'shadow-lg', 'w-auto', 'pointer-events-auto');

        if (type === 'success') {
            messageElement.classList.add('alert-success');
        } else if (type === 'warning') {
            messageElement.classList.add('alert-warning');
        } else if (type === 'error') {
            messageElement.classList.add('alert-error');
        } else {
            messageElement.classList.add('alert-info');
        }

        messageElement.innerHTML = `
            <div>
                <span>${message}</span>
            </div>
        `;

        messageContainer.appendChild(messageElement);

        setTimeout(() => {
            messageElement.remove();
        }, 3000);
    }

    // Eliminar mensaje de éxito después de 3 segundos
    const successMessage = document.querySelector('.animate-fade-out');
    if (successMessage) {
        setTimeout(() => {
            successMessage.style.opacity = '0';
            successMessage.style.transition = 'opacity 0.5s ease-out';
            setTimeout(() => {
                successMessage.remove();
            }, 500);
        }, 3000);
    }

    // Funciones para el modal de eliminación de cuenta
    window.showDeleteModal = function() {
        document.getElementById('deleteAccountModal').classList.remove('hidden');
    }

    window.closeDeleteModal = function() {
        document.getElementById('deleteAccountModal').classList.add('hidden');
    }

    // Manejar el envío del formulario de eliminación
    document.getElementById('deleteAccountForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (confirm('¿Estás completamente seguro de que deseas eliminar tu cuenta? Esta acción no se puede deshacer.')) {
            this.submit();
        }
    });

    // Cerrar modal al hacer clic fuera de él
    document.getElementById('deleteAccountModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });

    // Cerrar modal con la tecla Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDeleteModal();
        }
    });
});
</script>

<style>
@keyframes fadeOut {
    from {
        opacity: 1;
    }
    to {
        opacity: 0;
    }
}

.animate-fade-out {
    animation: fadeOut 0.5s ease-out 3s forwards;
}
</style>
@endsection