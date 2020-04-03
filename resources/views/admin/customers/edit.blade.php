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
			<button class="btn-indigo">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection