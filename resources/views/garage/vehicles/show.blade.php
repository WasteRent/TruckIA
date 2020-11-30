@extends('layouts.garage')

@section('content')
	
	@include('shared.vehicles.show', ['vehicle' => $vehicle])
	
	@component('components.card')
		@slot('title', 'Datos Vehículo')

		{!! Form::model($vehicle, [
			'route' => ['garage.vehicles.show', $vehicle],
			'method' => 'PUT',
			'class' => 'w-full'
		]) !!}	

		@include('garage.vehicles.form')
		{!! Form::close() !!}
	@endcomponent

@endsection
