@extends('layouts.fleet')

@section('title', $vehicle->plate . ' ' . $vehicle->chassis)

@section('content')
		
	@include('fleet.vehicles.edit_tabs', ['active_counters' => true])

	@component('components.card')
	  @slot('title', 'Contadores')

	  @if(in_array(auth()->user()->job, ['fleet_manager', 'garage_boss', 'mechanic']))
		@slot('corner')
			<div class="flex">
				<import-vehicle-counters class="mr-3"
					:plans="{{ json_encode($vehicle->getMaintenancePlans()) }}"
					:vehicle-id="{{$vehicle->id}}"
					:current-counters="{{ json_encode($vehicle->counters) }}">
				</import-vehicle-counters>
				
				<a href="{{ route('fleet.vehicles.counters.create', $vehicle) }}" class="btn-outline-gray flex items-center">
					<i class="icon fas fa-plus-circle mr-2"></i>
					Añade un plan a medida
				</a>
			</div>
		@endslot
	  @endif
	  @include('fleet.vehicles.counters.update-form')

	  <fieldset>
	  	<legend>Cambios</legend>
	  	@foreach($vehicle->counterHistory as $history)
	  		<div class="flex my-1 px-2 py-1 rounded text-xs">
	  			<div class="w-1/2">
	  				<span class="">
	  					Kms: {{ $history->kms }}, Chasis: {{ $history->work_hours_chassis }}, @if($vehicle->vehicle_type_id != 16) <!-- barredora --> Equipo: {{ $history->work_hours_equipment }} @endif
	  				</span>
	  			</div>
	  			<div class="w-1/2">
	  				{{ $history->user?->name }} &middot;
	  				{{$history->created_at->format('d/m/y H:i:s')}}
	  			</div>
	  		</div>
	  	@endforeach
	  </fieldset>

	@endcomponent

	@component('components.card', ['is_table' => true])
		@slot('title', 'Mantenimientos Chasis')
		<table>
		  <thead>
		    <tr>
		      <th>Descripción</th>
		      <th>Actual</th>
		      <th>Máximo</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($vehicle->counters->where('vehicle_category', 'chassis')->sortBy('description') as $counter)
		  	<tr>
		  	  <td>
		  	  	{{ $counter->description }} <small>ID:{{$counter->plan_id}}</small>
		  	  </td>
		  	  <td>{{ round($counter->current, 2) }} ({{ $counter->completedPercent  }}%)</td>
		  	  <td>
		  	  	<strong>{{ $counter->max }}</strong>
		  	  	@if($counter->type == 'work_hours')
		  	  		H. Trabajo
		  	  	@elseif($counter->type == 'natural_hours')
		  	  		H. Naturales
		  	  	@elseif($counter->type == 'kms')
		  	  		Kms
		  	  	@endif
		  	  </td>
		  	  <td>
		  	  	@if(in_array(auth()->user()->job, ['fleet_manager', 'garage_boss', 'mechanic']))
		  	  	<div class="flex">
		  	  		<form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.vehicles.counters.reset', [$vehicle, $counter]) }}">
		  	  			@csrf
		  	  			<button class="text-blue-600 hover:text-blue-900 focus:outline-none focus:underline mr-3">Reiniciar</button>
		  	  		</form>

		  	  		<a href="{{ route('fleet.vehicles.counters.edit', [$vehicle, $counter]) }}" class="mr-3">
		  	  			<i class="icon fas fa-edit"></i>
		  	  		</a>
		  	  		<form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.vehicles.counters.destroy', [$vehicle, $counter]) }}">
		  	  			@csrf
		  	  			@method('DELETE')
		  	  			<button><i class="icon fas fa-trash-alt"></i></button>
		  	  		</form>
		  	  	</div>
		  	  	@endif
		  	  </td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent

	@component('components.card', ['is_table' => true])
		@slot('title', 'Mantenimientos Equipo')
		<table>
		  <thead>
		    <tr>
		      <th>Descripción</th>
		      <th>Actual</th>
		      <th>Máximo</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($vehicle->counters->where('vehicle_category', 'equipment') as $counter)
		  	<tr>
		  	  <td>
		  	  	{{ $counter->description }} <small>ID:{{$counter->plan_id}}</small>
		  	  </td>
		  	  <td>{{ round($counter->current, 2) }} ({{ $counter->completedPercent  }}%)</td>
		  	  <td>
		  	  	<strong>{{ $counter->max }}</strong>
		  	  	@if($counter->type == 'work_hours')
		  	  		H. Trabajo
		  	  	@elseif($counter->type == 'natural_hours')
		  	  		H. Naturales
		  	  	@elseif($counter->type == 'kms')
		  	  		Kms
		  	  	@endif
		  	  </td>
		  	  <td>
		  	  	@if(in_array(auth()->user()->job, ['fleet_manager', 'garage_boss', 'mechanic']))
		  	  	<div class="flex">
		  	  		<form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.vehicles.counters.reset', [$vehicle, $counter]) }}">
		  	  			@csrf
		  	  			<button class="text-blue-600 hover:text-blue-900 focus:outline-none focus:underline mr-3">Reiniciar</button>
		  	  		</form>

		  	  		<a href="{{ route('fleet.vehicles.counters.edit', [$vehicle, $counter]) }}" class="mr-3">
		  	  			<i class="icon fas fa-edit"></i>
		  	  		</a>
		  	  		<form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.vehicles.counters.destroy', [$vehicle, $counter]) }}">
		  	  			@csrf
		  	  			@method('DELETE')
		  	  			<button><i class="icon fas fa-trash-alt"></i></button>
		  	  		</form>
		  	  	</div>
		  	  	@endif
		  	  </td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent

@endsection