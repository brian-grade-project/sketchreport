@extends('layout.master')

@section('title', 'Cambiar Contraseña')

@section('content')

<div class="w-[100vw] min-h-[100vh] bg-[url(/img/imglogin.jpg)] bg-no-repeat bg-cover pt-5 relative" >
    <div class="bg-black/20 backdrop-blur-sm w-[100vw] min-h-[100vh] fixed inset-0 z-0"></div>
        <div class="w-[30%] md:w-[41%] min-h-[95%] md:min-h-[90%] lg:min-h-[95%] bg-zinc-800 m-auto mt-5 relative overflow-visible rounded-3xl z-10">
            <div class="ml-12 lg:ml-[13%] xl:ml-[19%] 2xl:ml-[24%] m-auto">
                <p class="text-2xl text-orange-600 font-black pt-3">CAMBIO DE CONTRASEÑA</p>
            </div>

            <div class="mt-3 ml-12 w-[80%] 2xl:ml-[9%] h-[0.3%] bg-orange-600">
            </div>

            <form action="{{ route('password.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mt-3 m-auto w-[100%] min-h-[75%] p-2 pb-8 bg-zinc-700">
                    <label for="current_password" class="text-orange-600 block font-light text-xl md:mt-3 ml-[21%]">Contraseña Actual</label>
                    <div class="bg-zinc-800 p-2 ml-[15%] rounded-full w-[70%]">
                        <input type="password" class="rounded-full w-[99%] p-1 pl-3 m-auto focus:bg-orange-600" 
                               id="current_password" name="current_password" 
                               placeholder="Ingrese su contraseña actual" required>
                    </div>

                    <div class="mt-7 lg:mt-8 xl:mt-9 2xl:ml-[19%] ml-[21%] border border-2 border-dashed w-[60%] h-[0.3%] border-orange-600">
                    </div>
                    
                    <label for="new_password" class="text-orange-600 block font-light text-xl ml-[21%] mt-7">Nueva Contraseña</label>
                    <div class="bg-zinc-800 p-2 ml-[15%] rounded-full w-[70%]">
                        <input type="password" class="rounded-full w-[99%] p-1 pl-3 m-auto focus:bg-orange-600" 
                               id="new_password" name="new_password" 
                               placeholder="Ingrese nueva contraseña" required>
                    </div>

                    <div class="mt-7 lg:mt-8 xl:mt-9 2xl:ml-[19%] ml-[21%] border border-2 border-dashed w-[60%] h-[0.3%] border-orange-600">
                    </div>
                    
                    <label for="new_password_confirmation" class="text-orange-600 block font-light text-xl ml-[21%] mt-7">Confirme Contraseña</label>
                    <div class="bg-zinc-800 p-2 ml-[15%] rounded-full w-[70%]">
                        <input type="password" class="rounded-full w-[99%] p-1 pl-3 m-auto focus:bg-orange-600" 
                               id="new_password_confirmation" name="new_password_confirmation" 
                               placeholder="Confirme nueva contraseña" required>
                    </div>

                    @if($errors->any())
                        <div class="mt-4 ml-[15%] text-red-500">
                            @foreach($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="relative block mt-10 mb-10 ml-[18%] w-[65%] rounded-full inline-block">
                    <button type="submit" class="btn-sm text-center bg-orange-600 w-full rounded-full text-xl font-light h-full hover:bg-orange-700 hover:text-white hover:font-semibold">
                        Cambiar Contraseña
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection