@extends('layouts.admin')

@section('title', 'Vehículos')

@section('content')
	@component('components.search-card')
		@include('admin.vehicles.search', ['route' => 'admin.vehicles.index'])
	@endcomponent

	@component('components.card', ['is_table' => true])
		@slot('corner')
			<a href="{{ route('admin.vehicles.create') }}" class="btn-outline-gray flex items-center">
				<i class="icon fas fa-plus-circle mr-2"></i>
				Nuevo
			</a>
		@endslot
		<table >
		  <thead >
		    <tr >
		      <th>Matrícula</th>
		      <th>Chasis</th>
		      <th>Equipo</th>
		      <th>Kms</th>
		      <th>F. matriculación</th>
		      <th>Flota</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($vehicles as $vehicle)
		  	<tr >
		  	  <td>{{ $vehicle->plate }}</td>
		  	  <td>{{ $vehicle->chassis }}</td>
		  	  <td>
		  	  	{{ $vehicle->equipment }}
		  	  	{{ $vehicle->equipment2 }}
		  	  	{{ $vehicle->equipment3 }}
		  	  </td>
		  	  <td>{{ $vehicle->kms }}</td>
		  	  <td>{{ Carbon\Carbon::parse($vehicle->registration_date)->format('d/m/Y') }}</td>
		  	  <td>{{ $vehicle->fleet->name }}</td>
		  	  <td>
		  	  	<div class="flex">
		  	  		<a href="{{ route('admin.vehicles.edit', $vehicle) }}"  class="mr-3">
		  	  			<i class="icon fas fa-eye"></i>
		  	  		</a>
		  	  		<form method="POST" onsubmit="return confirmDelete()" action="{{ route('admin.vehicles.destroy', $vehicle) }}">
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
