@extends('layouts.garage')

@include('garage.repair_orders.tabs', ['active_summary' => true])

@section('content')
	
	@component('components.card')
		@slot('title', 'Orden de Reparación')
	<!--
		@if($repair_order->isAuthorized() && !$repair_order->isFinished())
			@if($repair_order->appointment && $repair_order->appointment->vehicle_received)
				@slot('corner')
					<a href="{{ route('garage.show.operation', $repair_order) }}" class="btn-indigo">
					  Continuar Reparación
					</a>
				@endslot
			@endif
			@if(!$repair_order->appointment)
				@slot('corner')
					<a href="{{ route('garage.show.operation', $repair_order) }}" class="btn-indigo">
					  Continuar Reparación
					</a>
				@endslot
			@endif
		@endif
	-->

		@if($repair_order->isFinished())
			@slot('corner')
				<a class="btn-outline-gray" href="{{ route('garage.repair-orders.invoice.show',$repair_order ) }}" target="_blank">
					<i class="fas fa-file-invoice-dollar mr-2"></i> Factura
				</a>
			@endslot
		@endif
	
		@component('components.table')
			@slot('items', [
				'ID' => $repair_order->id,
				'Fecha' => $repair_order->created_at->format('d/m/Y H:i:s'),
				'Observaciones' => $repair_order->remarks,
			])
		@endcomponent
	@endcomponent
	
	@include('shared.repair_orders.appointment', ['repair_order' => $repair_order])


	@if($repair_order->type == 'pre-itv')
		@include('garage.repair_orders.itv')
	@endif


	@include('garage.repair_orders.plan_cards')



@endsection
