@section('progress')
	<div class='mb-8 max-w-4xl mx-auto'>
		@include('shared.steps', [
			'steps' => [
				[
					'name' => __('Vehículo'),
					'url' => route('fleet.repair-orders.vehicle', $repair_order),
					'active' => isset($active_vehicle) && $active_vehicle,
					'icon' => 'fas fa-bus-alt'
				],
				[
					'name' => __('Taller'),
					'url' => route('fleet.repair-orders.garage', $repair_order),
					'active' => isset($active_garage) && $active_garage,
					'icon' => 'fas fa-warehouse'
				],
				[
					'name' => __('Operaciones'),
					'url' => route('fleet.repair-orders.operations.index', $repair_order),
					'active' => isset($active_operations) && $active_operations,
					'icon' => 'fas fa-cogs',
					'warning' => !$repair_order->operations->count()
				],
				[
					'name' => __('Autorización'),
					'url' => route('fleet.repair-orders.authorization', $repair_order),
					'active' => isset($active_auth) && $active_auth,
					'icon' => 'fas fa-rocket',
					'warning' => !$repair_order->isAuthorized()
				],
				[
					'name' => __('Resumen'),
					'url' => route('fleet.repair-orders.show', $repair_order),
					'active' => isset($active_summary) && $active_summary,
					'icon' => 'fas fa-clipboard'
				]
			]
		])
	</div>
@endsection

@section('title')
	<div class='flex items-center'>
		<span class='mr-2'>
			#{{ $repair_order->id }}

		</span>
		<span class='text-sm px-8 text-gray-600'>
			{{ $repair_order->vehicle->plate }} &middot;
			{{ $repair_order->vehicle->chassis }}
			{{ $repair_order->vehicle->equipment }}
			<br>
			<ul class="text-xs text-gray-500">
				@foreach($repair_order->operations->pluck('maintenance_plan_name')->unique()->take(2) as $plan_name)
					<li>{{ $plan_name }}</li>
				@endforeach
			</ul>
			@if($repair_order->operations->pluck('maintenance_plan_name')->unique()->count() > 2)
			<details>
				<summary class="cursor-pointer text-xs">Ver más</summary>
				<ul class="text-xs text-gray-500">
				@foreach($repair_order->operations->pluck('maintenance_plan_name')->unique()->skip(2) as $plan_name)
					<li>{{ $plan_name }}</li>
				@endforeach
				</ul>
			</details>
			@endif
		</span>
		<span class='{{ $repair_order->state->color }} badge'>
			{{ __($repair_order->state->name) }}
		</span>
	</div>
@endsection