@extends('layouts.garage')

@section('content')

	@component('components.card')
		@slot('title', 'Operación')
		@component('components.table')
			@slot('items', [
				'ID' => $operation->id,
				'Fecha' => $operation->created_at->format('d/m/Y H:i:s'),
				'Completada' => $operation->completed ? 'Si':'No',
				'Observaciones' => $operation->remarks
			])
		@endcomponent
	@endcomponent
	
	@include('shared.vehicles.show', ['vehicle' => $operation->vehicle])


	@component('components.card')
		@slot('title', 'Plan de mantenimiento')
		@foreach($operation->maintenance_plan->operations as $op)
			<div class="flex py-1">
				<div class="w-1/2 flex items-center text-gray-700">
					<ion-icon class="mr-2" name="arrow-dropright"></ion-icon>
					{{$op->name}}
				</div>
				<div class="w-1/2 flex items-center text-gray-800">
					<ion-icon class="mr-2" name="ios-build"></ion-icon>
					{{$op->acceptance}}
				</div>
			</div>
			<div class="flex items-center pt-1 pb-3 mb-3 border-b">
				<ion-icon class="mr-2 text-xl text-green-600" name="checkmark"></ion-icon>
				<span class="text-xs text-gray-600 mr-2">2019-11-19 17:55:35</span>
				<ion-icon class="mr-2 text-xl text-gray-700" name="ios-document"></ion-icon>
				<span class="text-xs text-gray-800">Documentación</span>
			</div>
		@endforeach
	@endcomponent

	@component('components.card')
		@slot('title', 'Finalizar operación')

		@if(!$operation->completed)
			{!! Form::open([
				'route' => ['garage.operations.finish', $operation],
				'method' => 'POST',
				'class' => 'w-full'
			]) !!}	
				@include('garage.operations.finish')

				<div class="flex justify-end">
					<button class="px-4 py-1 rounded text-white bg-indigo-600 shadow flex items-center">Cerrar operación</button>
				</div>
			{!! Form::close() !!}
		@else
			<p>Cerrada {{ $operation->finished_at->format('d/m/Y H:i:s') }}</p> <br>
			<div class="flex items-center">
				<ion-icon class="mr-2" name="ios-cloud-download"></ion-icon>
				<span>Factura</span>
			</div>
		@endif

	@endcomponent

@endsection
