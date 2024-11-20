@extends('layouts.auth')

@section('content')
<section class="bg-gradient-to-b from-transparent to-green-50 overflow-hidden" style="    height: 100vh;">

  <div class="">

    <div class="sm:grid grid-cols-2 px-4 sm:px-0"> 
      <div class="mx-auto mt-10 z-50">
        <h1 class="sm:ml-96 text-3xl font-semibold mb-10 text-gray-700">Empieza a <span class="text-teal-500">cuidar de tu flota</span></h1>

        {!! Form::open(['route' => 'login.simple', 'method' => 'POST', 'class' => 'outter-shadow bg-white px-4 py-8 rounded-md sm:ml-96 sm:w-96 w-full']) !!}
        <div class="max-w-xs mx-auto">

          <a href="/"><img class="mx-auto h-24 w-auto" src="{{ asset('img/truck-i-l.png') }}" alt="truckts-logo" /></a>
          <h2 class="mt-6 mb-3 text-center text-xl leading-9 font-bold text-gray-800 ">
            {{ __('¡Bienvenido!') }}
          </h2>

          <div class="mb-4">
            {!! Form::text('username', null, ['placeholder' => 'Usuario', 'class' => "py-5 px-7 rounded-md border-0 outter-shadow w-full ".($errors->has('username') ? 'border-red-500':'')]) !!}
          </div>

          @error('username')
          <p class="text-red-500 text-xs italic mt-1" role="alert">
            <strong>{{ $message }}</strong>
          </p>
          @enderror


          <div class="mt-6 flex items-center justify-between">
            <div class="flex items-center">
              <input class="h-4 w-4 text-indigo-600 transition duration-150 ease-in-out" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
              <label class="ml-2 block text-sm leading-5 text-gray-900" for="remember">
                {{ __('Recuérdame') }}
              </label>
            </div>

            @if (Route::has('password.request'))
            <div class="text-sm leading-5">
              <a class="font-medium text-teal-500 focus:outline-none focus:underline transition ease-in-out duration-150" href="{{ route('password.request') }}">
                {{ __('¿Has olvidado la contraseña?') }}
              </a>
            </div>
            @endif

          </div>
          <div class="mt-6">
            <button class="bg-teal-500 text-white px-10 py-2 rounded" type="submit">
              {{ __('Entrar') }}
            </button>
          </div>
        </div>
        {!! Form::close() !!}
      </div>
      <img src="{{ asset('img/login.png') }}"> 
    </div>
  </div>

</section>
@endsection