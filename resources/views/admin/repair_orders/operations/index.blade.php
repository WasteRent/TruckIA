@extends('layouts.admin')

@section('progress')
	<div class="mb-8">
		@include('shared.steps', [
			'steps' => [
				[
					'name' => 'Vehículo',
					'url' => route('admin.repair-orders.vehicles.edit', [$repair_order, $repair_order->vehicle]),
					'active' => false,
					'icon' => 'fas fa-bus-alt'
				],
				[
					'name' => 'Taller',
					'url' => route('admin.repair-orders.garages.edit', [$repair_order, $repair_order->garage]),
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
					'url' => route('admin.repair-orders.authorization', $repair_order),
					'active' => false,
					'icon' => 'fas fa-rocket'
				]
			]
		])
	</div>
@endsection

@section('title', 'Editar Operaciones de OR#' . $repair_order->id)

@section('content')
	
	@component('components.search-card')
		@include('admin.operations.search', ['route' => ['admin.repair-orders.operations.index', $repair_order]])
	@endcomponent

	@if(count($operations_search) > 0)
		@component('components.card', ['is_table' => true])
			@slot('title', 'Añadir operaciones')
			<table class="table-auto w-full">
			  <thead class="uppercase text-xs font-bold tracking-wide">
			    <tr class="bg-gray-100 border-t border-b">
			      <td class="px-6 py-2">Código</td>
			      <td class="px-6 py-2">Descripción</td>
			      <td class="px-6 py-2">Tiempo (hrs)</td>
			      <td class="px-6 py-2"></td>
			    </tr>
			  </thead>
			  <tbody>
			  	@foreach($operations_search as $operation)
			  	<tr class="border-t border-b text-gray-700">
			  	  <td class="px-6 py-2">
			  	  	<span class="uppercase">{{ $operation->code }}</span>
			  	  	<div class="flex items-center flex-wrap text-xs">
			  	  		<span>{{ $operation->vehicle_type }}</span>
			  	  		<i class="icon fas fa-angle-right text-gray-500 px-1"></i>
			  	  		<span>{{ $operation->subfamily->family->name }}</span>
			  	  		<i class="icon fas fa-angle-right text-gray-500 px-1"></i>
			  	  		<span>{{ $operation->subfamily->name }}</span>
			  	  	</div>
			  	  </td>
			  	  <td class="px-6 py-2">
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
			  	  <td class="px-6 py-2">{{ $operation->time_in_hours }}</td>
			  	  <td class="px-6 py-2">
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
		<table class="table-auto w-full">
		  <thead class="uppercase text-xs font-bold tracking-wide">
		    <tr class="bg-gray-100 border-t border-b">
		      <td class="px-6 py-2">Código</td>
		      <td class="px-6 py-2">Descripción</td>
		      <td class="px-6 py-2">Tiempo (hrs)</td>
		      <td class="px-6 py-2"></td>
		    </tr>
		  </thead>
		  <tbody>
		  		@foreach($operations as $operation)
		  		<tr class="border-t border-b text-gray-700">
		  		  <td class="px-6 py-2">
		  		  	<span class="uppercase">{{ $operation->code }}</span>
		  		  	<div class="flex items-center text-xs">
		  		  		<span>{{ $operation->vehicle_type }}</span>
		  		  		<ion-icon class="text-gray-500" name="ios-arrow-forward"></ion-icon>
		  		  		<span>{{ $operation->subfamily->family->name }}</span>
		  		  		<ion-icon class="text-gray-500" name="ios-arrow-forward"></ion-icon>
		  		  		<span>{{ $operation->subfamily->name }}</span>
		  		  	</div>
		  		  </td>
		  		  <td class="px-6 py-2">
		  		  	{{ $operation->name }}
		  		  	<p class="text-xs text-gray-600">{{ $operation->description }}</p>
		  		  </td>
		  		  <td class="px-6 py-2">{{ $operation->time_in_hours }}</td>
		  		  <td class="px-6 py-2">
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
