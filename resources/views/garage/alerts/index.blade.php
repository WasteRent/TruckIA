@extends('layouts.garage')

@section('title', 'Alertas')

@section('content')
	@component('components.card', ['is_table' => true])
		<table >
		  <thead >
		    <tr >
		      <td>Matrícula</td>
		      <td>Vehículo</td>
		      <td>Alerta</td>
		      <td>Descripción</td>
		      <td>Fecha</td>
		      <td></td>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($alerts as $alert)
		  	<tr >
		  	  <td>{{ $alert->vehicle->plate }}</td>
		  	  <td>{{ $alert->vehicle->fullname }}</td>
		  	  <td>{{ $alert->title }}</td>
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
