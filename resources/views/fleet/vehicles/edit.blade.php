@extends('layouts.fleet')

@section('content')
	
	<div class="text-right mb-3">
		<a href="{{ $next_vehicle_url }}">
			<i class="fas fa-arrow-alt-circle-right fa-lg text-indigo-600"></i>
		</a>
	</div>


	@include('fleet.vehicles.edit_tabs', ['active_form' => true])

	@include('fleet.vehicles.tracking')

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