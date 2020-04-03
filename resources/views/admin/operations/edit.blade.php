@extends('layouts.admin')

@section('content')
	
	@component('components.card')
		@slot('title', 'Editar Operación')

		{!! Form::model($operation, [
			'route' => ['admin.operations.update', $operation],
			'method' => 'PUT',
			'class' => 'w-full'
		]) !!}	

		@include('admin.operations.form')

		<div class="flex justify-end">
			<button class="btn-indigo">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection