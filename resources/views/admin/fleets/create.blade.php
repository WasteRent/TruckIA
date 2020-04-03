@extends('layouts.admin')

@section('content')
	
	@component('components.card')
		@slot('title', 'Nueva Flota')

		{!! Form::open([
			'route' => ['admin.fleets.store'],
			'method' => 'POST',
			'class' => 'w-full'
		]) !!}	

		@include('admin.fleets.form')

		<div class="flex justify-end">
			<button class="btn-indigo">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection