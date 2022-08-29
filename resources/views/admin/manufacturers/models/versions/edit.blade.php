@extends('layouts.admin')

@section('content')
	
	@component('components.card')
	@slot('title', 'Editar Den. com. - ' . $manufacturer->name . ' ' . $model->name)

		{!! Form::model($version, [
			'route' => ['admin.models.versions.update', $model, $version],
			'method' => 'PUT',
			'class' => 'w-full'
		]) !!}	

		@include('admin.manufacturers.models.versions.form')

		<div class="flex justify-end">
			<button class="btn-indigo">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection