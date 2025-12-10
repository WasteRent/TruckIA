@extends('layouts.fleet')

@section('title', __('Contenedores'))

@section('content')

	@component('components.card')
		@slot('title', __('Nuevo Contenedor'))

		@if(request('reference'))
			<div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg flex items-center">
				<svg class="w-5 h-5 text-green-600 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"></path>
				</svg>
				<span class="text-sm text-green-700">{{ __('Creando contenedor desde lectura RFID') }}: <strong class="font-mono">{{ request('reference') }}</strong></span>
			</div>
		@endif

		{!! Form::model(['reference' => request('reference')], [
			'route' => ['fleet.containers.store'],
			'method' => 'POST',
			'class' => 'w-full'
		]) !!}

		@include('fleet.containers.form')

		<div class="flex justify-end">
			<button class="btn-indigo">{{ __('Guardar') }}</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection