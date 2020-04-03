@extends('layouts.customer')

@section('title', 'Reporte de Averías ' . $vehicle->plate)

@section('content')
	
	@component('components.card', ['is_table' => true])
		@slot('corner')
			<a href="{{ route('customer.vehicles.failures.create', $vehicle) }}" class="border px-4 py-1 rounded hover:bg-gray-100 shadow flex items-center">
				<i class="icon fas fa-plus-circle mr-2"></i>
				Nuevo
			</a>
		@endslot
		
		<table class="table-auto w-full">
		  <thead class="uppercase text-xs font-bold tracking-wide">
		    <tr class="bg-gray-100 border-t border-b">
		      <td class="px-6 py-2">Tipo</td>
		      <td class="px-6 py-2">Observaciones</td>
		      <td class="px-6 py-2">Fecha</td>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($failures as $failure)
		  	<tr class="border-t border-b text-gray-700">
		  	  <td class="px-6 py-2">{{ $failure->type->name }}</td>
		  	  <td class="px-6 py-2">{{ $failure->observations }}</td>
		  	  <td class="px-6 py-2">{{ $failure->created_at }}</td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent
@endsection
