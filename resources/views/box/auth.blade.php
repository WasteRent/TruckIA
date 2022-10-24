@extends('layouts.auth')

@section('content')
<section class="bg-gradient-to-b from-transparent to-green-50 overflow-hidden" style="    height: 100vh;">

  <div class="">

    <div class="sm:grid grid-cols-2 px-4 sm:px-0"> 
      <div class="mx-auto mt-10 z-50">
        <h1 class="sm:ml-96 text-3xl font-semibold mb-10 text-gray-700">Empieza a <span class="text-teal-500">cuidar de tu flota</span></h1>


        {!! Form::open(['method' => 'POST', 'class' => 'outter-shadow bg-white px-4 py-8 rounded-md sm:ml-96 sm:w-96 w-full']) !!}
        <div class="max-w-xs mx-auto">

          <a href="/"><img class="mx-auto h-24 w-auto" src="{{ asset('img/truck-i-l.png') }}" alt="truckts-logo" /></a>
          <h2 class="mt-6 mb-3 text-center text-xl leading-9 font-bold text-gray-800 ">
            {{ __('¡Bienvenido!') }}
          </h2>

          <input type="hidden" name="qrid" value="{{ request()->query('qrid') }}">


        	@if(isset($vehicle))
	          <div class="mb-4">
	            {!! Form::text('', request()->query('qrid') . " / {$vehicle->plate} " . $vehicle->chassis, ['disabled' => 1, 'class' => "py-5 px-7 rounded-md border-0 outter-shadow w-full text-sm"]) !!}
	          </div>
	          <div class="mb-4">
	            {!! Form::text('username', null, ['placeholder' => 'Usuario', 'class' => "py-5 px-7 rounded-md border-0 outter-shadow w-full ".($errors->has('username') ? 'border-red-500':'')]) !!}
	          </div>
	          <div class="mb-4">
	            {!! Form::password('password', ['placeholder' => 'Contraseña','class' => "py-5 px-7 rounded-md border-0 outter-shadow w-full ".($errors->has('password') ? 'border-red-500':'')]) !!}
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
	            @if (Route::has('password.request'))
	            <div class="text-sm leading-5">
	              <a class="font-medium text-teal-500 focus:outline-none focus:underline transition ease-in-out duration-150" href="{{ route('password.request') }}">
	                {{ __('¿Has olvidado la contraseña?') }}
	              </a>
	            </div>
	            @endif
	          </div>
	          <div class="mt-6">
	            <button class="bg-teal-500 text-white px-10 py-2 rounded flex" type="submit">
	              <span class="mr-2">{{ __('Entrar') }}</span>

	              <svg class="w-6 h-6 text-teal-200" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M48 32C21.5 32 0 53.5 0 80v96c0 26.5 21.5 48 48 48h96c26.5 0 48-21.5 48-48V80c0-26.5-21.5-48-48-48H48zm80 64v64H64V96h64zM48 288c-26.5 0-48 21.5-48 48v96c0 26.5 21.5 48 48 48h96c26.5 0 48-21.5 48-48V336c0-26.5-21.5-48-48-48H48zm80 64v64H64V352h64zM256 80v96c0 26.5 21.5 48 48 48h96c26.5 0 48-21.5 48-48V80c0-26.5-21.5-48-48-48H304c-26.5 0-48 21.5-48 48zm64 16h64v64H320V96zm32 352v32h32V448H352zm96 0H416v32h32V448zM416 288v32H352V288H256v96 96h64V384h32v32h96V352 320 288H416z"/></svg>
	            </button>
	          </div>
	        @else
	        	<p class="text-center">El código {{ request()->query('qrid') }} no está asociado a ningún vehículo.</p>
	       	@endif
        </div>
        {!! Form::close() !!}
      </div>
      <img src="{{ asset('img/login.png') }}"> 
    </div>
  </div>

</section>
@endsection