@extends('layouts.customer')

@section('content')
	
	@component('components.card')
		@slot('title', 'Reportar Accidente ' . $vehicle->plate)

		{!! Form::open([
			'route' => ['customer.vehicles.accident-reports.store', $vehicle],
			'method' => 'POST',
			'class' => 'w-full',
			'files' => true
		]) !!}	

		@include('customer.accident_reports.form')

		<div class="flex justify-end">
			<button class="btn-indigo">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection