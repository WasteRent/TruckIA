@extends('layouts.fleet')

@section('title', 'Nuevo evento')

@section('content')
	
	@component('components.card')
		{!! Form::open([
			'route' => ['fleet.calendar.store'],
			'method' => 'POST',
			'class' => 'w-full'
		]) !!}	

		@include('fleet.calendar.form')

		<div class="flex justify-end">
			<button class="btn-indigo">{{ __('Guardar') }}</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection