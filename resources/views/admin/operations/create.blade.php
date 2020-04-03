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
			<button class="btn-indigo">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection