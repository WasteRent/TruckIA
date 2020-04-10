@extends('layouts.fleet')

@include('fleet.repair_orders.tabs', ['active_summary' => true])

@section('content')

	@component('components.card')
		@slot('title', 'Orden de Reparación')
		@if($repair_order->state_id != App\Models\RepairOrderState::CANCELED)
			@slot('corner')
				<form onsubmit="return confirmDelete()" method="POST" action="{{ route('fleet.repair-orders.cancel', $repair_order) }}">
					@csrf
					@method('PUT')
					<button class="btn-outline-red">
						Cancelar
					</button>
				</form>
			@endslot
		@endif

		<div class="flex">
			<div class="w-1/2">
				@component('components.table')
					@slot('items', [
						'Fecha' => $repair_order->created_at->format('d/m/Y H:i:s'),
						'Creada por' => $repair_order->creator->name,
						'Autorizada por' => $repair_order->authorizer ? $repair_order->authorizer->name : '', 
						'Estado' => $repair_order->state->name,
						'Taller vió por pri. vez' => optional($repair_order->seen_at)->diffForHumans(),
						'Taller vió por ult. vez' => optional($repair_order->last_seen_at)->diffForHumans(),
						'Observaciones' => $repair_order->remarks,
					])
				@endcomponent
			</div>
			<div class="w-1/2">
				<fieldset>
					<legend>Estados</legend>
					@foreach($repair_order->history as $history)
						<div class="flex my-1 px-2 py-1 rounded text-xs @if($loop->first) {{$history->state->color}} @endif">
							<div class="w-1/2">
								<span class="">{{$history->state->name}}</span>
							</div>
							<div class="w-1/2">{{$history->created_at->format('d/m/y H:i:s')}}</div>
						</div>
					@endforeach
				</fieldset>
			</div>
		</div>
	@endcomponent

	@include('shared.repair_orders.appointment', ['repair_order' => $repair_order])
	
	@include('shared.repair_orders.operations', ['repair_order' => $repair_order])

@endsection
