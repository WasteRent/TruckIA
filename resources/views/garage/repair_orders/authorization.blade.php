@extends('layouts.garage')

@include('garage.repair_orders.tabs', ['active_auth' => true])

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
					<button class="btn-indigo">
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
