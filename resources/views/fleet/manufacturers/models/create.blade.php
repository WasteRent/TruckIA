@extends('layouts.fleet')

@section('content')
	
	@component('components.card')
		@slot('title', 'Nuevo Modelo')

		{!! Form::open([
			'route' => ['fleet.manufacturers.models.store', $manufacturer],
			'method' => 'POST',
			'class' => 'w-full'
		]) !!}	

		@include('fleet.manufacturers.models.form')

		<div class="flex justify-end">
			<button class="btn-indigo">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection