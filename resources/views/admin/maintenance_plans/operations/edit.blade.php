@extends('layouts.admin')

@section('content')

	@component('components.card')
		@slot('title', 'Editar Operación - ' . optional($plan->manufacturer)->name .' '. optional($plan->model)->name)

		{!! Form::model($operation, [
			'route' => ['admin.maintenance-plans.operations.update', $plan, $operation],
			'method' => 'PUT',
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