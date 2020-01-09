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
			  @include('admin.maintenance_plans.form')
			  <div class="flex justify-end">
			  	<button class="px-4 py-1 rounded text-white bg-indigo-600 shadow flex items-center">Guardar</button>
			  </div>
			{!! Form::close() !!}
		</div>
	@endcomponent
@endsection