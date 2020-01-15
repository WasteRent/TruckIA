@extends('layouts.admin')

@section('progress')
	<div class="mb-8">
		@include('shared.steps', [
			'steps' => [
				[
					'name' => 'Vehículo',
					'url' => route('admin.repair-orders.vehicles.edit', [$repair_order, $repair_order->vehicle]),
					'active' => true,
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
					'active' => false,
					'icon' => 'fas fa-cogs'
				]
			]
		])
	</div>
@endsection

@section('title', 'Editar Vehículo de OR#' . $repair_order->id)

@section('content')

	@include('shared.vehicles.show', ['vehicle' => $selected_vehicle])

	<br><br>

	@component('components.search-card')
		@include('admin.vehicles.search', ['route' => ['admin.repair-orders.vehicles.edit', $repair_order, $selected_vehicle]])
	@endcomponent

	@if(count($vehicles_search) > 0)
		@component('components.card', ['is_table' => true])
			@slot('title', 'Cambiar vehículo')
			<table class="table-auto w-full">
			  <thead class="uppercase text-xs font-bold tracking-wide">
			    <tr class="bg-gray-100 border-t border-b">
			      <td class="px-6 py-2">Matrícula</td>
			      <td class="px-6 py-2">Chasis</td>
			      <td class="px-6 py-2">Caja</td>
			      <td class="px-6 py-2">Kms</td>
			      <td class="px-6 py-2">F. matriculación</td>
			      <td class="px-6 py-2">Flota</td>
			      <td class="px-6 py-2"></td>
			    </tr>
			  </thead>
			  <tbody>
			  	@foreach($vehicles_search as $vehicle)
			  	<tr class="border-t border-b text-gray-700">
			  	  <td class="px-6 py-2">{{ $vehicle->plate }}</td>
			  	  <td class="px-6 py-2">{{ $vehicle->chassis_maker }} {{ $vehicle->chassis_model }}</td>
			  	  <td class="px-6 py-2">{{ $vehicle->box_maker }} {{ $vehicle->box_model }}</td>
			  	  <td class="px-6 py-2">{{ $vehicle->kms }}</td>
			  	  <td class="px-6 py-2">{{ $vehicle->registration_date ? $vehicle->registration_date->format('d/m/Y') : '' }}</td>
			  	  <td class="px-6 py-2">{{ $vehicle->fleet->name }}</td>
			  	  <td class="px-6 py-2">
			  	  	<form method="POST" action="{{ route('admin.repair-orders.vehicles.update', [$repair_order, $selected_vehicle]) }}">
			  	  		@csrf
			  	  		@method('PUT')
			  	  		<input type="hidden" name="new_vehicle_id" value="{{ $vehicle->id }}">
			  	  		<button><i class="icon fas fa-hand-pointer"></i></button>
			  	  	</form>
			  	  </td>
			  	</tr>
			  	@endforeach
			  </tbody>
		@endcomponent
	@endif


@endsection
