@extends('layouts.customer')

@section('title', 'Reporte de Averías ' . $vehicle->plate)

@section('content')
	
	@component('components.card', ['is_table' => true])
		@slot('corner')
			<a href="{{ route('customer.vehicles.failures.create', $vehicle) }}" class="btn-outline-gray flex items-center">
				<i class="icon fas fa-plus-circle mr-2"></i>
				Nuevo
			</a>
		@endslot
		
		<table >
		  <thead >
		    <tr >
		      <th>Tipo</th>
		      <th>Observaciones</th>
		      <th>Fecha</th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($failures as $failure)
		  	<tr >
		  	  <td>{{ $failure->type->name }}</td>
		  	  <td>{{ $failure->observations }}</td>
		  	  <td>{{ $failure->created_at }}</td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent
@endsection
