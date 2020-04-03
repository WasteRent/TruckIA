@extends('layouts.garage')

@section('title', 'Vehículos')

@section('content')
	@component('components.search-card')
		@include('admin.vehicles.search', ['route' => 'garage.vehicles.index'])
	@endcomponent

	@component('components.card', ['is_table' => true])
		<table >
		  <thead >
		    <tr >
		      <td>Matrícula</td>
		      <td>Chasis</td>
		      <td>Equipo</td>
		      <td>Kms</td>
		      <td>F. matriculación</td>
		      <td>Flota</td>
		      <td></td>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($vehicles as $vehicle)
		  	<tr class="border-t border-b text-gray-700">
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
		  	  	<a href="{{ route('garage.vehicles.show', $vehicle) }}"  class="mr-3">
		  	  		<i class="icon fas fa-eye"></i>
		  	  	</a>
		  	  </td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent
@endsection
