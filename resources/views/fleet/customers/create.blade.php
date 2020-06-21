@extends('layouts.fleet')

@section('title', 'Clientes')

@section('content')
	
	@component('components.card')
		@slot('title', 'Nuevo Cliente')

		{!! Form::open([
			'route' => ['fleet.customers.store'],
			'method' => 'POST',
			'class' => 'w-full'
		]) !!}	

		@include('fleet.customers.form')

		<div class="flex justify-end">
			<button class="btn-indigo">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection