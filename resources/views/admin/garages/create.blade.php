@extends('layouts.admin')

@section('content')
	
	@component('components.card')
		@slot('title', 'Nuevo Taller')

		{!! Form::open([
			'route' => ['admin.garages.store'],
			'method' => 'POST',
			'class' => 'w-full'
		]) !!}	

		@include('admin.garages.form')

		<div class="flex justify-end">
			<button class="px-4 py-1 rounded text-white bg-indigo-600 shadow flex items-center">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection