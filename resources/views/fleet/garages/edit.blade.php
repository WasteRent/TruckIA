@extends('layouts.fleet')

@section('title', $garage->name)

@section('content')

	@include('fleet.garages.tabs', ['active_edit' => true])
	
	@component('components.card')

		{!! Form::model($garage, [
			'route' => ['fleet.garages.update', $garage],
			'method' => 'PUT',
			'class' => 'w-full'
		]) !!}	

		@include('fleet.garages.form')

		<div class="flex justify-end">
			<button class="btn-indigo">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection