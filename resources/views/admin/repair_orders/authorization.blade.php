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
					'url' => route('admin.repair-orders.authorization', $repair_order),
					'active' => true,
					'icon' => 'fas fa-rocket'
				],
				[
					'name' => 'Resumen',
					'url' => route('admin.repair-orders.show', $repair_order),
					'active' => false,
					'icon' => 'fas fa-clipboard'
				]
			]
		])
	</div>
@endsection

@section('title')
	<div class="flex items-center">
		<span class="mr-2">OR# {{ $repair_order->id }} Autorización</span>
		<span class="{{ $repair_order->state->color }} rounded-full px-3 py-1 text-xs font-medium">
			{{ $repair_order->state->name }}
		</span>
	</div>
@endsection

@section('content')

	@component('components.card')
		@if(!$repair_order->isAuthorized())
			<div>
				<span class="italic">{{ Auth::user()->name }}</span> autoriza la reparación del vehículo con matrícula <strong>{{ $repair_order->vehicle->plate }}</strong> por el taller <strong>{{ $repair_order->garage->name }}</strong>.
			</div>
			<br><br>
			<form method="POST" action="{{ route('admin.repair-orders.authorize', $repair_order) }}">
				@csrf
				<div class="flex flex-wrap -mx-3 mb-6">
				  <div class="w-full md:w-full px-3 mb-6 md:mb-0">
				    <label class="form-label" >
				      Observaciones
				    </label>
				    {!! Form::textarea('remarks', null, ['class' => 'appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500']) !!}
				  </div>
				</div>
				<br><br>
				<div class="text-center">
					<button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
					  Autorizar y enviar al taller
					</button>
				</div>
			</form>
		@else
			<div>
				<small class="text-gray-700">{{ $repair_order->authorized_at->format('d/m/Y H:i:s') }}</small>
				<p>
					Operación autorizada por <span class="italic">{{ $repair_order->authorizer->name }}</span>
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
