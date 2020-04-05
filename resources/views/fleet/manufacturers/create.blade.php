@extends('layouts.fleet')

@section('content')
	
	@component('components.card')
		@slot('title', 'Nueva Marca')

		{!! Form::open([
			'route' => ['fleet.manufacturers.store'],
			'method' => 'POST',
			'class' => 'w-full'
		]) !!}	

		@include('fleet.manufacturers.form')

		<div class="flex justify-end">
			<button class="btn-indigo">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection