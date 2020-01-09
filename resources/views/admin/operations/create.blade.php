@extends('layouts.admin')

@section('content')
	
	@component('components.card')
		@slot('title', 'Nueva Operación')

		{!! Form::open([
			'route' => ['admin.operations.store'],
			'method' => 'POST',
			'class' => 'w-full'
		]) !!}	

		@include('admin.operations.form')

		<div class="flex justify-end">
			<button class="px-4 py-1 rounded text-white bg-indigo-600 shadow flex items-center">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection