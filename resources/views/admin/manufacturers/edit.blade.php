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
			<button class="btn-indigo">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection