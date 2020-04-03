@extends('layouts.admin')

@section('content')
	
	@component('components.card')
		@slot('title', 'Nueva Empresa')

		{!! Form::open([
			'route' => ['admin.enterprise-groups.store'],
			'method' => 'POST',
			'class' => 'w-full'
		]) !!}	

		@include('admin.enterprise_groups.form')

		<div class="flex justify-end">
			<button class="btn-indigo">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection