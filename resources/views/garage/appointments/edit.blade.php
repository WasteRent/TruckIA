@extends('layouts.garage')

@section('content')
	
	@component('components.card')
		@slot('title', 'Editar Cita')

		{!! Form::model($appointment, [
			'route' => ['garage.appointments.update', $appointment],
			'method' => 'PUT',
			'class' => 'w-full'
		]) !!}	

		@include('garage.appointments.form')

		<div class="flex justify-end">
			<button class="px-4 py-1 rounded text-white bg-indigo-600 shadow flex items-center">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection