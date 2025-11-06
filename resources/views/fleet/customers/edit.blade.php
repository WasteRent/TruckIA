@extends('layouts.fleet')

@section('title', $customer->name)

@section('content')

	@include('fleet.customers.tabs', ['active_edit' => true])

	@component('components.card')

		{!! Form::model($customer, [
			'route' => ['fleet.customers.update', $customer],
			'method' => 'PUT',
			'class' => 'w-full'
		]) !!}	

		@include('fleet.customers.form')

		@if(!in_array(Auth::user()->job, ['contract_manager']))
			<div class="flex justify-end">
				<button class="btn-indigo">{{ __('Guardar') }}</button>
			</div>
		@endif
		{!! Form::close() !!}
	@endcomponent

@endsection