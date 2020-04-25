@extends('layouts.fleet')

@section('title', 'Vehículos')

@section('content')
	@component('components.search-card')
		@include('fleet.vehicles.search', ['route' => 'fleet.vehicles.index'])
	@endcomponent

	@component('components.card', ['is_table' => true])
		@slot('corner')
			<a class="mr-4 text-green-600" href="{{ route('fleet.export.vehicles') }}"><i class="fas fa-lg fa-file-excel"></i></a>
			<a href="{{ route('fleet.vehicles.create') }}" class="btn-outline-gray flex items-center">
				<i class="icon fas fa-plus-circle mr-2"></i>
				Nuevo
			</a>
		@endslot
		<table>
		  <thead>
		    <tr>
		      <th>Matrícula</th>
		      <th>Chasis</th>
		      <th>Tipo</th>
		      <th>Estado</th>
		      <th>F. matriculación</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($vehicles as $vehicle)
		  	<tr>
		  	  <td>
		  	  	@if($vehicle->webfleet_id)
			  	  	{!! 
			  	  		$vehicle->isMoving() 
			  	  		? '<i class="fas fa-dot-circle text-green-500 mr-2"></i>'
			  	  		: '<i class="fas fa-dot-circle text-gray-400 mr-2"></i>'
			  	  	!!}
		  	  	@else
		  	  		<i class="fas fa-dot-circle text-transparent mr-2"></i>
		  	  	@endif
		  	  	{{ $vehicle->plate }}
		  	  </td>
		  	  <td>{{ $vehicle->chassis }}</td>
		  	  <td>
		  	  	{{ optional($vehicle->type)->name }}
		  	  </td>
		  	  <td>{{ optional($vehicle->state)->name }}</td>
		  	  <td>{{ Carbon\Carbon::parse($vehicle->registration_date)->format('d/m/Y') }}</td>
		  	  <td>
		  	  	<div class="flex">
		  	  		<a href="{{ route('fleet.vehicles.show', $vehicle) }}"  class="mr-3">
		  	  			<i class="icon fas fa-eye"></i>
		  	  		</a>
		  	  		<a href="{{ route('fleet.vehicles.edit', $vehicle) }}"  class="mr-3">
		  	  			<i class="icon fas fa-edit"></i>
		  	  		</a>
		  	  	</div>
		  	  </td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent

	{{ $vehicles->appends(request()->query())->links() }}
@endsection
