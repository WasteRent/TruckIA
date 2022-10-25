@extends('layouts.fleet')

@section('content')
	
	@component('components.card')
		@slot('title', 'Nuevo Operación - ' . optional($plan->manufacturer)->name .' '. optional($plan->model)->name)

		{!! Form::open([
			'route' => ['fleet.maintenance-plans.operations.store', $plan],
			'method' => 'POST',
			'class' => 'w-full',
			'files' => true
		]) !!}	

		@include('fleet.maintenance_plans.operations.form')

		<div class="flex justify-end">
			<button class="btn-indigo">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection