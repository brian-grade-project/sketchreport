{{-- // TODO: vista para inicio de sesión --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - SketchReport</title>
    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    @if($errors->any())
        <div class="bg-yellow-400 h-[30px] text-black px-4 flex items-center justify-center">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="w-screen h-screen flex flex-row">
        <img src="/img/imglogin.jpg" class="w-4/6 md:w-[60%] h-screen float-left object-cover" alt="Imagen de fondo">
        <div class="h-screen md:w-[39%] w-2/6 bg-zinc-800 float-right relative overflow-clip">
            <div class="border-4 md:border-2 border-orange-600 rounded-full w-7/12 md:w-8/12 m-auto mt-10 md:mt-8">
                <img src="/img/logotipo1.svg" class="w-9/12 md:w-[95%] lg:w-[90%] p-3 xl:p-5 m-auto" alt="Logo">
            </div>
           
            <!--<div class=" w-8/12 border-2 border-orange-600 rounded-full m-auto mt-4 p-2">
                
            </div> -->
            <p class="text-center font-semibold italic m-auto mt-4 xl:mt-6 bg-orange-600 text-zinc-800">Crea tu cuenta y comienza a gestionar</p>

            <form action="{{ route('register.store') }}" method="POST" class="mt-8">
                @csrf
                <div class="inline-block ml-[9%] w-[35%]">
                    <label class="text-xl md:text-lg text-orange-600 block ml-[20%] md:ml-[20%] mt-8 font-light" for="name">Nombres</label>
                    <input name="name" 
                           class="bg-white text-yellow-800 rounded-full w-[100%] inline-block m-auto ml-[20%] md:ml-[13%] p-1 focus:bg-orange-600 focus:text-white @error('name') border-red-500 @enderror" 
                           type="text" 
                           placeholder="Ingrese nombres" 
                           id="name"
                           value="{{ old('name') }}"
                           required>
                    @error('name')
                        <span class="text-red-500 text-sm ml-[20%]">{{ $message }}</span>
                    @enderror
                </div>

                <div class="inline-block ml-[8%] w-[35%]">
                    <label class="text-xl md:text-lg text-orange-600 block ml-28 md:ml-[13%] mt-8 font-light" for="lastname">Apellidos</label>
                    <input name="lastname" 
                           class="bg-white text-yellow-800 rounded-full w-[100%] inline-block m-auto ml-24 md:ml-[5%] p-1 focus:bg-orange-600 focus:text-white @error('lastname') border-red-500 @enderror" 
                           type="text" 
                           placeholder="Ingrese apellidos" 
                           id="lastname"
                           value="{{ old('lastname') }}"
                           required>
                    @error('lastname')
                        <span class="text-red-500 text-sm ml-[20%]">{{ $message }}</span>
                    @enderror
                </div>

                <div class="block ml-[5%] w-[75%]">
                    <label class="text-xl md:text-lg text-orange-600 block ml-[20%] md:ml-[16%] mt-8 font-light" for="email">Email</label>
                    <input name="email" 
                           class="bg-white text-yellow-800 rounded-full w-[100%] inline-block m-auto ml-[20%] md:ml-[13%] p-1 focus:bg-orange-600 focus:text-white @error('email') border-red-500 @enderror" 
                           type="email" 
                           placeholder="Ingrese correo electrónico" 
                           id="email"
                           value="{{ old('email') }}"
                           required>
                    @error('email')
                        <span class="text-red-500 text-sm ml-[20%]">{{ $message }}</span>
                    @enderror
                </div>

                <div class="inline-block ml-[10%] w-[35%]">
                    <label class="text-xl md:text-lg text-orange-600 block ml-[20%] md:ml-[20%] mt-8 font-light" for="password">Contraseña</label>
                    <input name="password" 
                           class="bg-white text-yellow-800 rounded-full w-[100%] inline-block m-auto ml-[20%] md:ml-[13%] p-1 focus:bg-orange-600 focus:text-white @error('password') border-red-500 @enderror" 
                           type="password" 
                           placeholder="Ingrese contraseña" 
                           id="password"
                           required>
                    @error('password')
                        <span class="text-red-500 text-sm ml-[20%]">{{ $message }}</span>
                    @enderror
                </div>

                <div class="inline-block ml-[8%] mb-[5%] w-[35%]">
                    <label class="text-xl md:text-lg text-orange-600 block ml-28 md:ml-[15%] mt-8 font-light" for="password_confirmation">Confirmar</label>
                    <input name="password_confirmation" 
                           class="bg-white text-yellow-800 rounded-full w-[100%] inline-block m-auto ml-24 md:ml-[5%] p-1 focus:bg-orange-600 focus:text-white" 
                           type="password" 
                           placeholder="Confirme su contraseña" 
                           id="password_confirmation"
                           required>
                </div>

                <div class="ml-[12%] w-[81%] mr-[12%]">
                    <input class="inline" 
                           type="checkbox" 
                           name="terms" 
                           id="terms"
                           required>
                    <span class="text-orange-600 font-light text-sm">
                        Al crear tu cuenta estás aceptando nuestros 
                        <a class="text-orange-600 underline font-bold" href="#">términos y condiciones</a>
                    </span>
                    @error('terms')
                        <span class="text-red-500 text-sm block">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" 
                        class="text-orange-600 text-lg font-bold bg-zinc-800 border-2 border-orange-600 rounded-full block m-auto ml-24 md:ml-[23%] mt-5 md:mt-[8%] lg:mt-[5%] p-1 italic hover:bg-orange-600 hover:text-zinc-800 hover:transition-all duration-500 ease-in-out w-7/12">
                    Crear cuenta
                </button>
            </form>

            <div class="w-screen h-6 bg-orange-600 mt-6 mb-3"></div>
            
            <div class="text-center">
                <a href="{{ route('login') }}" class="text-orange-600 underline font-light md:text-sm mt-2 inline-block">
                    ¿Ya tienes una cuenta? <b>¡Inicia sesión!</b>
                </a>
            </div>
        </div>
    </div>
</body>
</html>
