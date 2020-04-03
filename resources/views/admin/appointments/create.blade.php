@extends('layouts.admin')

@section('content')
	
	@component('components.card')
		@slot('title', 'Nueva Cita')

		{!! Form::open([
			'route' => ['admin.appointments.store'],
			'method' => 'POST',
			'class' => 'w-full'
		]) !!}	

		@include('admin.appointments.form')

		<div class="flex justify-end">
			<button class="btn-indigo">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection