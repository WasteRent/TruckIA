@extends('layouts.admin')

@section('content')
<div class="py-4">
	@component('components.card')
		<h1 class="mb-4 text-lg font-medium">Plan de mantenimiento</h1>
		<div>
			{!! Form::model($plan, [
				'route' => ['admin.maintenance-plans.update', $plan],
				'method' => 'PUT',
				'class' => 'w-full'
			]) !!}			
			  @include('admin.maintenance.form')
			  <div class="flex justify-end">
			  	<button class="px-4 py-1 rounded text-white bg-indigo-600 shadow flex items-center">Guardar</button>
			  </div>
			{!! Form::close() !!}
		</div>
	@endcomponent
</div>
<div class="py-4">
	@component('components.card')			
		<h1 class="mb-4 text-lg font-medium">Operaciones</h1>
		<div>
			@foreach($plan->operations as $operation)
				{!! Form::model($operation, [
					'route' => ['admin.maintenance-operations.update', $operation],
					'method' => 'PUT',
					'class' => 'w-full'
				]) !!}			

					@include('admin.maintenance.operations.form')
				
				{!! Form::close() !!}
			@endforeach
		</div>
	@endcomponent
</div>
@endsection