@extends('layouts.garage')

@section('title', 'Citas')

@section('content')
	
	@component('components.card', ['is_table' => true])		
		<table >
		  <thead >
		    <tr >
		      <th>Fecha cita</th>
		      <th>Orden</th>
		      <th>Vehículo</th>
		      <th>Nota</th>
		      <th>Fecha de creación</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($appointments as $appointment)
		  	<tr >
		  	  <td> <span class="bg-yellow-100 text-yellow-800 border border-yellow-200 rounded-full px-3 py-1">{{ $appointment->date_time->format('d/m/Y H:i') }}</span></td>
		  	  <td>
		  	  	<a href="{{ route('garage.repair-orders.show', $appointment->repair_order_id) }}">
		  	  		<strong>OR #{{ $appointment->repair_order_id }}</strong>
		  	  	</a>
		  	  </td>
		  	  <td>
		  	  	{{ $appointment->vehicle->plate }} &middot;
		  	  	{{ $appointment->vehicle->chassis }}
		  	  	{{ $appointment->vehicle->equipment }}
				</td>
		  	  	<td>{{ $appointment->notes }}</td>
				<td>{{ $appointment->created_at }}</td>
		  	  <td>
		  	  	<div class="flex">
		  	  		<!-- <a href="{{ route('garage.appointments.edit', $appointment) }}" class="mr-3">
		  	  			<i class="icon fas fa-edit"></i>
		  	  		</a> -->
		  	  		<form method="POST" onsubmit="return confirmDelete()" action="{{ route('garage.appointments.destroy', $appointment) }}">
		  	  			@csrf
		  	  			@method('DELETE')
		  	  			<button><i class="icon fas fa-trash-alt"></i></button>
		  	  		</form>
		  	  	</div>
		  	  </td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent
@endsection
