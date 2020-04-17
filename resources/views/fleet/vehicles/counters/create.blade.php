@extends('layouts.fleet')

@section('content')

	@component('components.card')
		@slot('title', 'Nuevo contador ' . $vehicle->plate)

		{!! Form::open([
		  'route' => ['fleet.vehicles.counters.store', $vehicle],
		  'method' => 'POST',
		  'files' => true,
		  'class' => 'w-full'
		]) !!}  


		  @include('fleet.vehicles.counters.form')

		  <div class="flex justify-end">
		    <button class="btn-indigo">Guardar</button>
		  </div>

		{!! Form::close() !!}
	@endcomponent

@endsection