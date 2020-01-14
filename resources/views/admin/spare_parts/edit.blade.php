@extends('layouts.admin')

@section('content')
	
	@component('components.card')
		@slot('title', 'Editar Recambio')

		{!! Form::model($spare_part, [
			'route' => ['admin.spare-parts.update', $spare_part],
			'method' => 'PUT',
			'class' => 'w-full'
		]) !!}	

		@include('admin.spare_parts.form')

		<div class="flex justify-end">
			<button class="px-4 py-1 rounded text-white bg-indigo-600 shadow flex items-center">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection