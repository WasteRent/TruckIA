@extends('layouts.admin')

@section('title', 'Cliente ' . $customer->name)

@section('content')

	@component('components.card')

		{!! Form::model($customer, [
			'route' => ['admin.customers.update', $customer],
			'method' => 'PUT',
			'class' => 'w-full'
		]) !!}	

		@include('admin.customers.form')

		<div class="flex justify-end">
			<button class="px-4 py-1 rounded text-white bg-indigo-600 shadow flex items-center">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection