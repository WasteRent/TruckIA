@extends('layouts.garage')

@section('content')

	@component('components.card')
		@slot('title', 'Orden de Reparación')
		@component('components.table')
			@slot('items', [
				'ID' => $repair_order->id,
				'Fecha' => $repair_order->created_at->format('d/m/Y H:i:s'),
				'Observaciones' => $repair_order->remarks,
			])
		@endcomponent
	@endcomponent
	
	@include('shared.vehicles.show', ['vehicle' => $repair_order->vehicle])

	@include('shared.repair_orders.operations', ['repair_order' => $repair_order])

@endsection
