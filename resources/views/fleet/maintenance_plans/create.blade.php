@extends('layouts.fleet')

@section('content')
	
	@component('components.card')
		@slot('title', 'Nuevo Plan de Mantenimiento')

		{!! Form::open([
			'route' => ['fleet.maintenance-plans.store'],
			'method' => 'POST',
			'class' => 'w-full'
		]) !!}	

		@include('fleet.maintenance_plans.form')

		<div class="flex justify-end">
			<button class="btn-indigo">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection