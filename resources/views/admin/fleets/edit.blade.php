@extends('layouts.admin')

@section('content')
	
	@component('components.card')
		@slot('title', 'Editar Flota')

		{!! Form::model($fleet, [
			'route' => ['admin.fleets.update', $fleet],
			'method' => 'PUT',
			'class' => 'w-full'
		]) !!}	

		@include('admin.fleets.form')

		<div class="flex justify-end mt-3">
			<button class="btn-indigo">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection