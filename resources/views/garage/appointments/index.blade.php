@extends('layouts.garage')

@section('title', 'Citas')

@section('content')
	
	@component('components.card', ['is_table' => true])		
		<table >
		  <thead >
		    <tr >
		      <td>Fecha</td>
		      <td>Vehículo</td>
		      <td>Nota</td>
		      <td></td>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($appointments as $appointment)
		  	<tr >
		  	  <td>{{ $appointment->date_time->format('d/m/Y H:i') }}</td>
		  	  <td>
		  	  	{{ $appointment->vehicle->plate }} &middot;
		  	  	{{ $appointment->vehicle->chassis }}
		  	  	{{ $appointment->vehicle->equipment }}
		  	  </td>
		  	  <td>{{ $appointment->notes }}</td>
		  	  <td class="px-6 py-2 flex">
		  	  	<a href="{{ route('garage.appointments.edit', $appointment) }}" class="mr-3">
		  	  		<i class="icon fas fa-edit"></i>
		  	  	</a>
		  	  	<form method="POST" onsubmit="return confirmDelete()" action="{{ route('garage.appointments.destroy', $appointment) }}">
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
