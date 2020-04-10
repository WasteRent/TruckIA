@extends('layouts.fleet')

@section('title', $customer->name)

@section('content')

	@component('components.tabs', [
		'items' => [
			[
				'name' => 'Editar datos',
				'url' => route('fleet.customers.edit', $customer),
				'active' => true
			],
			[
				'name' => 'Talleres asignados',
				'url' => route('fleet.customers.garages.index', $customer),
				'active' => false
			]
		]
	])
	@endcomponent

	@component('components.card')

		{!! Form::model($customer, [
			'route' => ['fleet.customers.update', $customer],
			'method' => 'PUT',
			'class' => 'w-full'
		]) !!}	

		@include('fleet.customers.form')

		<div class="flex justify-end">
			<button class="btn-indigo">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection