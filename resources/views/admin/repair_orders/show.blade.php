@extends('layouts.admin')

@section('content')

	@component('components.card')
		@slot('title', 'Orden de Reparación')
		@component('components.table')
			@slot('items', [
				'ID' => $repair_order->id,
				'Fecha' => $repair_order->created_at->format('d/m/Y H:i:s'),
				'Creada por' => $repair_order->creator->name,
				'Autorizada por' => $repair_order->authorizer ? $repair_order->authorizer->name : '', 
				'Completada' => $repair_order->finished_at ? 'Si':'No',
				'Observaciones' => $repair_order->remarks,
			])
		@endcomponent
	@endcomponent
	
	@include('shared.vehicles.show', ['vehicle' => $repair_order->vehicle])

	@include('shared.garages.show', ['garage' => $repair_order->garage])

	@component('components.card')
		@slot('title', 'Operaciones')
		@foreach($repair_order->operations as $operation)
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
