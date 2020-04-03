@extends('layouts.admin')

@section('content')
	
	@component('components.card')
		@slot('title', 'Nuevo Plan de Mantenimiento')

		{!! Form::open([
			'route' => ['admin.maintenance-plans.store'],
			'method' => 'POST',
			'class' => 'w-full'
		]) !!}	

		@include('admin.maintenance_plans.form')

		<div class="flex justify-end">
			<button class="btn-indigo">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection