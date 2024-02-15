@extends('layouts.fleet')

@include('fleet.repair_orders.tabs', ['active_auth' => true])

@section('content')

	@component('components.card')
		@if(!$repair_order->isAuthorized())
			<div>
				<span class="italic">{{ Auth::user()->name }}</span> autoriza la reparación del vehículo con matrícula <strong>{{ $repair_order->vehicle->plate }}</strong> por el taller <strong>{{ $repair_order->garage->name }}</strong>.
			</div>
			<br><br>
			<form method="POST" action="{{ route('fleet.repair-orders.authorize', $repair_order) }}">
				@csrf
				<div class="flex flex-wrap -mx-3 mb-6">
				  <div class="w-full md:w-full px-3 mb-6 md:mb-0">
				    <label class="form-label">
				      Observaciones
				    </label>
				    {!! Form::textarea('remarks', null, ['class' => 'form-input', 'rows' => 2]) !!}
				  </div>
				</div>
				<div class="text-center">
					<button class="btn-indigo">
					  Autorizar y enviar al taller
					</button>
				</div>
			</form>
		@else
			<div>
				<small class="text-gray-700">{{ $repair_order->authorized_at->format('d/m/Y H:i:s') }}</small>
				<p>
					Operación autorizada por <span class="italic">{{ $repair_order->authorizer?->name }}</span>
					para la reparación del vehículo con matrícula <strong>{{ $repair_order->vehicle->plate }}</strong> por el taller <strong>{{ $repair_order->garage->name }}</strong>.
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
