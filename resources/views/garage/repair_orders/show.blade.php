@extends('layouts.garage')

@include('garage.repair_orders.tabs', ['active_summary' => true])

@section('content')
	
	@component('components.card')
		@slot('title', 'Orden de Reparación')

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
				__('Fecha') => $repair_order->created_at->format('d/m/Y H:i:s'),
				'Matrícula' => $repair_order->vehicle->internal_id
									? "({$repair_order->vehicle->internal_id}) {$repair_order->vehicle->plate}"
									: $repair_order->vehicle->plate,
				__('Vehículo') => $repair_order->vehicle->chassis .' '. $repair_order->vehicle->equipment,
				__('Asignada a') => $repair_order->assigned ? $repair_order->assigned->name : '',
				__('Estado') => __(optional($repair_order->state)->name),
				__('Observaciones') => $repair_order->remarks,
				'Descripción' => $repair_order->internal_notes,
			])
		@endcomponent
	@endcomponent
	
	@include('garage.repair_orders.execute.index')



@endsection
