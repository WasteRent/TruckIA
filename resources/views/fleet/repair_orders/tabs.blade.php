
@section('progress')
	<div class="mb-8">
		@include('shared.steps', [
			'steps' => [
				[
					'name' => 'Vehículo',
					'url' => route('fleet.repair-orders.vehicle', $repair_order),
					'active' => isset($active_vehicle) && $active_vehicle,
					'icon' => 'fas fa-bus-alt'
				],
				[
					'name' => 'Taller',
					'url' => route('fleet.repair-orders.garage', $repair_order),
					'active' => isset($active_garage) && $active_garage,
					'icon' => 'fas fa-warehouse'
				],
				[
					'name' => 'Operaciones',
					'url' => route('fleet.repair-orders.operations.index', $repair_order),
					'active' => isset($active_operations) && $active_operations,
					'icon' => 'fas fa-cogs'
				],
				[
					'name' => 'Autorización',
					'url' => route('fleet.repair-orders.authorization', $repair_order),
					'active' => isset($active_auth) && $active_auth,
					'icon' => 'fas fa-rocket'
				],
				[
					'name' => 'Resumen',
					'url' => route('fleet.repair-orders.show', $repair_order),
					'active' => isset($active_summary) && $active_summary,
					'icon' => 'fas fa-clipboard'
				]
			]
		])
	</div>
@endsection

@section('title')
	<div class="flex items-center">
		<span class="mr-2">
			OR# {{ $repair_order->id }}
			@if(isset($active_summary))
				Resumen
			@elseif(isset($active_auth))	
				Autorización
			@elseif(isset($active_operations))	
				Operaciones
			@elseif(isset($active_garage))	
				Taller
			@elseif(isset($active_vehicle))	
				Vehículo
			@endif
		</span>
		<span class="{{ $repair_order->state->color }} badge">
			{{ $repair_order->state->name }}
		</span>
	</div>
@endsection