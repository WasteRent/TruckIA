@extends('layouts.fleet')

@section('title', __('Contenedores'))

@section('content')
	
	@component('components.card')
		@slot('title', __('Nuevo Contenedor'))

		{!! Form::open([
			'route' => ['fleet.containers.store'],
			'method' => 'POST',
			'class' => 'w-full'
		]) !!}	

		@include('fleet.containers.form')

		<div class="flex justify-end">
			<button class="btn-indigo">{{ __('Guardar') }}</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection