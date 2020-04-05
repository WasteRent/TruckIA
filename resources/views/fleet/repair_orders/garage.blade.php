@extends('layouts.fleet')

@section('progress')
	<div class="mb-8">
		@include('shared.steps', [
			'steps' => [
				[
					'name' => 'Vehículo',
					'url' => route('fleet.repair-orders.vehicle', $repair_order),
					'active' => false,
					'icon' => 'fas fa-bus-alt'
				],
				[
					'name' => 'Taller',
					'url' => route('fleet.repair-orders.garage', $repair_order),
					'active' => true,
					'icon' => 'fas fa-warehouse'
				],
				[
					'name' => 'Operaciones',
					'url' => route('fleet.repair-orders.operations.index', $repair_order),
					'active' => false,
					'icon' => 'fas fa-cogs'
				],
				[
					'name' => 'Autorización',
					'url' => route('fleet.repair-orders.authorization', $repair_order),					'active' => false,
					'icon' => 'fas fa-rocket'
				],
				[
					'name' => 'Resumen',
					'url' => route('fleet.repair-orders.show', $repair_order),
					'active' => false,
					'icon' => 'fas fa-clipboard'
				]
			]
		])
	</div>
@endsection

@section('title')
	<div class="flex items-center">
		<span class="mr-2">OR# {{ $repair_order->id }} Taller</span>
		<span class="{{ $repair_order->state->color }} rounded-full px-3 py-1 text-xs font-medium">
			{{ $repair_order->state->name }}
		</span>
	</div>
@endsection

@section('content')
	
	@include('shared.garages.show', ['garage' => $repair_order->garage])

@endsection
