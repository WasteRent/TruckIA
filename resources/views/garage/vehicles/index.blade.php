@extends('layouts.garage')

@section('title', 'Vehículos')

@section('content')
	@component('components.search-card')
		@include('garage.vehicles.search', ['route' => 'garage.vehicles.index'])
	@endcomponent

	@component('components.card', ['is_table' => true])
		<table>
		  <thead>
		    <tr>
		      <th>Matrícula</th>
		      <th>Chasis</th>
		      <th>Tipo</th>
		      <th>F. matriculación</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($vehicles as $vehicle)
		  	<tr class="border-t border-b text-gray-700">
		  	  <td>{{ $vehicle->plate }}</td>
		  	  <td>{{ $vehicle->chassis }}</td>
		  	  <td>
		  	  	{{ optional($vehicle->type)->name }}
		  	  </td>
		  	  <td>{{ Carbon\Carbon::parse($vehicle->registration_date)->format('d/m/Y') }}</td>
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

	{{ $vehicles->appends(request()->query())->links() }}

@endsection
