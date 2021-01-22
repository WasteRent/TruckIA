@extends('layouts.admin')

@section('content')
	
	@component('components.card')
		@slot('title', 'Nueva Marca')

		{!! Form::open([
			'route' => ['admin.manufacturers.store'],
			'method' => 'POST',
			'class' => 'w-full'
		]) !!}	

		@include('admin.manufacturers.form')

		<div class="flex justify-end">
			<button class="btn-indigo">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection