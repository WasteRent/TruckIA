@extends('layouts.admin')

@section('content')
<div class="shadow-lg rounded bg-white">
	<div class="float-right my-2 mr-3">
		<a href="{{ route('admin.vehicles.create') }}" class="border px-4 py-1 rounded hover:bg-gray-100 shadow flex items-center">
			<ion-icon class="mr-2" name="add"></ion-icon>
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
	  	  <td class="px-6 py-2">{{ $vehicle->chassis_maker }} {{ $vehicle->chassis_model }}</td>
	  	  <td class="px-6 py-2">{{ $vehicle->box_maker }} {{ $vehicle->box_model }}</td>
	  	  <td class="px-6 py-2">{{ $vehicle->kms }}</td>
	  	  <td class="px-6 py-2">{{ $vehicle->registration_date->format('d/m/Y') }}</td>
	  	  <td class="px-6 py-2">{{ $vehicle->fleet->name }}</td>
	  	  <td class="px-6 py-2">
	  	  	<a href="{{ route('admin.vehicles.edit', $vehicle) }}" class="mr-2">
	  	  		<ion-icon class="text-xl" name="ios-create"></ion-icon>
	  	  	</a>
	  	  	<a href="{{ route('admin.vehicles.show', $vehicle) }}">
	  	  		<ion-icon class="text-xl" name="ios-eye"></ion-icon>
	  	  	</a>
	  	  </td>
	  	</tr>
	  	@endforeach
	  </tbody>
	</table>
</div>
@endsection
