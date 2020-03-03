@extends('layouts.admin')

@section('title', 'Taller ' . $garage->name)

@section('content')

	@component('components.tabs', [
		'items' => [
			[
				'name' => 'Editar datos del taller',
				'url' => '',
				'active' => true
			],
			[
				'name' => 'Especialidades',
				'url' => route('admin.garage.specialities.index', $garage),
				'active' => false
			]
		]
	])
	@endcomponent
	
	@component('components.card')

		{!! Form::model($garage, [
			'route' => ['admin.garages.update', $garage],
			'method' => 'PUT',
			'class' => 'w-full'
		]) !!}	

		@include('admin.garages.form')

		<div class="flex justify-end">
			<button class="px-4 py-1 rounded text-white bg-indigo-600 shadow flex items-center">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection