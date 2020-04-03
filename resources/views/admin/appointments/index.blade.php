@extends('layouts.admin')

@section('title', 'Citas')

@section('content')
	
	@component('components.card', ['is_table' => true])		
		<table>
		  <thead>
		    <tr>
		      <th>Fecha</th>
		      <th>Vehículo</th>
		      <th>Nota</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($appointments as $appointment)
		  	<tr>
		  	  <td>{{ $appointment->date_time->format('d/m/Y H:i') }}</td>
		  	  <td>
		  	  	{{ $appointment->vehicle->plate }} &middot;
		  	  	{{ $appointment->vehicle->chassis }}
		  	  	{{ $appointment->vehicle->equipment }}
		  	  </td>
		  	  <td>{{ $appointment->notes }}</td>
		  	  <td class="flex">
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
