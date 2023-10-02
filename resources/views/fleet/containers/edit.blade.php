@extends('layouts.fleet')

@section('title', $container->reference .' '. $container->maker)

@section('content')


	@include('fleet.containers.edit_tabs', ['active_form' => true])


	@component('components.card')
		@slot('title', __('Editar Contenedor'))

		{!! Form::model($container, [
			'route' => ['fleet.containers.update', $container],
			'method' => 'PUT',
			'class' => 'w-full'
		]) !!}	

		@include('fleet.containers.form')

		<div class="flex justify-end">
			<button class="btn-indigo">{{ __('Guardar') }}</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection