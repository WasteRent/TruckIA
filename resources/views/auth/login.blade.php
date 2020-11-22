@extends('layouts.auth')

@section('content')
<div class="relative max-w-md mx-auto">

  {!! Form::open([
  'route' => 'login',
  'method' => 'POST',
  'class' => 'bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 mt-16'
  ]) !!}
  <div class="max-w-xs mx-auto">

    <img class="mx-auto h-12 w-auto" src="https://truckts.com/img/logos/truckts_logo.png" alt="truckts-logo" />
    <h2 class="mt-6 mb-3 text-center text-xl leading-9 font-bold text-gray-800 ">
      ¡Bienvenido!
    </h2>
    <div class="relative">
      {!! Form::text('username', null, ['placeholder' => 'Usuario', 'class' => "appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-blue-700 focus:border-blue-300 focus:z-10 sm:text-sm sm:leading-5 ".($errors->has('username') ? 'border-red-500':'')]) !!}
      <div class=" @if(!$errors->has('username')) hidden @endif pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-red-500">
        <div class="fill-current h-4 w-4"><i class="fas fa-exclamation-circle"></i></div>

      </div>
    </div>
    <div class="relative @if(!$errors->has('username')) -mt-px @endif">
      {!! Form::password('password', ['placeholder' => 'Contraseña','class' => "appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-blue-700 focus:border-blue-300 focus:z-10 sm:text-sm sm:leading-5 ".($errors->has('password') ? 'border-red-500':'')]) !!}
      <div class=" @if(!$errors->has('password')) hidden @endif pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-red-500">
        <div class="fill-current h-4 w-4"> <i class="fas fa-exclamation-circle"></i></div>

      </div>
    </div>
    @error('username')
    <p class="text-red-500 text-xs italic mt-1" role="alert">
      <strong>{{ $message }}</strong>
    </p>
    @enderror

    @error('password')
    <p class="text-red-500 text-xs italic mt-1" role="alert">
      <strong>{{ $message }}</strong>
    </p>
    @enderror

    <div class="mt-6 flex items-center justify-between">
      <div class="flex items-center">
        <input class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
        <label class="ml-2 block text-sm leading-5 text-gray-900" for="remember">
          {{ __('Recuérdame') }}
        </label>
      </div>

      @if (Route::has('password.request'))
      <div class="text-sm leading-5">
        <a class="font-medium text-green-truckts hover:text-green-trucktslighter focus:outline-none focus:underline transition ease-in-out duration-150" href="{{ route('password.request') }}">
          {{ __('¿Has olvidado la contraseña?') }}
        </a>
      </div>
      @endif

    </div>
    <div class="mt-6">
      <button class="group w-full flex justify-center py-2 px-4 border border-transparent text-sm font-bold rounded-md text-white bg-green-truckts hover:bg-green-trucktslighter focus:outline-none focus:border-green-700 focus:ring-green active:bg-green-truckts transition duration-150 ease-in-out" type="submit">
        Entrar
      </button>
    </div>
  </div>

</div>

{!! Form::close() !!}
<div>

  <p class="text-center text-gray-500 text-xs">
    &copy;{{ date('Y') }} TruckTS. All rights reserved.
  </p>
</div>

@endsection