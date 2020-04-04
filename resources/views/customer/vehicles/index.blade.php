@extends('layouts.customer')

@section('title', 'Vehículos')

@section('content')
	@component('components.search-card')
		@include('admin.vehicles.search', ['route' => 'customer.vehicles.index'])
	@endcomponent

	@component('components.card', ['is_table' => true])
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
		  	  	<a href="{{ route('customer.vehicles.show', $vehicle) }}"  class="mr-3">
		  	  		<i class="icon fas fa-eye"></i>
		  	  	</a>
		  	  	<a href="{{ route('customer.vehicles.failures.index', $vehicle) }}"  class="mr-3">
		  	  		<i class="icon fas fa-exclamation-triangle"></i>
		  	  	</a>
		  	  </td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent
@endsection
