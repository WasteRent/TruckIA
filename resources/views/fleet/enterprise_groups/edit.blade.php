@extends('layouts.fleet')

@section('content')
	
	@component('components.card')
		@slot('title', 'Editar Empresa')

		{!! Form::model($enterprise, [
			'route' => ['fleet.enterprise-groups.update', $enterprise],
			'method' => 'PUT',
			'class' => 'w-full'
		]) !!}	

		@include('fleet.enterprise_groups.form')

		<div class="flex justify-end">
			<button class="btn-indigo">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection