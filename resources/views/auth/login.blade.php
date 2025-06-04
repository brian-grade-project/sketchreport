@extends('auth.master')

@section('title', 'Iniciar Sesión - SketchReport')

@section('content')
    @if($errors->any())
        <div class="bg-yellow-400 h-[30px] text-black px-4 flex items-center justify-center">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="w-screen h-screen flex flex-row">
        <img src="{{ asset('img/imglogin.jpg') }}" class="w-4/6 md:w-[60%] h-screen float-left object-cover" alt="Imagen de fondo">
        <div class="h-screen md:w-[39%] w-2/6 bg-zinc-800 float-right relative overflow-clip">
            <div class="border-4 md:border-2 border-orange-600 rounded-full w-7/12 md:w-8/12 m-auto mt-10 md:mt-8">
                <img src="{{ asset('img/logotipo1.svg') }}" class="w-9/12 md:w-[95%] lg:w-[90%] p-3 xl:p-5 m-auto" alt="Logo">
            </div>

            <p class="text-center font-semibold italic m-auto mt-4 xl:mt-6 bg-orange-600 text-zinc-800">Inicia sesión e inicia una mejor gestión</p>

            <form action="{{ route('login.check') }}" method="POST" class="mt-8">
                @csrf
                <div class="mb-4">
                    <label class="text-xl md:text-lg text-orange-600 block ml-28 md:ml-[25%] font-light" for="email">Usuario</label>
                    <input name="email" class="bg-white rounded-full w-7/12 m-auto ml-24 md:ml-[22%] p-1 focus:bg-orange-600 focus:text-white text-yellow-800" type="email" placeholder="Ingrese usuario" id="email" value="{{ old('email') }}" required>
                </div>

                <div class="mb-4">
                    <label class="text-xl md:text-lg text-orange-600 block ml-28 md:ml-[25%] font-light" for="password">Contraseña</label>
                    <input name="password" class="bg-white rounded-full w-7/12 m-auto ml-24 md:ml-[22%] p-1 focus:bg-orange-600 focus:text-white text-yellow-800" type="password" placeholder="Ingrese contraseña" id="password" required>
                </div>

                <div class="mb-4">
                    <label class="text-orange-600 ml-24 md:ml-[22%]">
                        <input type="checkbox" name="remember" class="mr-2">
                        Recordarme
                    </label>
                </div>

                <div class="mb-4">
                    <a class="text-orange-600 underline font-light m-auto ml-36 md:ml-[22%] lg:ml-[29%] xl:ml-[34%]" href="#">¿Olvidaste tu contraseña?</a>
                </div>

                <button type="submit" class="text-orange-600 text-lg font-bold bg-zinc-800 border-2 border-orange-600 rounded-full block m-auto ml-24 md:ml-[23%] p-1 italic hover:bg-orange-600 hover:text-zinc-800 hover:transition-all duration-500 ease-in-out w-7/12">
                    Ingresar
                </button>
            </form>

            <div class="w-screen h-6 bg-orange-600 mt-6 mb-3"></div>

            <div class="text-center">
                <a href="{{ route('register') }}" class="text-orange-600 underline font-light md:text-sm mt-2 inline-block">¿Aún no tienes una cuenta? <b>¡Registrate!</b></a>

                <a href="{{ route('register') }}" class="text-orange-600 text-center font-bold text-xl md:text-lg bg-zinc-800 border-4 md:border-2 border-orange-600 rounded-full block m-auto mt-3 p-1 px-2 xl:px-4 italic hover:bg-orange-600 hover:text-zinc-800 hover:transition-all duration-500 ease-in-out w-7/12">
                Crea una cuenta gratuita
            </a>
            </div>
        </div>
    </div>
@endsection
