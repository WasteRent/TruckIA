@extends('layouts.fleet')

@section('content')

	@include('fleet.vehicles.edit_tabs', ['active_form' => true])

	@include('fleet.vehicles.tracking')

	@component('components.card')
		@slot('title', 'Editar Vehículo')

		@slot('corner')
			<a href="{{ route('fleet.vehicles.show', $vehicle) }}" class="btn-outline-gray">Vista previa</a>
		@endslot

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