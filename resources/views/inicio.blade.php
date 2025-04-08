@extends('layout.master')

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>inicio</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
@section('content')
    <header>
       <!-- <nav class=" bg-base-100 flex max-w-80">
            <ul class=" bg-steel-900 flex text-xl space-x-8 relative max-w-xl p-3">
                <li> <a class="text-red-500" href="#">Inicio</a></li>
                <li> <a href="#">Información</a></li>
                <li> <a href="#">Enlaces</a></li>
            </ul>
        </nav>
    </header> -->

    <div id="caja1">
        <nav class=" bg-zinc-800 flex flex-row w-screen h-screen relative">
            <ul class=" bg-steel-900  flex flex-row text-2xl lg:space-x-8 md:space-x-2 lg:w-4/12 md:w-[10%] h-2/3 p-3 ml-2">
                <li> <a class="md:text-xl text-orange-600 hover:transition-all duration-500 ease-in-out hover:text-zinc-800 hover:bg-orange-600 pointer rounded-full px-3  py-2" href="#">Inicio</a></li>
                <li> <a class="md:text-xl text-orange-600  hover:transition-all duration-500 ease-in-out hover:text-zinc-800 hover:bg-orange-600 pointer rounded-full px-3  py-2" href="#">Información</a></li>
                <li> <a class="md:text-xl text-orange-600  hover:transition-all duration-500 ease-in-out hover:text-zinc-800 hover:bg-orange-600 pointer rounded-full px-3  py-2" href="#">Enlaces</a></li>
            </ul> </br>

            <img src="/img/logotipo1.svg" class="xl:w-[45%] lg:w-4/12 md:w-[50%] absolute lg:top-1/4 md:top-[28%] left-7"></img>

            <p class="lg:text-2xl md:text-xl text-white text-left absolute lg:top-1/2 md:top-[47%] left-7 lg:max-w-xl md:w-[55%] leading-none font-light">
                Una aplicación web para el registro y gestión de reportes de índole comunicacional. Almacena tus reportes y material multimedia con orden y comodidad 
            </p>

            


            <img class=" float-left lg:w-8/12 md:w-[60%] h-screen lg:ml-0 md:ml-[29%]" src="/img/img1.png">
            
            <a class="text-orange-600 text-center leading-none lg:text-3xl md:text-2xl absolute top-2/3  left-48 hover:transition-all duration-500 ease-in-out hover:text-zinc-800 hover:bg-orange-600 pointer rounded-full px-10 py-14 mb-5 " href="#">Inicia<br> <b>AHORA<b></a>
        </nav>


        <!--segunda vision-->

        <div class="w-screen h-96 bg-orange-600 flex flex-column">

            <ul class="list-disc lg:text-3xl md:text-2xl float-left text-zinc-800 font-normal pl-20 pt-10">
                <li class=""><p>¿Montañas de papeles y reportes acumulados?</p></li>
                <li class="pt-2"><p>¿Pérdida de información relevante?</p></li>
                <li class="pt-2"><p>¿Falta de eficiencia en el ambiente laboral? </p>
                
                <img src="/img/logotipo2.svg" class="lg:w-5/6 md:w-[95%] pt-10"></img>
            </ul>

            

            <img src="/img/img2.png" class="lg:h-full md:h-[90%] md:w-[38%] cover float-right lg:mr-10 md:mr-5"></img>
            
            

        </div>

        
         <!--tercera vision-->

        <div class="bg-zinc-800 w-screen h-screen relative">

           

            <p class="lg:text-2xl md:text-xl text-orange-600 text-left float-left lg:max-w-xl md:w-[60%] leading-none font-bold italic absolute top-12 left-7 ">
               Nuestra aplicación está diseñada para asegurar tu comodidad y acceso en todo momento
            </p>

            <p class="lg:text-2xl md:text-lg text-white text-left  lg:max-w-xl md:w-[50%] leading-none font-light absolute top-28 left-7 ">
               Puedes acceder a ella tanto desde tu computadora como desde tus dispositivos móviles, para que puedas trabajar desde donde quieras y cuando quieras.<br><br>
               
               <spam>Además, lleva contigo tu propio registro y almacenamiento de reportes, fotos, videos, audios e incluso documentos. Todo en un solo lugar, para que tengas toda la información que necesitas al alcance de tu mano.</spam><br><br>

               <spam>No importa si eres un profesional independiente, un estudiante o un emprendedor, nuestra plataforma te ayudará a organizar tus tareas, proyectos y documentos de una manera eficiente y práctica</spam>
            </p>

            <img class="float-right w-7/12 h-screen" src="/img/img3.png">

            <a class="text-orange-600 text-center leading-none lg:text-3xl md:text-2xl absolute lg:top-3/4 md:top-[73%] xl:top-[73%] lg:left-52 md:left-[16%] hover:transition-all duration-500 ease-in-out hover:text-zinc-800 hover:bg-orange-600 pointer rounded-full px-5 py-10 mb-5 " href="#">Inicia<br> <b>AHORA<b></a>



        


            <!--<p class="text-2xl text-white text-left absolute top-1/2 left-7 max-w-xl leading-none font-light">
                Una aplicación web para el registro y gestión de reportes de índole comunicacional. Almacena tus reportes y material multimedia con orden y comodidad 
            </p>-->



            
        <!--cuarta vision-->   
        </div>

        <div class="w-screen lg:h-60 md:h-40 xl:h-[50%] bg-zinc-800 lg:text-3xl md:text-xl text-center font-bold italic ">

            <a href="#" class="bg-orange-600 float-left w-1/3 p-4 leading-none hover:transition-all duration-500 ease-in-out hover:text-orange-600 hover:bg-zinc-800 pointer">Políticas y condiciones</a>

            <a href="#" class="bg-zinc-800 text-center justify-center text-orange-600 float-left w-1/3 leading-none p-4 hover:transition-all duration-500 ease-in-out hover:text-zinc-800 hover:bg-orange-600 pointer">Contacto <br></a>

            <a href="#" class="bg-orange-600 float-left w-1/3 p-4 leading-none hover:transition-all duration-500 ease-in-out hover:text-orange-600 hover:bg-zinc-800 pointer">Acerca de nosotros</a>
        

            <img src="/img/logotipo3.svg" class="w-4/12  m-auto lg:pt-20 md:pt-10 xl:pt-20 xl:pb-20" ></img>
            

            <!--
            <button class="btn btn-circle btn-outline">
                 <svg
                       xmlns="http://www.w3.org/2000/svg"
                       class="h-6 w-6"
                       fill="none"
                       viewBox="0 0 24 24"
                       stroke="currentColor">
                <path
                       stroke-linecap="round"
                       stroke-linejoin="round"
                       stroke-width="2"
                       d="M6 18L18 6M6 6l12 12" />
                   </svg>
            </button>
-->
                  
  
</button>

        </div>
        
        




        
       <!-- <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1357 1080"><defs><style>.cls-1{fill:#f96b13;}.cls-2{clip-path:url(#clip-path);}</style><clipPath id="clip-path"><path class="cls-1" d="M433,0,233.42.5s-99.67-8-99.67,71.39c0,79.61,99.67,76.61,99.67,76.61s250.13-7,250.13,170-32,279,182.09,279,173.09,261,173.09,304c0,146,106,178.5,518.27,178.5V0Z"/></clipPath></defs><title>img1</title><g id="Capa_2" data-name="Capa 2"><g id="Capa_1-2" data-name="Capa 1"><path class="cls-1" d="M433,0,233.42.5s-99.67-8-99.67,71.39c0,79.61,99.67,76.61,99.67,76.61s250.13-7,250.13,170-32,279,182.09,279,173.09,261,173.09,304c0,146,106,178.5,518.27,178.5V0Z"/><g class="cls-2"><image width="1024" height="682" transform="scale(1.33 1.58)" xlink:href="../../istockphoto-1494317561-1024x1024-colorbase.png"/></g></g></g></svg> -->
    </div>
@endsection
</body>
</html>