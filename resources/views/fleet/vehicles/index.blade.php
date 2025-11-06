@extends('layouts.fleet')

@section('title', __('Vehículos'))

@section('content')
	@component('components.search-card')
		@include('fleet.vehicles.search', ['route' => 'fleet.vehicles.index'])
	@endcomponent

	@component('components.card', ['is_table' => true])
		@slot('corner')
		<a class="mr-4 text-green-600" href="{{ route('fleet.export.vehicles', request()->query()) }}"><i class="fas fa-lg fa-file-excel"></i></a>
			@if(in_array(auth()->user()->job, ['fleet_manager', 'contract_manager']))

				<a href="{{ route('fleet.import-vehicles.create') }}" class="btn-outline-gray flex items-center">
					<i class="fas fa-upload mr-2"></i>
					{{ __('Importar') }}
				</a>
				@if(auth()->user()->fleet->vehicles()->count() < auth()->user()->fleet->vehicles_limit)
				<a href="{{ route('fleet.vehicles.create') }}" class="btn-outline-gray flex items-center">
					<i class="icon fas fa-plus-circle mr-2"></i>
					{{ __('Nuevo') }}
					</a>
				@endif
			@endif
		@endslot
		<div class="overflow-x-auto">
		<table class="min-w-full">
		  <thead>
		    <tr>
		      <th class="w-1"></th>
		      <th>{{ __('Matrícula') }}</th>
		      <th>{{ __('Chasis') }}</th>
		      <th>{{ __('Equipo') }}</th>
		      <th class="hidden sm:table-cell">{{ __('Tipo') }}</th>
			  <th>{{ __('Combustible') }}</th>
			  <th>{{ __('HVO') }}</th>
		      <th class="hidden sm:table-cell">{{ __('Estado') }}</th>
			  <th>{{ __('Cliente') }}</th>
			  <th>{{ __('Ubicación') }}</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody class="overflow-x-auto">
		  	@foreach($vehicles as $vehicle)
		  	<tr>
		  	  <td class="w-1">
		  	  	@if($vehicle->tracking()->count() > 0)
		  	  		@if($vehicle->isMoving() )
		  	  			<span class="h-4 w-4 bg-green-100 rounded-full flex items-center justify-center" aria-hidden="true">
		  	  				<span class="h-2 w-2 bg-green-400 rounded-full"></span>
		  	  			</span>
		  	  		@else
		  	  			<span class="h-4 w-4 bg-gray-100 rounded-full flex items-center justify-center" aria-hidden="true">
		  	  				<span class="h-2 w-2 bg-gray-400 rounded-full"></span>
		  	  			</span>
		  	  		@endif
		  	  	@else
		  	  		<i class="fas fa-dot-circle text-transparent mr-2"></i>
		  	  	@endif
		  	  </td>
		  	  <td>@if($vehicle->internal_id) ({{ $vehicle->internal_id }}) - @endif {{ $vehicle->plate }}</td>
				<td>{{ $vehicle->chassis }}</td>
		  	  	<td>
					@foreach ($vehicle->equipments as $equipos)
						<p>{{ $equipos->maker?->name }} - {{ $equipos->model?->name }}</p>
					@endforeach
				</td>
		  	  <td class="hidden sm:table-cell">
		  	  	{{ __(optional($vehicle->type)->name) }}
		  	  </td>
			  <td>
				{{$vehicle->fuel}}
			  </td>
			
			  <td>
				@if ($vehicle->hvo === null)
					{{ '' }}
				@elseif ($vehicle->hvo === 1)
					{{ 'Si' }}
				@elseif ($vehicle->hvo === 0)
					{{ 'No' }}
				@endif
			  </td>
		  	  <td class="hidden sm:table-cell">{{ __(optional($vehicle->state)->name) }}</td>
			  <td>
				{{$vehicle->customer?->name}}
			  </td>
			  <td>
				{{$vehicle->location?->name}}
			  </td>
		  	  <td>
		  	  	<div class="flex">
		  	  		<a href="{{ route('fleet.vehicles.show', $vehicle) }}"  class="mr-3">
		  	  			<i class="icon fas fa-eye"></i>
		  	  		</a>
					@if(in_array(auth()->user()->job, ['fleet_manager', 'garage_boss', 'mechanic', 'garage', 'contract_manager']))
		  	  		<a href="{{ route('fleet.vehicles.edit', $vehicle) }}"  class="mr-3">
		  	  			<i class="icon fas fa-edit"></i>
		  	  		</a>
					@endif
		  	  		@if(auth()->user()->job == 'fleet_manager')
		  	  		<form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.vehicles.destroy', $vehicle) }}">
		  	  			@csrf
		  	  			@method('DELETE')
		  	  			<button><i class="icon fas fa-trash-alt"></i></button>
					</form>
					@endif
		  	  	</div>
		  	  </td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent

	{{ $vehicles->appends(request()->query())->links() }}
@endsection
