@extends('layouts.fleet')

@section('content')

	@component('components.card')
		@slot('title', 'Editar contador ' . $vehicle->plate)

		{!! Form::model($counter, [
			'route' => ['fleet.vehicles.counters.update', $vehicle, $counter],
			'method' => 'PUT',
			'files' => true,
			'class' => 'w-full'
		]) !!}	

		@include('fleet.vehicles.counters.form')

		<div class="flex justify-end">
			<button class="btn-indigo">Actualizar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection