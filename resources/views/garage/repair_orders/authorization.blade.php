@extends('layouts.garage')

@section('progress')
	<div class="mb-8">
		@include('shared.steps', [
			'steps' => [
				[
					'name' => 'Vehículo',
					'url' => route('garage.repair-orders.vehicle', $repair_order),
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
					'url' => route('garage.repair-orders.authorization', $repair_order),					'active' => true,
					'icon' => 'fas fa-rocket'
				],
				[
					'name' => 'Resumen',
					'url' => route('garage.repair-orders.show', $repair_order),
					'active' => false,
					'icon' => 'fas fa-clipboard'
				]
			]
		])
	</div>
@endsection

@section('title', 'Autorización OR#' . $repair_order->id)


@section('content')

	@component('components.card')
		@if(!$repair_order->isAuthorized())
			<div>
				<strong>{{ Auth::user()->garage->name }}</strong>. solicita autorización para la reparación del vehículo con matrícula <strong>{{ $repair_order->vehicle->plate }}</strong>.
			</div>
			<br><br>
			<form method="POST" action="{{ route('garage.repair-orders.authorize', $repair_order) }}">
				@csrf
				<div class="text-center">
					<button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
					  Solicitar autorización
					</button>
				</div>
			</form>
		@else
			<div>
				<small class="text-gray-700">{{ $repair_order->authorized_at->format('d/m/Y H:i:s') }}</small>
				<p>
					Operación autorizada para la reparación del vehículo con matrícula <strong>{{ $repair_order->vehicle->plate }}</strong> por el taller <strong>{{ $repair_order->garage->name }}</strong>.
				</p>

				@if(!empty($repair_order->remarks))
					<div class="mt-6">
						<label class="form-label">Observaciones</label>
						<p class="italic text-sm">{{ $repair_order->remarks }}</p>
					</div>
				@endif
			</div>
		@endif
	@endcomponent

	
@endsection
