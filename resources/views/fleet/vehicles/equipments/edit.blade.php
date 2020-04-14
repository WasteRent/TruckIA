@extends('layouts.fleet')

@section('content')

	@component('components.card')
		@slot('title', 'Editar equipo ' . $vehicle->plate)

		{!! Form::model($equipment, [
			'route' => ['fleet.vehicles.equipments.update', $vehicle, $equipment],
			'method' => 'PUT',
			'files' => true,
			'class' => 'w-full'
		]) !!}	

		@include('fleet.vehicles.equipments.form')

		<div class="flex justify-end">
			<button class="btn-indigo">Actualizar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

	

@endsection