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
					'active' => true,
					'icon' => 'fas fa-cogs'
				],
				[
					'name' => 'Autorización',
					'url' => route('admin.repair-orders.authorization', $repair_order),					'active' => false,
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
		<span class="mr-2">OR# {{ $repair_order->id }} Operaciones</span>
		<span class="{{ $repair_order->state->color }} rounded-full px-3 py-1 text-xs font-medium">
			{{ $repair_order->state->name }}
		</span>
	</div>
@endsection
	

@section('content')
	@component('components.tabs', [
		'items' => [
			[
				'name' => 'Operaciones',
				'url' => route('admin.repair-orders.operations.index', $repair_order),
				'active' => false
			],
			[
				'name' => 'Planes de mantenimiento',
				'url' => route('admin.repair-orders.maintenance-plans.index', $repair_order),
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
		      <td>Nombre</td>
		      <td>Marca</td>
		      <td>Modelo</td>
		      <td>Frecuencia</td>
		      <td></td>
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
		  	  	<form method="POST" action="{{ route('admin.repair-orders.maintenance-plans.store', $repair_order) }}">
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
