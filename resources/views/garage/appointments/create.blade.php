@extends('layouts.garage')

@section('content')
	
	@component('components.card')
		@slot('title', 'Nueva Cita')

		{!! Form::open([
			'route' => ['garage.appointments.store'],
			'method' => 'POST',
			'class' => 'w-full'
		]) !!}	

		<div>
			@php 
			$customer = App\Models\Vehicle::findOrFail(request()->vehicle_id ?? $appointment->vehicle_id)->customers->first();
			@endphp
			Contacto: {{$customer ? $customer->name:''}} - {{ $customer ? $customer->contact1:'' }} {{ $customer ? $customer->phone1:'' }}
			<br><br>
		</div>

		@include('garage.appointments.form')

		<div class="flex justify-end">
			<button class="px-4 py-1 rounded text-white bg-indigo-600 shadow flex items-center">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection