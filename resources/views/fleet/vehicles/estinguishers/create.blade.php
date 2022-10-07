@extends('layouts.fleet')

@section('title', 'Nuevo extintor ' . $vehicle->plate)

@section('content')
	
	@component('components.card')
		@slot('title', 'Nuevo extintor')

		{!! Form::open([
			'route' => ['fleet.vehicles.estinguishers.store', $vehicle],
			'method' => 'POST',
			'class' => 'w-full'
		]) !!}	

		@include('fleet.vehicles.estinguishers.form')

		<div class="flex justify-end">
			<button class="btn-indigo">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection