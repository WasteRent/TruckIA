@extends('layouts.admin')

@section('content')

	@component('components.card')
		@slot('title', 'Operación')
		@component('components.table')
			@slot('items', [
				'ID' => $operation->id,
				'Fecha' => $operation->created_at,
				'Completada' => $operation->finished ? 'Si':'No',
				'Observaciones' => $operation->remarks
			])
		@endcomponent
	@endcomponent
	
	@include('shared.vehicles.show', ['vehicle' => $operation->vehicle])

	@include('shared.garages.show', ['garage' => $operation->garage])

	@component('components.card')
		@slot('title', 'Plan de mantenimiento')
		@foreach($operation->maintenance_plan->operations as $operation)
			<div class="flex py-1">
				<div class="w-1/2 flex items-center text-gray-700">
					<ion-icon class="mr-2" name="arrow-dropright"></ion-icon>
					{{$operation->name}}
				</div>
				<div class="w-1/2 flex items-center text-gray-800">
					<ion-icon class="mr-2" name="ios-build"></ion-icon>
					{{$operation->acceptance}}
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

@endsection
