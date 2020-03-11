@extends('layouts.garage')

@section('progress')
	<div class="mb-8">
		@include('shared.steps', [
			'steps' => [
				[
					'name' => 'Vehículo',
					'url' => route('garage.repair-orders.vehicles.create', $repair_order),
					'active' => false,
					'icon' => 'fas fa-bus-alt'
				],
				[
					'name' => 'Operaciones',
					'url' => route('garage.repair-orders.operations.index', $repair_order),
					'active' => false,
					'icon' => 'fas fa-cogs'
				],
				[
					'name' => 'Autorización',
					'url' => route('garage.repair-orders.authorization', $repair_order),
					'active' => true,
					'icon' => 'fas fa-rocket'
				]
			]
		])
	</div>
@endsection

@section('title', 'Autorización OR#' . $repair_order->id)


@section('content')

	@component('components.card')

		@if($repair_order->isAuthorized())
			Operación autorizada
		@else 
			@if($repair_order->getEstimatedAmount() > 500)
				Esta orden de reparación supera los 500€, por tanto debe ser autorizada.
			@else
				Esta orden de reparación no necesita autorización
			@endif
		@endif

	@endcomponent

	
@endsection
