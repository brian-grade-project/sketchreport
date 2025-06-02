@extends('layout.master')

@section('title', 'Agregar Multimedia')

@section('content')

<div class="w-[100vw] h-[100vh] bg-[url(/img/imglogin.jpg)] bg-no-repeat bg-cover pt-5" >
    <div class= "bg-black/20 backdrop-blur-sm w-[100vw]  absolute inset-0 z-0"></div>
        <div class="w-[30%] md:w-[41%] h-[60%] md:h-[45%] lg:h-[60%]  bg-zinc-800 m-auto mt-5 relative overflow-hidden rounded-3xl   ">
            <div class="mt-8 ml-12 lg:ml-[13%] xl:ml-[19%] 2xl:ml-[24%] m-auto">
                <p class="text-2xl text-orange-600 font-black">CAMBIO DE CONTRASEÑA</p>
            </div>

            <div class="mt-3 ml-12 w-[80%] 2xl:ml-[9%] h-[0.3%] bg-orange-600">
                
            </div>


            <div class="mt-3 m-auto w-[100%] h-[50%] p-2 bg-zinc-700">
                <label for="nueva_contraseña" class="text-orange-600 block font-light text-xl md:mt-3 ml-[21%]">Nueva Contraseña</label>
                
                <div class="bg-zinc-800 p-2 ml-[15%] rounded-full w-[70%]">
                    <input type="text" class=" rounded-full w-[99%] p-1 pl-3 m-auto focus:bg-orange-600" id="nueva_contraseña" name="nueva_contraseña" placeholder="Ingrese nueva contraseña">
                </div>
                

                <div class="mt-7 lg:mt-8 xl:mt-9 2xl:ml-[19%] ml-[21%] border border-2 border-dashed w-[60%] h-[0.3%] border-orange-600">
                    
                </div>
                
                <label for="confirme_contraseña" class="text-orange-600 block font-light text-xl ml-[21%] mt-7">Confirme Contraseña</label>
                
                <div class="bg-zinc-800 p-2 ml-[15%] rounded-full w-[70%]">
                    <input type="text" class=" rounded-full w-[99%] p-1 pl-3 m-auto focus:bg-orange-600" id="nueva_contraseña" name="nueva_contraseña" placeholder="Ingrese nueva contraseña">
                </div>
            </div>

            <div class="relative block mt-10 ml-[18%] w-[65%] rounded-full inline-block ">
                <button class="btn-sm text-center bg-orange-600 w-full rounded-full text-xl font-light h-full hover:bg-orange-700 hover:text-white hover:font-semibold">Cambiar Contraseña</button>

            </div>
            
        </div>
    </div>
</div>

@endsection