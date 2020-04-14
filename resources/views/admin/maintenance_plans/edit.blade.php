@extends('layouts.admin')

@section('content')
	@component('components.card')
		@slot('title', 'Editar Plan de Mantenimiento')
			{!! Form::model($plan, [
				'route' => ['admin.maintenance-plans.update', $plan],
				'method' => 'PUT',
				'class' => 'w-full'
			]) !!}			
			  @include('admin.maintenance_plans.form')
			  <div class="flex justify-end">
			  	<button class="btn-indigo">Guardar</button>
			  </div>
			{!! Form::close() !!}
	@endcomponent
@endsection