@extends('layouts.admin')

@section('content')
	
	@component('components.card')
		@slot('title', 'Nuevo Recambio')

		{!! Form::open([
			'route' => ['admin.spare-parts.store'],
			'method' => 'POST',
			'class' => 'w-full'
		]) !!}	

		@include('admin.spare_parts.form')

		<div class="flex justify-end">
			<button class="btn-indigo">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection