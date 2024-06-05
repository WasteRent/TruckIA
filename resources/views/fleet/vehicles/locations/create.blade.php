@extends('layouts.fleet')

@section('content')

	@component('components.card')
		@slot('title', 'Nueva ubicación')

		{!! Form::open([
			'route' => ['fleet.locations.store'],
			'method' => 'POST',
			'class' => 'w-full'
		]) !!}

		@include('fleet.vehicles.locations.form')

		<div class="flex justify-end">
			<button class="btn-indigo">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection