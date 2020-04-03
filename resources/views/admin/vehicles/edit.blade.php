@extends('layouts.admin')

@section('content')

	@include('admin.vehicles.edit_tabs', ['active_form' => true])
	
	@component('components.card')
		@slot('title', 'Editar Vehículo')

		{!! Form::model($vehicle, [
			'route' => ['admin.vehicles.update', $vehicle],
			'method' => 'PUT',
			'class' => 'w-full'
		]) !!}	

		@include('admin.vehicles.form')

		<div class="flex justify-end">
			<button class="btn-indigo">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection