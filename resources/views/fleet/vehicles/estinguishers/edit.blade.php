@extends('layouts.fleet')

@section('title', 'Editar extintor ' . $vehicle->plate)

@section('content')
	
	@component('components.card')

		{!! Form::model($estinguisher, [
			'route' => ['fleet.vehicles.estinguishers.update', [$vehicle, $estinguisher]],
			'method' => 'PUT',
			'class' => 'w-full'
		]) !!}	

		@include('fleet.vehicles.estinguishers.form')

		<div class="flex justify-end">
			<button class="btn-indigo">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection