@extends('layouts.customer')

@section('title', 'Mantenimiento Preventivo')

@section('content')
	@component('components.card', ['is_table' => true])
		<table >
		  <thead >
		    <tr >
		      <td>Nombre</td>
		      <td>Matrícula</td>
		      <td>Vehículo</td>
		      <td>Fecha</td>
		      <td></td>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($preventives as $preventive)
		  	<tr >
		  	  <td>{{ $preventive->name }}</td>
		  	  <td>{{ $preventive->vehicle->plate }}</td>
		  	  <td>{{ $preventive->vehicle->chassis }} {{ $preventive->vehicle->box }}</td>
		  	  <td>{{ $preventive->created_at->format('d/m/Y H:i:s') }}</td>
		  	  <td>
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
