{{-- // TODO: vista para inicio de sesión --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>inicio</title>
    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    @if(session('status'))
    <div class="bg-yellow-400 h-[30px] text-black px-4">{{ session('status' )}}</div>
    @endif
    <div class="w-screen h-screen flex flex-row">
        <img src="/img/imglogin.jpg" class="w-4/6 md:w-[60%] h-screen float-left"></img>
        <div class="h-screen md:w-[39%] w-2/6 bg-zinc-800 float-right relative overflow-clip">


            <!--<img src="/img/logotipo1.svg" class="w-5/12 absolute top-[10%] left-[30%] place-items-center"></img>-->
            <div class="border-4 md:border-2 border-orange-600 rounded-full w-7/12 md:w-8/12 m-auto mt-10 md:mt-8">
                <img src="/img/logotipo1.svg" class="w-9/12 md:w-[95%] lg:w-[90%]  p-3 xl:p-5 m-auto "></img>
            </div>
           
            <!--<div class=" w-8/12 border-2 border-orange-600 rounded-full m-auto mt-4 p-2">
                
            </div> -->
            <p class=" text-center font-semibold italic m-auto mt-4 xl:mt-6 bg-orange-600 text-zinc-800">Inicia sesión e inicia una mejor gestión</p>

            <form action="{{ route('login.check') }}" method="post">
                @csrf
                <label class="text-xl md:text-lg text-orange-600 block ml-28 md:ml-[25%] mt-8 font-light" for="usuario">Usuario</label>
                <input name="email" class="bg-white text-orange-600  rounded-full w-7/12 m-auto ml-24 md:ml-[22%]  p-1 focus:bg-orange-600 text-yellow-800" type="text" placeholder="Ingrese usuario" id="usuario">

                <label class="text-xl md:text-lg text-orange-600 block ml-28 md:ml-[25%] mt-5 font-light" for="contraseña">Contraseña</label>
                <input name="password" class="bg-white text-orange-600  rounded-full w-7/12 m-auto ml-24 md:ml-[22%] md:mb-[5%] p-1 focus:bg-orange-600 text-zinc-800" type="password" placeholder="Ingrese contraseña" id="contraseña">

                <a class="text-orange-600 underline font-light m-auto ml-36 md:ml-[22%] lg:ml-[29%] xl:ml-[34%] mt-5 md:mt-[70%]" href="#">¿Olvidaste tu contraseña?</a>
                <input class="text-orange-600 text-lg font-bold bg-zinc-800 border-2 border-orange-600 rounded-full  block m-auto ml-24 md:ml-[23%] mt-5 md:mt-[8%] lg:mt-[5%] p-1 italic hover:bg-orange-600 hover:text-zinc-800 hover:transition-all duration-500 ease-in-out hover w-7/12 " type="submit" value="Ingresar">
            </form>

            <div class="w-screen h-6 bg-orange-600 mt-10 mb-5 "></div>

            <a class="text-orange-600 underline font-light m-auto ml-24 md:ml-[11%] lg:ml-[21%] xl:ml-[28%] md:text-sm mt-12" href="#">¿Aún no tienes una cuenta? <b>¡Registrate!</b></a>

            <input class="text-orange-600 text-center font-bold text-xl md:text-lg bg-zinc-800 border-4 md:border-2 border-orange-600 rounded-full block m-auto ml-26 lg:ml-27 xl:ml-[27%] mt-5 p-1 px-2 xl:px-4 italic hover:bg-orange-600 hover:text-zinc-800 hover:transition-all duration-500 ease-in-out " type="submit" value="Crea una cuenta gratuita">

        </div>
        
    </div>
</body>
</html>
