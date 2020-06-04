@extends('layouts.admin')

@section('content')
	
	@component('components.card')
		@slot('title', 'Nuevo Operación - ' . optional($plan->manufacturer)->name .' '. optional($plan->model)->name)

		{!! Form::open([
			'route' => ['admin.maintenance-plans.operations.store', $plan],
			'method' => 'POST',
			'class' => 'w-full',
			'files' => true
		]) !!}	

		@include('admin.maintenance_plans.operations.form')

		<div class="flex justify-end">
			<button class="btn-indigo">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection