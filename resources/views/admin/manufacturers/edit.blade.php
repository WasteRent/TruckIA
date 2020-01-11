@extends('layouts.admin')

@section('content')
	
	@component('components.card')
		@slot('title', 'Editar Marca')

		{!! Form::model($manufacturer, [
			'route' => ['admin.manufacturers.update', $manufacturer],
			'method' => 'PUT',
			'class' => 'w-full'
		]) !!}	

		@include('admin.manufacturers.form')

		<div class="flex justify-end">
			<button class="px-4 py-1 rounded text-white bg-indigo-600 shadow flex items-center">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection