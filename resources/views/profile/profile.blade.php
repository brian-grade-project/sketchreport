@extends('layout.master')

@section('title', 'Agregar Multimedia')

@section('content')

<div class="w-[100vw] h-[100vh] bg-[url(/img/imglogin.jpg)] bg-no-repeat bg-cover pt-5 overflow-hidden" >
    <div class= "bg-black/20 backdrop-blur-sm w-[100vw]  absolute inset-0 z-0"></div>
    <div class="w-[100%] h-[100%] bg-zinc-800 mt-5 relative overflow-hidden">


        <div class="w-[30%] h-[97%] bg-orange-600 rounded-3xl pt-[0.5%] float-left mr-5 ">

        <div class=" w-[15%] h-[2%] md:h-[1%]   mb-8 md:mt-1 ml-5">
          <svg class="w-[65%] md:w-[75%] xl:w-[65%] 2xl:w-[60%] fill-zinc-800 hover:bg-zinc-800 hover:fill-orange-600 transition-all duration-500 ease-in-out rounded-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g id="arrow-left"><path d="M11,18.75a.74.74,0,0,1-.53-.22l-6-6a.75.75,0,0,1,0-1.06l6-6a.75.75,0,0,1,1.06,1.06L6.06,12l5.47,5.47a.75.75,0,0,1,0,1.06A.74.74,0,0,1,11,18.75Z"/><path d="M19,12.75H5a.75.75,0,0,1,0-1.5H19a.75.75,0,0,1,0,1.5Z"/></g></svg>
        </div>

            <div class="w-[85%] h-[88%] m-auto bg-zinc-800 rounded-3xl shadow-xl/30 pt-8 flex flex-col justify-center items-center">
                <p class="text-orange-600 text-3xl font-bold text-center mb-4 ">Mi Perfil</p>

                <div class="w-40 h-40 bg-orange-600 m-auto rounded-full">


                </div>

                <p class="bg-orange-600 p-2 rounded-full text-xl font-bold mt-3 mb-3">*insertar nombre de usuario*</p>

                <div class="w-[100%] h-[60%] bg-orange-800 rounded-3xl">
                    <div class="p-2 pl-2 mt-5 bg-zinc-800 rounded-full">
                       <label for="Nombre" class=" text-xl md:text-lg font-light text-orange-600">Nombre: </label>
                       <input type="text" id="Nombre" name="nombre" class="w-[70%] md:w-[68%] p-1 pl-3 bg-orange-600 rounded-full"></input>
                    </div>

                    <div class="p-2 pl-2 mt-5 bg-zinc-800 rounded-full">
                       <label for="Nombre" class="text-xl font-light text-orange-600">Correo: </label>
                       <input type="text" id="Nombre" name="nombre" class="w-[70%] p-1 pl-3 bg-orange-600 rounded-full"></input>
                    </div>

                    <div class="p-2 pl-2 mt-5 bg-zinc-800 rounded-full">
                       <label for="Nombre" class="text-xl md:text-lg font-light text-orange-600">Teléfono: </label>
                       <input type="text" id="Nombre" name="nombre" class="w-[70%] md:w-[68%] p-1 pl-3 bg-orange-600 rounded-full"></input>
                    </div>

                    
                    

                </div>



            </div>

        </div>

        <div class="bg-orange-600 w-[68.5%] h-[97%] inline-block float-left rounded-3xl pt-[2%] pr-8 pl-8 pb-8 md:w-[67%]">
            <div class="w-[100%] h-[30%] bg-zinc-800 rounded-3xl mb-2 p-5">
                <p class="text-orange-600 font-bold text-2xl">SEGURIDAD:</p>
                <p class="text-orange-600 font-regular text-base/5 md:mt-2">En esta área, nos comprometemos a proteger y resguardar tanto nuestro sistema como la información y seguridad de nuestros usuarios, Implementando prácticas para garantizar un entorno seguro y confiable para todos.</p>
                <div class="relative block  mt-5 ml-2 lg:w-[25%] md:w-[25%] lg:w-[35%] rounded-full inline-block ">
                    <button class="btn-sm text-center bg-orange-600 w-full rounded-full text-xl font-light h-full hover:bg-orange-700 hover:text-white hover:font-semibold">Cambiar Contraseña</button>

                </div>

            

            </div>

            <div class="w-[100%] h-[30%] bg-zinc-800 rounded-3xl mb-2 p-5">

                <p class="text-orange-600 font-bold text-2xl">SUSCRIPCIÓN:</p>
                <p class="text-orange-600 font-regular text-base/5 md:mt-2">Esta es la sección donde puedes gestionar tu plan activo. Aquí encontrarás los detalles básicos de tu suscripción actual, junto con la fecha de próxima reactivación.</p>

                <div class="p-2 pl-1 mt-2 bg-zinc-700 rounded-full mt-2 float-left w-[27%] md:w-[35%] lg:w-[30%]">
                       <label for="Estado" class="text-xl font-light text-orange-600">Estado: </label>
                       <input type="text" id="Estado" name="Estado" class="w-[50%] p-1 pl-4 bg-orange-600 rounded-full"></input>
                </div>

                <div class="p-2 pl-2 mt-2 bg-zinc-700 rounded-full mt-2 float-left inline-block w-[35%] lg:w-[30%]">
                       <label for="Plan" class="text-xl font-light text-orange-600">Plan: </label>
                       <input type="text" id="Plan" name="Plan" class="w-[59%] p-1 pl-4 bg-orange-600 rounded-full"></input>
                </div>

                <div class="p-2 lg:p-2 pl-2 mt-2 bg-zinc-700 rounded-full float-left inline-block md:w-[35%] lg:w-[40%] ">
                       <label for="Renovacion" class="text-xl md:text-lg font-light text-orange-600">Renovacion: </label>
                       <input type="text" id="Renovacion" name="Renovacion" class="w-[90%] lg:w-[50%] p-1 bg-orange-600 rounded-full "></input>
                </div>

            </div>

            <div class="w-[100%] h-[30%] bg-zinc-800 rounded-3xl mb-2 p-5">

                <p class="text-orange-600 font-bold text-2xl">ELIMINAR CUENTA:</p>
                <p class="text-orange-600 font-regular text-base/5 md:mt-2">Esta sección permite eliminar o deshabilitar tu cuenta en nuestra aplicación. Si eliges eliminar tu cuenta, toda tu información será eliminada de nuestra base de datos de forma definitiva.</p>
                <div class="relative block  mt-5 ml-2 lg:w-[32%] md:w-[25%] rounded-full inline-block ">
                    <button class="btn-sm text-center bg-orange-600 w-full rounded-full text-xl font-light h-full hover:bg-orange-700 hover:text-white hover:font-semibold">Desactivar Cuenta</button>

                </div>

                <div class="relative block  mt-5 ml-16 lg:w-[30%] md:w-[25%] rounded-full inline-block">
                    <button class="btn-sm text-center bg-orange-600 w-full rounded-full text-xl font-light h-full hover:bg-orange-700 hover:text-white hover:font-semibold">Eliminar Cuenta</button>

                </div>

            </div>

            <div class="relative block  mt-2 ml-20 float-right lg:w-[28%] md:w-[25%] rounded-full inline-block">
                    <button class=" p-2 btn-sm text-center text-orange-600 bg-zinc-800 w-full rounded-full text-xl font-light h-full hover:bg-orange-700 hover:text-white hover:font-semibold">Guardar Cambios</button>

                </div>

        </div>

    </div>
</div>

@endsection