@extends('layouts.fleet')

@include('fleet.repair_orders.tabs', ['active_summary' => true])

@section('content')

	@component('components.card')
		@slot('title', 'Orden de Reparación')
		@if(!$repair_order->isFinished())
			@slot('corner')
				<div class="flex">
					<form onsubmit="return confirmDelete()" class="mr-4" method="POST" action="{{ route('fleet.repair-orders.finish', $repair_order) }}">
						@csrf
						@method('PUT')
						<button class="btn-outline-gray">
							Finalizar
						</button>
					</form>
					<form onsubmit="return confirmDelete()" method="POST" action="{{ route('fleet.repair-orders.cancel', $repair_order) }}">
						@csrf
						@method('PUT')
						<button class="btn-outline-red">
							Cancelar
						</button>
					</form>
				</div>
			@endslot
		@endif

		<div class="sm:flex">
			<div class="sm:w-1/2">
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
			<div class="sm:w-1/2 mt-4 sm:mt-0">
				<fieldset>
					<legend>Estados</legend>
					@foreach($repair_order->history as $history)
						<div class="flex my-1 px-2 py-1 rounded text-xs @if($loop->first) {{$history->state->color}} @endif">
							<div class="w-1/2">
								<span class="">{{$history->state->name}}</span>
							</div>
							<div class="w-1/2">
								{{ $history->user->name }} &middot;
								{{$history->created_at->format('d/m/y H:i:s')}}
							</div>
						</div>
					@endforeach
				</fieldset>
			</div>
		</div>
	@endcomponent

	@if($repair_order->type == 'pre-itv')
		@include('fleet.repair_orders.itv')
	@endif
	
	@component('components.card', ['is_table' => true])
		@slot('title', 'Operaciones Realizadas')
		@include('shared.repair_orders.operations', ['repair_order' => $repair_order])
	@endcomponent
@endsection
