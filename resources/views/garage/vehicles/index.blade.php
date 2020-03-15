@extends('layouts.garage')

@section('title', 'Vehículos')

@section('content')
	@component('components.search-card')
		@include('admin.vehicles.search', ['route' => 'garage.vehicles.index'])
	@endcomponent

	@component('components.card', ['is_table' => true])
		<table class="table-auto w-full">
		  <thead class="uppercase text-xs font-bold tracking-wide">
		    <tr class="bg-gray-100 border-t border-b">
		      <td class="px-6 py-2">Matrícula</td>
		      <td class="px-6 py-2">Chasis</td>
		      <td class="px-6 py-2">Equipo</td>
		      <td class="px-6 py-2">Kms</td>
		      <td class="px-6 py-2">F. matriculación</td>
		      <td class="px-6 py-2">Flota</td>
		      <td class="px-6 py-2"></td>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($vehicles as $vehicle)
		  	<tr class="border-t border-b text-gray-700">
		  	  <td class="px-6 py-2">{{ $vehicle->plate }}</td>
		  	  <td class="px-6 py-2">{{ $vehicle->chassis }}</td>
		  	  <td class="px-6 py-2">
		  	  	{{ $vehicle->equipment }}
		  	  	{{ $vehicle->equipment2 }}
		  	  	{{ $vehicle->equipment3 }}
		  	  </td>
		  	  <td class="px-6 py-2">{{ $vehicle->kms }}</td>
		  	  <td class="px-6 py-2">{{ Carbon\Carbon::parse($vehicle->registration_date)->format('d/m/Y') }}</td>
		  	  <td class="px-6 py-2">{{ $vehicle->fleet->name }}</td>
		  	  <td class="px-6 py-2">
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
