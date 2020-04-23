@extends('layouts.fleet')

@include('fleet.repair_orders.tabs', ['active_summary' => true])

@section('content')

	@component('components.card')
		@slot('title', 'Orden de Reparación')
		@if(!$repair_order->isFinished())
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

	@component('components.card')
		@slot('title', 'ITV')
		<ul>
			<li class="flex items-center py-3">
				@if($repair_order->history->pluck('state_id')->contains(App\Models\RepairOrderState::ITV_PAPER_SENT_TO_GARAGE))
					<i class="fas fa-check-circle fa-lg text-green-600"></i>
				@else
					<form method="POST" action="{{ route('fleet.repair-orders.state.update', $repair_order) }}">
						@csrf
						@method('PUT')
						<input type="hidden" name="state_id" value="{{App\Models\RepairOrderState::ITV_PAPER_SENT_TO_GARAGE}}">
						<button><i class="fas fa-check-circle fa-lg text-gray-400"></i></button>
					</form>
				@endif
				<div class="ml-4">
					<p>Documentación enviada al taller</p>
				</div>
			</li>

			<li class="flex items-center py-3">
				@if($repair_order->history->pluck('state_id')->contains(App\Models\RepairOrderState::ITV_PAPER_RECEIVED_FROM_GARAGE))
					<i class="fas fa-check-circle fa-lg text-green-600"></i>
				@else
					<form method="POST" action="{{ route('fleet.repair-orders.state.update', $repair_order) }}">
						@csrf
						@method('PUT')
						<input type="hidden" name="state_id" value="{{App\Models\RepairOrderState::ITV_PAPER_RECEIVED_FROM_GARAGE}}">
						<button><i class="fas fa-check-circle fa-lg text-gray-400"></i></button>
					</form>
				@endif
				<div class="ml-4">
					<p>Documentación recibida del taller</p>
				</div>
			</li>
		</ul>
	@endcomponent
	
	@component('components.card', ['is_table' => true])
		@slot('title', 'Operaciones Realizadas')
		@include('shared.repair_orders.operations', ['repair_order' => $repair_order])
	@endcomponent
@endsection
