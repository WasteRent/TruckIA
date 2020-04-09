@extends('layouts.fleet')

@section('content')

	@include('fleet.vehicles.edit_tabs', ['active_form' => true])

	<!--
	@includeWhen($vehicle->tracking()->count() > 0, 'fleet.vehicles.tracking')
	-->

	@component('components.card')
		@slot('title', 'Editar Vehículo')

		{!! Form::model($vehicle, [
			'route' => ['fleet.vehicles.update', $vehicle],
			'method' => 'PUT',
			'class' => 'w-full'
		]) !!}	

		@include('fleet.vehicles.form')

		<div class="flex justify-end">
			<button class="btn-indigo">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection