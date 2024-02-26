@extends('layouts.fleet')

@section('title', __('Carga de gastos'))

@section('content')

	@component('components.card')
		@slot('title', __('Nuevo gasto'))

		{!! Form::open([
			'route' => ['fleet.additional-vehicle-expenses.store'],
			'method' => 'POST',
			'class' => 'w-full',
			'files' => true,
		]) !!}

		<label class="form-label">
		  Archivo
		</label>
		{!! Form::file('file', ['class' => 'form-input']) !!}
		<br>

		<div class="flex justify-end">
			<button class="btn-indigo">{{ __('Guardar') }}</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection