@extends('layouts.fleet')

@include('fleet.repair_orders.tabs', ['active_operations' => true])	

@section('content')
	@component('components.tabs', [
		'items' => [
			[
				'name' => 'Operaciones',
				'url' => route('fleet.repair-orders.operations.index', $repair_order),
				'active' => false
			],
			[
				'name' => 'Planes de mantenimiento',
				'url' => route('fleet.repair-orders.maintenance-plans.index', $repair_order),
				'active' => true
			]
		]
	])
	@endcomponent
	

	@component('components.card', ['is_table' => true])
		<div class="border-b py-4 px-6 font-bold">
			Mantenimientos
		</div>
		<table >
		  <thead >
		    <tr >
		      <th>Nombre</th>
		      <th>Marca/Modelo</th>
		      <th>Frecuencia</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($plans as $plan)
		  	<tr >
		  	  <td>{{ $plan->name }}</td>
		  	  <td>{{ optional($plan->manufacturer)->name }} {{ optional($plan->model)->name }}</td>
		  	  <td>
		  	  	<div class="">
		  	  		@if($plan->kms)
		  	  			<div class="flex">
			  	  			<div class="w-3/4">{{ $plan->kms }} kms</div>
			  	  			<div class="w-1/4">
			  	  				@include('fleet.vehicles.counters.progress-slim', [
			  	  					'counter' => $repair_order->vehicle->counters
			  	  									->where('type', 'kms')
			  	  									->where('vehicle_category', $plan->vehicle_category)
			  	  									->where('max', $plan->kms)
			  	  									->first()
			  	  				])
			  	  			</div>
		  	  			</div>
		  	  		@endif	
		  	  		@if($plan->natural_hours)
		  	  			<div class="flex">
		  	  				<div class="w-3/4">{{ $plan->natural_hours }} Horas Naturales</div>
		  	  				<div class="w-1/4">
		  	  					@include('fleet.vehicles.counters.progress-slim', [
		  	  						'counter' => $repair_order->vehicle->counters
		  	  								->where('type', 'natural_hours')
		  	  								->where('max', $plan->natural_hours)
		  	  								->where('vehicle_category', $plan->vehicle_category)
		  	  								->first()
		  	  						])
		  	  				</div>
		  	  			</div>
		  	  		@endif
		  	  		@if($plan->can_hours)
		  	  			<div class="flex">
		  	  				<div class="w-3/4">{{ $plan->can_hours }} Horas CAN</div>
		  	  				<div class="w-1/4">
		  	  					@include('fleet.vehicles.counters.progress-slim', [
		  	  						'counter' => $repair_order->vehicle->counters
		  	  									->where('type', 'work_hours')
		  	  									->where('max', $plan->can_hours)
		  	  									->where('vehicle_category', $plan->vehicle_category)
		  	  									->first()
		  	  					])
		  	  				</div>
		  	  			</div>
		  	  		@endif
		  	  	</div>
		  	  </td>
		  	  <td>
		  	  	<form method="POST" action="{{ route('fleet.repair-orders.maintenance-plans.store', $repair_order) }}">
		  	  		@csrf
		  	  		<input type="hidden" name="plan_id" value="{{ $plan->id }}">
		  	  		<button><i class="icon fas fa-plus-circle"></i></button>
		  	  	</form>
		  	  </td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent

@endsection
