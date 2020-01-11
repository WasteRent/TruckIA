@extends('layouts.admin')

@section('title', 'Nueva Orden de Reparación')

@section('content')

	@include('shared.vehicles.show', ['vehicle' => $selected_vehicle])

	@component('components.search-card')
		@include('admin.vehicles.search', ['route' => ['admin.repair-orders.vehicles.edit', $repair_order, $selected_vehicle]])
	@endcomponent

	@if(count($vehicles_search) > 0)
		@component('components.card', ['is_table' => true])
			@slot('title', 'Seleccionar vehículo')
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
			  	  <td class="px-6 py-2">{{ $vehicle->registration_date->format('d/m/Y') }}</td>
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
