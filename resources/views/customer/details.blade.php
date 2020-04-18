@extends('layouts.customer')

@section('content')
	
	@component('components.card')
		@slot('title', 'Datos')

		{!! Form::model($customer, [
			'route' => ['customer.details.update'],
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