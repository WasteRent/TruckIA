@extends('layouts.fleet')

@section('content')
	@component('components.card')
		@slot('title', 'Editar Plan de Mantenimiento')
			{!! Form::model($plan, [
				'route' => ['fleet.maintenance-plans.update', $plan],
				'method' => 'PUT',
				'class' => 'w-full'
			]) !!}			
			  @include('fleet.maintenance_plans.form')
			  <div class="flex justify-end">
			  	<button class="btn-indigo">Guardar</button>
			  </div>
			{!! Form::close() !!}
	@endcomponent
@endsection