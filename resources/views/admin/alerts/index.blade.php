@extends('layouts.admin')

@section('title', 'Alertas')

@section('content')
	@component('components.card', ['is_table' => true])
		<table>
		  <thead>
		    <tr>
		      <th>Matrícula</th>
		      <th>Vehículo</th>
		      <th>Alerta</th>
		      <th>Fecha</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($alerts as $alert)
		  	<tr>
		  	  <td>{{ $alert->vehicle->plate }}</td>
		  	  <td>{{ $alert->vehicle->chassis }} {{ $alert->vehicle->box }}</td>
		  	  <td>{{ $alert->description }}</td>
		  	  <td>{{ $alert->created_at->format('d/m/Y H:i:s') }}</td>
		  	  <td>
		  	  </td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent
@endsection
