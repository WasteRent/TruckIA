@extends('layouts.fleet')

@section('content')
	
	@component('components.card')
		@slot('title', 'Nueva Empresa')

		{!! Form::open([
			'route' => ['fleet.enterprise-groups.store'],
			'method' => 'POST',
			'class' => 'w-full'
		]) !!}	

		@include('fleet.enterprise_groups.form')

		<div class="flex justify-end">
			<button class="btn-indigo">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection