@extends('layouts.admin')

@section('title', 'Vehículos')

@section('content')
	@component('components.search-card')
		@include('admin.vehicles.search', ['route' => 'admin.vehicles.index'])
	@endcomponent

	@component('components.card', ['is_table' => true])
		@slot('corner')
			<a href="{{ route('admin.vehicles.create') }}" class="border px-4 py-1 rounded hover:bg-gray-100 shadow flex items-center">
				<i class="icon fas fa-plus-circle mr-2"></i>
				Nuevo
			</a>
		@endslot
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
		  	  <td class="px-6 py-2 flex">
		  	  	<a href="{{ route('admin.vehicles.edit', $vehicle) }}"  class="mr-3">
		  	  		<i class="icon fas fa-eye"></i>
		  	  	</a>
		  	  	<form method="POST" onsubmit="return confirmDelete()" action="{{ route('admin.vehicles.destroy', $vehicle) }}">
		  	  		@csrf
		  	  		@method('DELETE')
		  	  		<button><i class="icon fas fa-trash-alt"></i></button>
		  	  	</form>
		  	  </td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent
@endsection
