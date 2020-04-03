@extends('layouts.admin')

@section('content')
	
	@component('components.card')
		@slot('title', 'Nuevo Modelo')

		{!! Form::open([
			'route' => ['admin.manufacturers.models.store', $manufacturer],
			'method' => 'POST',
			'class' => 'w-full'
		]) !!}	

		@include('admin.manufacturers.models.form')

		<div class="flex justify-end">
			<button class="btn-indigo">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection