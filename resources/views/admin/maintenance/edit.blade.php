@extends('layouts.admin')

@section('content')
	@component('components.card')
		@slot('title', 'Datos generales')
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

	@component('components.card')			
		@slot('title', 'Operaciones')

		<div class="float-right">
			<a href="{{ route('admin.maintenance-plans.operations.create', $plan) }}" class="flex items-center border rounded px-2 py-1">
				<ion-icon class="mr-1" name="ios-add-circle-outline"></ion-icon>
				Nuevo
			</a>
		</div>
		<br><br>

		<div>
			@foreach($plan->operations as $operation)
				{!! Form::model($operation, [
					'route' => ['admin.maintenance-plans.operations.update', $plan, $operation],
					'method' => 'PUT',
					'class' => 'w-full'
				]) !!}
					@include('admin.maintenance.operations.form')
				{!! Form::close() !!}
			@endforeach
		</div>
	@endcomponent
@endsection