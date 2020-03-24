@extends('layouts.admin')

@section('title', 'Citas')

@section('content')
	
	@component('components.card', ['is_table' => true])
		@slot('corner')
			<a href="{{ route('admin.appointments.create') }}" class="border px-4 py-1 rounded hover:bg-gray-100 shadow flex items-center">
				<i class="icon fas fa-plus-circle mr-2"></i>
				Nuevo
			</a>
		@endslot
		
		<table class="table-auto w-full">
		  <thead class="uppercase text-xs font-bold tracking-wide">
		    <tr class="bg-gray-100 border-t border-b">
		      <td class="px-6 py-2">Fecha</td>
		      <td class="px-6 py-2">Vehículo</td>
		      <td class="px-6 py-2">Nota</td>
		      <td class="px-6 py-2"></td>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($appointments as $appointment)
		  	<tr class="border-t border-b text-gray-700">
		  	  <td class="px-6 py-2">{{ $appointment->date_time->format('d/m/Y H:i') }}</td>
		  	  <td class="px-6 py-2">
		  	  	{{ $appointment->vehicle->plate }} &middot;
		  	  	{{ $appointment->vehicle->chassis }}
		  	  	{{ $appointment->vehicle->equipment }}
		  	  </td>
		  	  <td class="px-6 py-2">{{ $appointment->notes }}</td>
		  	  <td class="px-6 py-2 flex">
		  	  	<a href="{{ route('admin.appointments.edit', $appointment) }}" class="mr-3">
		  	  		<i class="icon fas fa-edit"></i>
		  	  	</a>
		  	  	<form method="POST" onsubmit="return confirmDelete()" action="{{ route('admin.appointments.destroy', $appointment) }}">
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
