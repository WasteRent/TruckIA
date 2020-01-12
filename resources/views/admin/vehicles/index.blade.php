@extends('layouts.admin')

@section('title', 'Vehículos')

@section('content')
	@component('components.search-card')
		@include('admin.vehicles.search', ['route' => 'admin.vehicles.index'])
	@endcomponent

	@component('components.card', ['is_table' => true])
		<div class="float-right my-2 mr-3">
			<a href="{{ route('admin.vehicles.create') }}" class="border px-4 py-1 rounded hover:bg-gray-100 shadow flex items-center">
				<i class="icon fas fa-plus-circle mr-2"></i>
				Nuevo
			</a>
		</div>
		<table class="table-auto w-full">
		  <thead class="uppercase text-xs font-bold tracking-wide">
		    <tr class="bg-gray-100 border-t border-b">
		      <td class="px-6 py-2">Matrícula</td>
		      <td class="px-6 py-2">Chasis</td>
		      <td class="px-6 py-2">Caja</td>
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
		  	  <td class="px-6 py-2">{{ $vehicle->box }}</td>
		  	  <td class="px-6 py-2">{{ $vehicle->kms }}</td>
		  	  <td class="px-6 py-2">{{ Carbon\Carbon::parse($vehicle->registration_date)->format('d/m/Y') }}</td>
		  	  <td class="px-6 py-2">{{ $vehicle->fleet->name }}</td>
		  	  <td class="px-6 py-2">
		  	  	<a href="{{ route('admin.vehicles.edit', $vehicle) }}" class="mr-2">
		  	  		<i class="icon fas fa-edit"></i>
		  	  	</a>
		  	  	<a href="{{ route('admin.vehicles.show', $vehicle) }}">
		  	  		<i class="icon fas fa-eye"></i>
		  	  	</a>
		  	  </td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent
@endsection
