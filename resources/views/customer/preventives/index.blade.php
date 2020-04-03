@extends('layouts.customer')

@section('title', 'Mantenimiento Preventivo')

@section('content')
	@component('components.card', ['is_table' => true])
		<table class="table-auto w-full">
		  <thead class="uppercase text-xs font-bold tracking-wide">
		    <tr class="bg-gray-100 border-t border-b">
		      <td class="px-6 py-2">Nombre</td>
		      <td class="px-6 py-2">Matrícula</td>
		      <td class="px-6 py-2">Vehículo</td>
		      <td class="px-6 py-2">Fecha</td>
		      <td class="px-6 py-2"></td>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($preventives as $preventive)
		  	<tr class="border-t border-b text-gray-700">
		  	  <td class="px-6 py-2">{{ $preventive->name }}</td>
		  	  <td class="px-6 py-2">{{ $preventive->vehicle->plate }}</td>
		  	  <td class="px-6 py-2">{{ $preventive->vehicle->chassis }} {{ $preventive->vehicle->box }}</td>
		  	  <td class="px-6 py-2">{{ $preventive->created_at->format('d/m/Y H:i:s') }}</td>
		  	  <td class="px-6 py-2">
		  	  	<a href="{{ route('customer.preventives.show', $preventive) }}"  class="mr-3">
		  	  		<i class="icon fas fa-eye"></i>
		  	  	</a>
		  	  </td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent
@endsection
