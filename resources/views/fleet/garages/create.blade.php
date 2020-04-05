@extends('layouts.fleet')

@section('content')
	
	@component('components.card')
		@slot('title', 'Nuevo Taller')

		{!! Form::open([
			'route' => ['fleet.garages.store'],
			'method' => 'POST',
			'class' => 'w-full'
		]) !!}	

		@include('fleet.garages.form')

		<div class="flex justify-end">
			<button class="btn-indigo">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection