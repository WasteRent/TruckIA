@extends('layouts.fleet')

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
		      <th>Actual</th>
		      <th>Máximo</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($vehicle->counters as $counter)
		  	<tr>
		  	  <td>{{ $counter->current }}</td>
		  	  <td>{{ $counter->max }} {{ $counter->type == 'hours' ? 'H':'kms' }}</td>
		  	  <td>
		  	  	<div class="flex">
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