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
		      <th>Marca</th>
		      <th>Modelo</th>
		      <th>Frecuencia</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($plans as $plan)
		  	<tr >
		  	  <td>{{ $plan->name }}</td>
		  	  <td>{{ $plan->manufacturer->name }}</td>
		  	  <td>{{ $plan->model->name }}</td>
		  	  <td>
		  	  	{{ $plan->frequency_1 }} {{ $plan->frequency_type_1 }},
		  	  	{{ $plan->frequency_2 }} {{ $plan->frequency_type_2 }},
		  	  	{{ $plan->frequency_3 }} {{ $plan->frequency_type_3 }}
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
