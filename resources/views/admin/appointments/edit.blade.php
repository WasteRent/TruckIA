@extends('layouts.admin')

@section('content')
	
	@component('components.card')
		@slot('title', 'Editar Cita')

		{!! Form::model($appointment, [
			'route' => ['admin.appointments.update', $appointment],
			'method' => 'PUT',
			'class' => 'w-full'
		]) !!}	

		@include('admin.appointments.form')

		<div class="flex justify-end">
			<button class="btn-indigo">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection