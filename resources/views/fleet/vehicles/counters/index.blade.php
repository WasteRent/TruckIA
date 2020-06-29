@extends('layouts.fleet')

@section('title', $vehicle->plate . '  &middot;  ' . $vehicle->chassis)

@section('content')
		
	@include('fleet.vehicles.edit_tabs', ['active_counters' => true])

	@component('components.card', ['is_table' => true])
		@slot('title', 'Contadores')
		@slot('corner')
			<a href="{{ route('fleet.vehicles.counters.create', $vehicle) }}" class="btn-outline-gray flex items-center">
				<i class="icon fas fa-plus-circle mr-2"></i>
				Nuevo
			</a>
		@endslot
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
		  	@foreach($vehicle->counters as $counter)
		  	<tr>
		  	  <td>
		  	  	<span class="uppercase font-medium text-xs">
		  	  		@if($counter->vehicle_category == 'chassis')
		  	  			Chasis
		  	  		@else
		  	  			Equipo
		  	  		@endif
		  	  	</span>
		  	  	&middot; {{ $counter->description }}
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
		  	  	<div class="flex">
		  	  		<form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.vehicles.counters.reset', [$vehicle, $counter]) }}">
		  	  			@csrf
		  	  			<button class="text-indigo-600 hover:text-indigo-900 focus:outline-none focus:underline mr-3">Reiniciar</button>
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
		  	  </td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent

@endsection