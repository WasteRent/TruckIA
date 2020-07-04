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
	

	<form method="POST" action="{{ route('fleet.repair-orders.maintenance-plans.store', $repair_order) }}">
		@csrf
		@component('components.card', ['is_table' => true])
			@slot('title', 'Mantenimientos')

			@slot('corner')
				<button type="submit" class="btn-outline-gray"><i class="icon fas fa-plus-circle mr-2"></i>Añadir mantenimientos</button>
			@endslot	

			<table>
			  <thead>
			    <tr>
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
			  	  	@include('fleet.repair_orders.operations.plans_counters')
			  	  </td>
			  	  <td>
			  	  	<input type="checkbox" name="plan_ids[]" value="{{ $plan->id }}">
			  	  </td>
			  	</tr>
			  	@endforeach
			  </tbody>
			</table>
		@endcomponent
	</form>
@endsection
