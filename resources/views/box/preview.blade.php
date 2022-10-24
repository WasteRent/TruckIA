@extends('layouts.auth')

@section('content')
<section class="bg-gradient-to-b from-transparent to-green-50 overflow-hidden" style="    height: 100vh;">

  <div class="">

    <div class="sm:grid grid-cols-2 px-4 sm:px-0"> 
      <div class="mx-auto mt-10 z-50">
        <h1 class="sm:ml-96 text-3xl font-semibold mb-10 text-gray-700">Empieza a <span class="text-teal-500">cuidar de tu flota</span></h1>

        <iframe class="rounded w-full h-64" src="https://www.youtube.com/embed/RTdkEKC1Mjg" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

        <div class="flex justify-between space-x-3 mt-10">
        	<a target="_blank" href="https://truckts.com/contacto" class="bg-teal-500 text-white px-4 text-center py-2 rounded flex items-center" type="submit">
        	  <span class="mr-2">{{ __('Contactar') }}</span>
        	</a>

        	@if($vehicle)
        	<a href="{{ route('box.login') }}?qrid={{ request()->query('qrid') }}" class=" border-2 border-teal-500 text-teal-500 px-4 text-center py-2 rounded flex items-center" type="submit">
        	  <span class="mr-2">{{ __('Soy cliente, ir al vehículo') }}</span>
        	</a>
        	@endif
        </div>

      </div>
      <img src="{{ asset('img/login.png') }}"> 
    </div>
  </div>

</section>
@endsection