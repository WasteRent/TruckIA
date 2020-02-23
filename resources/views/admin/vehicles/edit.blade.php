@extends('layouts.admin')

@section('content')

	@component('components.tabs', [
		'items' => [
			[
				'name' => 'Datos vehículo',
				'url' => '',
				'active' => true
			],
			[
				'name' => 'Talleres asignados',
				'url' => route('admin.vehicles.garages.index', $vehicle),
				'active' => false
			]
		]
	])
	@endcomponent
	
	@component('components.card')
		@slot('title', 'Editar Vehículo')

		{!! Form::model($vehicle, [
			'route' => ['admin.vehicles.update', $vehicle],
			'method' => 'PUT',
			'class' => 'w-full'
		]) !!}	

		@include('admin.vehicles.form')

		<div class="flex justify-end">
			<button class="px-4 py-1 rounded text-white bg-indigo-600 shadow flex items-center">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection