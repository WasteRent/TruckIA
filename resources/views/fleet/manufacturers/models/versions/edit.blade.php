@extends('layouts.fleet')

@section('content')
	
	@component('components.card')
	@slot('title', 'Editar Den. com. - ' . $manufacturer->name . ' ' . $model->name)

		{!! Form::model($version, [
			'route' => ['fleet.models.versions.update', $model, $version],
			'method' => 'PUT',
			'class' => 'w-full'
		]) !!}	

		@include('fleet.manufacturers.models.versions.form')

		<div class="flex justify-end">
			<button class="btn-indigo">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection