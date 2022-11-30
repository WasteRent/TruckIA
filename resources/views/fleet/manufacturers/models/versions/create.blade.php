@extends('layouts.fleet')

@section('content')
	
	@component('components.card')
		@slot('title', 'Nueva Den. com - ' . $manufacturer->name . ' ' . $model->name)

		{!! Form::open([
			'route' => ['fleet.models.versions.store', $model],
			'method' => 'POST',
			'class' => 'w-full'
		]) !!}	

		@include('fleet.manufacturers.models.versions.form')

		<div class="flex justify-end">
			<button class="btn-indigo">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection