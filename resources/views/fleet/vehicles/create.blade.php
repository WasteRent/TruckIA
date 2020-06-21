@extends('layouts.fleet')

@section('title', 'Vehículos')

@section('content')
	
	@component('components.card')
		@slot('title', 'Nuevo Vehículo')

		{!! Form::open([
			'route' => ['fleet.vehicles.store'],
			'method' => 'POST',
			'class' => 'w-full'
		]) !!}	

		@include('fleet.vehicles.form')

		<div class="flex justify-end">
			<button class="btn-indigo">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection