@extends('layouts.fleet')

@section('title', 'Vehículos')

@section('content')
	@component('components.search-card')
		@include('fleet.vehicles.search', ['route' => 'fleet.vehicles.index'])
	@endcomponent

	@component('components.tabs', [
		'items' => [
			[
				'name' => 'Activos',
				'url' => route('fleet.vehicles.index'),
				'active' => request()->query('show') != 'discharged'
			],
			[
				'name' => 'Baja',
				'url' => route('fleet.vehicles.index', ['show' => 'discharged']),
				'active' => request()->query('show') == 'discharged'
			]
		]
	])
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
		      <th>Equipo</th>
		      <th class="hidden sm:table-cell">Tipo</th>
		      <th class="hidden sm:table-cell">Estado</th>
		      <th class="hidden sm:table-cell">Fecha ITV</th>
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
					@foreach ($vehicle->equipments as $equipos)
						<p>{{ $equipos->maker->name }} - {{ $equipos->model->name }}</p>
					@endforeach
				</td>
		  	  <td class="hidden sm:table-cell">
		  	  	{{ optional($vehicle->type)->name }}
		  	  </td>
		  	  <td class="hidden sm:table-cell">{{ optional($vehicle->state)->name }}</td>
		  	  <td class="hidden sm:table-cell">{{ Carbon\Carbon::parse($vehicle->itv_date)->format('d/m/Y') }}</td>
		  	  <td>
		  	  	<div class="flex">
					@if ($vehicle->state_id === App\Models\VehicleState::RENTED and $vehicle->assigned_customer_id === null)
					<a href="{{ route('fleet.vehicles.customers.index', $vehicle) }}"  class="mr-3">
						<i class="icon fas fa-exclamation fa-lg"></i>
					</a>
					@endif
		  	  		<a href="{{ route('fleet.vehicles.show', $vehicle) }}"  class="mr-3">
		  	  			<i class="icon fas fa-eye fa-lg"></i>
		  	  		</a>
		  	  		<a href="{{ route('fleet.vehicles.edit', $vehicle) }}"  class="mr-3">
		  	  			<i class="icon fas fa-edit fa-lg"></i>
		  	  		</a>
		  	  		<form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.vehicles.destroy', $vehicle) }}">
		  	  			@csrf
		  	  			@method('DELETE')
		  	  			<button><i class="icon fas fa-trash-alt fa-lg"></i></button>
					</form>	
		  	  	</div>
		  	  </td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent

	{{ $vehicles->appends(request()->query())->links() }}
@endsection
