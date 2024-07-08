@extends('layouts.fleet')

@section('title', 'Tipos de vehículo')

@section('content')

	@component('components.card')
		@slot('title', 'Nuevo Tipo')

		{!! Form::open([
			'route' => ['fleet.vehicle-types.store'],
			'method' => 'POST',
			'class' => 'w-full'
		]) !!}

			<div class="flex flex-wrap -mx-3 mb-6">
			  <div class="w-full md:w-5/12 px-3 mb-6 md:mb-0">
			    <label class="form-label form-required">
			      Nombre
			    </label>
			    {!! Form::text('name', null, ['class' => 'form-input']) !!}
			  </div>
			</div>

		<div class="flex justify-end">
			<button class="btn-indigo">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection