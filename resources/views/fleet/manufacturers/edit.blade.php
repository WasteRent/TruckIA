@extends('layouts.fleet')

@section('content')
	
	@component('components.card')
		@slot('title', 'Editar Marca')

		{!! Form::model($manufacturer, [
			'route' => ['fleet.manufacturers.update', $manufacturer],
			'method' => 'PUT',
			'class' => 'w-full'
		]) !!}	

		@include('fleet.manufacturers.form')

		<div class="flex justify-end">
			<button class="btn-indigo">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection