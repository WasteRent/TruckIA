@extends('layouts.admin')

@section('content')
	
	@component('components.card')
		@slot('title', 'Editar Empresa')

		{!! Form::model($enterprise, [
			'route' => ['admin.enterprise-groups.update', $enterprise],
			'method' => 'PUT',
			'class' => 'w-full'
		]) !!}	

		@include('admin.enterprise_groups.form')

		<div class="flex justify-end">
			<button class="px-4 py-1 rounded text-white bg-indigo-600 shadow flex items-center">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection