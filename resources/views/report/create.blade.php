@extends('layout.master')

@section('content')
<div class="w-[100vw] h-[100vh]">
    <div class="w-[80%] h-3/4 bg-zinc-800 m-auto mt-5 relative overflow-hidden rounded-3xl ">

    <form class=" flex flex-row flex-auto flex-wrap relative float-left lg:w-[62%] md:w-[60%]">

            <div class=" relative ml-16 lg:w-60 md:w-[48%] ">

                <label for="titulo" class="text-xl text-orange-600 block ml-5 mt-10 font-light">Titulo de reporte</label>
                <input type="text" class="bg-white rounded-full w-full p-1 " name="titulo" id="titulo" placeholder="Ingrese titulo">

            </div>
        

            <div class="relative   ml-14 w-[25%]"> 

                <label for="titulo" class="text-xl text-orange-600 block mt-10 ml-4 font-light">Fecha</label>
                <input type="date" class="bg-white rounded-full w-full p-1 " name="titulo" id="titulo" placeholder="Ingrese titulo">

            </div>

            <div class="relative float-left  ml-16 w-[86%]"> 

              <label for="cuerpo" class="text-xl text-orange-600 block mt-8 font-light">Cuerpo del reporte</label>
              <textarea class=" resize-none bg-white rounded w-full h-full" name="cuerpo" id="cuerpo" placeholder="Ingrese cuerpo del reporte"></textarea>


            </div>

            <div class="relative float-left  mt-[9%] ml-16 w-[40%] h-[10%]">

              <label for="importar" class="text-xl text-orange-600 block mt-8 font-light">Archivos multimedia</label>
              <input type="file" multiple class=" resize-none bg-white rounded w-full h-full rounded-full" name="importar" id="importar" placeholder="">

            </div>
            <div class="w-[50%] h-[1%] ">

            </div>

            <div class="relative w-[100%] flex flex-row">
                <div class="relative block  mt-10 ml-16 lg:w-[25%] md:w-[25%] rounded-full ">
                    <button class="btn-sm text-center bg-orange-600 w-full rounded-full text-xl font-light h-full hover:bg-orange-700 hover:text-white hover:font-semibold  ">Guardar</button>

                </div>

                <div class="relative block  mt-10 ml-16 lg:w-[45%] md:w-[45%] rounded-full  ">
                    <button class="btn-sm text-center bg-orange-600 w-full rounded-full text-xl font-light h-full hover:bg-orange-700 hover:text-white hover:font-semibold  ">Guardar y Exportar</button>

                </div>

            </div>

            
    </form>   


    <form class="relative block">

            
    </form>

        <!--<form class=" grid grid-rows-2 grid-cols-4 gap-x-10 gap-Y-10 relative">

            <div class="bg-yellow-500 relative ml-16 w-64 ">

                <label for="titulo" class="text-xl text-orange-600 block ml-5 mt-8 font-light">Titulo de reporte</label>
                <input type="text" class="bg-white rounded-full w-full p-1 " name="titulo" id="titulo" placeholder="Ingrese titulo">

            </div>
        </form>

        <form class=" grid grid-rows-2 grid-cols-4 gap-x-10 relative">

            <div class="relative float-left bg-blue-800 ml-14 w-[80%]"> 

                <label for="titulo" class="text-xl text-orange-600 block mt-8 ml-4 font-light">Fecha</label>
                <input type="date" class="bg-white rounded-full w-3/4 p-1 " name="titulo" id="titulo" placeholder="Ingrese titulo">

            </div>
        </form>   

        <form class=" grid grid-rows-2 grid-cols-4 gap-x-10 gap-Y-10 relative">

           <div class="relative bg-blue-800 ml-16 col-span-3  w-[73%] h-[150%]"> 

              <label for="cuerpo" class="text-xl text-orange-600 block mt-8 font-light">Cuerpo del reporte</label>
              <textarea class=" resize-none bg-white rounded w-full h-full" name="cuerpo" id="cuerpo" placeholder="Ingrese cuerpo del reporte"></textarea>

            </div>

        </form>

        <form class=" grid grid-rows-2 grid-cols-4 gap-x-10 gap-Y-10 relative">

            <div class="relative bg-blue-800 ml-16 col-span-3 w-[73%] "> 

              <label for="importar" class="text-xl text-orange-600 block mt-8 font-light">Cuerpo del reporte</label>
              <input type="file" multiple class=" resize-none bg-white rounded w-full h-full" name="importar" id="importar" placeholder="">

            </div>
            
        

        </form>

        
-->
        <div class="bg-orange-600 w-2/6 h-screen float-right overflow-clip relative m-0 p-0">
            
            <div class="xl:w-[45%] xl:h-[25%] lg:w-[45%] lg:h-[23%] md:w-[45%] md:h-[17%] bg-zinc-800 absolute rounded-full ml-[30%] mt-[20%]">
                <img src="/img/file-import.svg" alt="file_import" class="stroke-orange-600 stroke-4 m-auto mt-2 w-[80%] " >
            </div>

            <div class="w-[60%] h-[100%] bg-zinc-800 rotate-45 relative top-60 right-0 left-28  "></div>
            
        </div>
    </div>
</div>

@endsection