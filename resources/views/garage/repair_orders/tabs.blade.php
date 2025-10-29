@section('progress')
	<div class='mb-8'>
		@include('shared.steps', [
			'steps' => [
				[
					'name' => 'Vehículo',
					'url' => route('garage.repair-orders.vehicle', $repair_order),
					'active' => isset($active_vehicle) && $active_vehicle,
					'icon' => 'fas fa-bus-alt'
				],
				[
					'name' => 'Operaciones',
					'url' => route('garage.repair-orders.operations.index', $repair_order),
					'active' => isset($active_operations) && $active_operations,
					'icon' => 'fas fa-cogs',
					'warning' => !$repair_order->operations->count()
				],
				[
					'name' => 'Autorización',
					'url' => route('garage.repair-orders.authorization', $repair_order),
					'active' => isset($active_auth) && $active_auth,
					'icon' => 'fas fa-rocket'
				],
				[
					'name' => 'Resumen',
					'url' => route('garage.repair-orders.show', $repair_order),
					'active' => true,
					'icon' => 'fas fa-clipboard'
				]
			]
		])
	</div>
@endsection


@section('title')
	<div class='flex items-center'>
		<span class='mr-2'>
			OR# {{ $repair_order->id }}
			@if(isset($active_summary))
				Resumen
			@elseif(isset($active_auth))	
				Autorización
			@elseif(isset($active_operations))	
				Operaciones
			@elseif(isset($active_vehicle))	
				Vehículo
			@endif
		</span>
		<span class='{{ $repair_order->state?->color }} badge'>
			{{ $repair_order->state->name }}
		</span>
	</div>
@endsection