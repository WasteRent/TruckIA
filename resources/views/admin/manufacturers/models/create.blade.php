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
			<button class="px-4 py-1 rounded text-white bg-indigo-600 shadow flex items-center">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection