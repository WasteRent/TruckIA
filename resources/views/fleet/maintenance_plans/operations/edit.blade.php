@extends('layouts.fleet')

@section('content')

	@component('components.card')
		@slot('title', 'Editar Operación - ' . $plan->name . ' ' . optional($plan->manufacturer)->name .' '. optional($plan->model)->name)

		{!! Form::model($operation, [
			'route' => ['fleet.maintenance-plans.operations.update', $plan, $operation],
			'method' => 'PUT',
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