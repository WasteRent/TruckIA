@extends('layouts.admin')

@section('content')
	
	@component('components.card')
		@slot('title', 'Nuevo Cliente')

		{!! Form::open([
			'route' => ['admin.customers.store'],
			'method' => 'POST',
			'class' => 'w-full'
		]) !!}	

		@include('admin.customers.form')

		<div class="flex justify-end">
			<button class="btn-indigo">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection