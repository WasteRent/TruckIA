@extends('layouts.garage')

@section('content')
	
	@component('components.card')
		@slot('title', 'Datos del Taller')

		{!! Form::model($garage, [
			'route' => ['garage.details.update'],
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