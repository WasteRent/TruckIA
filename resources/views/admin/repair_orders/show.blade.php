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
				'Estado' => $repair_order->state->name,
				'Observaciones' => $repair_order->remarks,
			])
		@endcomponent
	@endcomponent
	
	@include('shared.vehicles.show', ['vehicle' => $repair_order->vehicle])

	@include('shared.garages.show', ['garage' => $repair_order->garage])

	@include('shared.repair_orders.operations', ['repair_order' => $repair_order])

@endsection
