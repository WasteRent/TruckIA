@extends('layouts.customer')

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
		  	  </td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent
@endsection
