@extends('layouts.fleet')

@section('title', $customer->name)

@section('content')

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