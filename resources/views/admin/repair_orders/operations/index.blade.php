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
				'url' => '',
				'active' => true
			],
			[
				'name' => 'Planes de mantenimiento',
				'url' => route('admin.repair-orders.maintenance-plans.index', $repair_order),
				'active' => false
			]
		]
	])
	@endcomponent
	
	@component('components.search-card')
		@include('admin.operations.search', ['route' => ['admin.repair-orders.operations.index', $repair_order]])
	@endcomponent

	@if(count($operations_search) > 0)
		@component('components.card', ['is_table' => true])
			@slot('title', 'Añadir operaciones')
			<table >
			  <thead >
			    <tr >
			      <td>Código</td>
			      <td>Descripción</td>
			      <td>Tiempo (hrs)</td>
			      <td></td>
			    </tr>
			  </thead>
			  <tbody>
			  	@foreach($operations_search as $operation)
			  	<tr >
			  	  <td>
			  	  	<span class="uppercase">{{ $operation->code }}</span>
			  	  	<div class="flex items-center flex-wrap text-xs">
			  	  		<span>{{ $operation->vehicle_type }}</span>
			  	  		<i class="icon fas fa-angle-right text-gray-500 px-1"></i>
			  	  		<span>{{ $operation->subfamily->family->name }}</span>
			  	  		<i class="icon fas fa-angle-right text-gray-500 px-1"></i>
			  	  		<span>{{ $operation->subfamily->name }}</span>
			  	  	</div>
			  	  </td>
			  	  <td>
			  	  	{{ $operation->name }}
			  	  	<p class="text-xs text-gray-600">{{ $operation->description }}</p>

			  	  	@if($operation->spareParts->count() > 0)
			  	  	<fieldset class="text-xs mt-4 border p-2 rounded">
			  	  		<legend class="mx-1 text-gray-600">Recambios</legend>
			  	  		<ul>
			  	  		@foreach($operation->sparePartsGrouped() as $spare_part)
			  	  			<li>
			  	  				@if($spare_part->units > 1)
			  	  					<span style="padding: 0.1rem;" class="bg-gray-300 text-gray-700 rounded-full">{{ $spare_part->units }}x</span>
			  	  				@endif
			  	  				{{ $spare_part->reference }} &middot; {{ $spare_part->description }}
			  	  			</li>
			  	  		@endforeach
			  	  		</ul>
			  	  	</fieldset>
			  	  	@endif
			  	  </td>
			  	  <td>{{ $operation->time_in_hours }}</td>
			  	  <td>
	  	  		  	<form method="POST" action="{{ route('admin.repair-orders.operations.store', $repair_order) }}">
	  	  		  		@csrf
	  	  		  		<input type="hidden" name="operation_id" value="{{ $operation->id }}">
	  	  		  		<button><i class="icon fas fa-plus-circle"></i></button>
	  	  		  	</form>
			  	  </td>
			  	</tr>
			  	@endforeach
			  </tbody>
			</table>
		@endcomponent
	@endif

	<br><br>

	@component('components.card', ['is_table' => true])
		<div class="border-b py-4 px-6 font-bold">
			Operaciones incluídas
		</div>
		<table >
		  <thead >
		    <tr >
		      <th>Código</th>
		      <th>Descripción</th>
		      <th>Tiempo (hrs)</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  		@foreach($operations as $operation)
		  		<tr >
		  		  <td>
		  		  	<span class="uppercase">{{ $operation->code }}</span>
		  		  	<div class="flex items-center text-xs">
		  		  		<span>{{ $operation->vehicle_type }}</span>
		  		  		<i class="icon fas fa-angle-right text-gray-500 px-1"></i>
		  		  		<span>{{ $operation->subfamily->family->name }}</span>
		  		  		<i class="icon fas fa-angle-right text-gray-500 px-1"></i>
		  		  		<span>{{ $operation->subfamily->name }}</span>
		  		  	</div>
		  		  </td>
		  		  <td>
		  		  	{{ $operation->name }}
		  		  	<p class="text-xs text-gray-600">{{ $operation->description }}</p>
		  		  </td>
		  		  <td>{{ $operation->time_in_hours }}</td>
		  		  <td>
		  		  	<form method="POST" onsubmit="return confirmDelete()" action="{{ route('admin.repair-orders.operations.destroy', [$repair_order, $operation]) }}">
		  		  		@csrf
		  		  		@method('DELETE')
		  		  		<button><i class="icon fas fa-trash-alt"></i></button>
		  		  	</form>
		  		  </td>
		  		</tr>
		  		@endforeach
		  </tbody>
		</table>
	@endcomponent

@endsection
