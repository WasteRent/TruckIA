@extends('layouts.fleet')

@section('content')
	
	@component('components.card')
		@slot('title', 'Editar Modelo')

		{!! Form::model($model, [
			'route' => ['fleet.manufacturers.models.update', $manufacturer, $model],
			'method' => 'PUT',
			'class' => 'w-full'
		]) !!}	

		@include('fleet.manufacturers.models.form')

		<div class="flex justify-end">
			<button class="btn-indigo">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection