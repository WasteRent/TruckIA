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

		<div class="text-right">
			<button type="submit" class="btn-outline-gray my-4"><i class="icon fas fa-plus-circle mr-2"></i>Añadir mantenimientos</button>
		</div>

		@foreach($plans->groupBy('manufacturer_id') as $plans_group)
			@component('components.card', ['is_table' => true])
				@slot('title', 'Mantenimientos > ' . optional($plans_group->first()->manufacturer)->name .' '. optional($plans_group->first()->model)->name)

				@slot('corner')
					
				@endslot	

				<table>
				  <thead>
				    <tr>
				      <th>Nombre</th>
				      <th>Frecuencia</th>
				      <th></th>
				    </tr>
				  </thead>
				  <tbody>
				  	@foreach($plans_group->sortBy('name') as $plan)
				  	<tr>
				  	  <td class="max-w-sm">{{ $plan->name }}</td>
				  	  <td class="w-1/2">
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
		@endforeach
	</form>
@endsection
