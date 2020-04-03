@extends('layouts.fleet')

@section('content')
	
	@component('components.card')
		@slot('title', 'Datos')

		{!! Form::model($fleet, [
			'route' => ['fleet.details.update'],
			'method' => 'PUT',
			'class' => 'w-full'
		]) !!}	
			
			@include('admin.fleets.form')

			<div class="flex justify-end">
				<button class="btn-indigo">Guardar</button>
			</div>
		{!! Form::close() !!}
	@endcomponent

@endsection