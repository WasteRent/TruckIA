@extends('layouts.auth')

@section('content')
<section class="bg-gradient-to-b from-transparent to-green-50 overflow-hidden" style="    height: 100vh;">

  <div class="">
    <div class="sm:grid grid-cols-2 px-4 sm:px-0"> 
      <div class="mx-auto mt-10 z-50">
        <h1 class="sm:ml-96 text-3xl font-semibold mb-10 text-gray-700">Empieza a <span class="text-teal-500">cuidar de tu flota</span></h1>

        <iframe class="rounded w-full h-64" src="https://www.youtube.com/embed/RTdkEKC1Mjg" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

        <div class="flex justify-between space-x-3 mt-10">
        	<a target="_blank" href="https://truckts.com/contacto" class="w-full bg-teal-500 text-white px-4 text-center py-2 rounded flex items-center justify-center" type="submit">
        	  <span class="mr-2">{{ __('Contactar') }}</span>
        	</a>

        	@if($vehicle)
        	<a href="{{ route('box.login') }}?qrid={{ request()->query('qrid') }}" class=" border border-teal-500 text-teal-500 px-4 text-center py-2 rounded flex items-center text-xs" type="submit">
        	  <span class="mr-2">{{ __('Soy cliente, ir al vehículo') }}</span>
        	</a>
        	@endif
        </div>

        <div class="flex" style="margin-left: -2rem;margin-top: 4rem;">
          <img class="h-20" src="{{ asset('img/v/Ilustraciones_Web_TruckTS-04.png') }}">
          <img class="h-20" src="{{ asset('img/v/Ilustraciones_Web_TruckTS-05.png') }}">
          <img class="h-24" src="{{ asset('img/v/Ilustraciones_Web_TruckTS-06.png') }}">

          <img class="h-20" src="{{ asset('img/v/Ilustraciones_Web_TruckTS-02.png') }}">
          <img class="h-20" src="{{ asset('img/v/Ilustraciones_Web_TruckTS-03.png') }}">
        </div>

      </div>
      <img src="{{ asset('img/login.png') }}"> 
    </div>

  </div>

</section>
@endsection