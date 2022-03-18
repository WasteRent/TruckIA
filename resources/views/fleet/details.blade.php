@extends('layouts.fleet')

@section('content')
	
	@component('components.card')
		@slot('title', __('Datos'))

		{!! Form::model($fleet, [
			'route' => ['fleet.details.update'],
			'method' => 'PUT',
			'class' => 'w-full'
		]) !!}	
			
			@include('admin.fleets.form')

			<div class="flex justify-end">
				<button class="btn-indigo">{{ __('Guardar') }}</button>
			</div>
		{!! Form::close() !!}
	@endcomponent

@endsection