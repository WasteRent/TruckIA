@extends('layouts.admin')

@section('progress')
	<div class="mb-8">
		@include('shared.steps', [
			'steps' => [
				[
					'name' => 'Vehículo',
					'url' => route('admin.repair-orders.vehicle', $repair_order),
					'active' => false,
					'icon' => 'fas fa-bus-alt'
				],
				[
					'name' => 'Taller',
					'url' => route('admin.repair-orders.garage', $repair_order),
					'active' => false,
					'icon' => 'fas fa-warehouse'
				],
				[
					'name' => 'Operaciones',
					'url' => route('admin.repair-orders.operations.index', $repair_order),
					'active' => false,
					'icon' => 'fas fa-cogs'
				],
				[
					'name' => 'Autorización',
					'url' => route('admin.repair-orders.authorization', $repair_order),					'active' => false,
					'icon' => 'fas fa-rocket'
				],
				[
					'name' => 'Resumen',
					'url' => route('admin.repair-orders.show', $repair_order),
					'active' => true,
					'icon' => 'fas fa-clipboard'
				]
			]
		])
	</div>
@endsection

@section('title')
	<div class="flex items-center">
		<span class="mr-2">OR# {{ $repair_order->id }} Resumen</span>
		<span class="{{ $repair_order->state->color }} rounded-full px-3 py-1 text-xs font-medium">
			{{ $repair_order->state->name }}
		</span>
	</div>
@endsection

@section('content')

	@component('components.card')
		@slot('title', 'Orden de Reparación')
		@slot('corner')
			<form onsubmit="return confirmDelete()" method="POST" action="{{ route('admin.repair-orders.cancel', $repair_order) }}">
				@csrf
				@method('PUT')
				<button class="px-4 py-1 rounded bg-red-700 text-white shadow flex items-center">Cancelar</button>
			</form>
		@endslot

		<div class="flex">
			<div class="w-1/2">
				@component('components.table')
					@slot('items', [
						'ID' => $repair_order->id,
						'Fecha' => $repair_order->created_at->format('d/m/Y H:i:s'),
						'Creada por' => $repair_order->creator->name,
						'Autorizada por' => $repair_order->authorizer ? $repair_order->authorizer->name : '', 
						'Estado' => $repair_order->state->name,
						'Visto por pri. vez' => optional($repair_order->seen_at)->diffForHumans(),
						'Visto por ult. vez' => optional($repair_order->last_seen_at)->diffForHumans(),
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
