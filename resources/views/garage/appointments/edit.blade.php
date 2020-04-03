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
			<button class="btn-indigo">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection