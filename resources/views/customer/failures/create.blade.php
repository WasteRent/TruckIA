@extends('layouts.customer')

@section('content')
	
	@component('components.card')
		@slot('title', 'Reportar Avería ' . $vehicle->plate)

		{!! Form::open([
			'route' => ['customer.vehicles.failures.store', $vehicle],
			'method' => 'POST',
			'class' => 'w-full'
		]) !!}	

		@include('customer.failures.form')

		<a class="text-indigo-600" target="_blank" href="https://www.allianz.es/centro-respuesta-rapida/peticion-grua">
			<i class="fas fa-life-ring"></i>
			Necesito grua
		</a>
		
		<div class="flex justify-end">
			<button class="btn-indigo">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection