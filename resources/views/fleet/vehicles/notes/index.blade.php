@extends('layouts.fleet')

@section('title', $vehicle->plate . '  &middot;  ' . $vehicle->chassis)

@section('content')

	@include('fleet.vehicles.edit_tabs', ['active_notes' => true])

	@component('components.card', ['compressed' => true])
		@slot('title', 'Añadir Nota')
		@include('fleet.vehicles.notes.create')
	@endcomponent

	<br><br>

	@if($vehicle->notes->count() > 0)
		@component('components.card', ['is_table' => true])
			@slot('title', 'Notas del vehículo')
			<table >
			  <thead >
			    <tr >
			      <th></th>
			      <th>Nota</th>
			      <th>Fecha</th>
			      <th></th>
			    </tr>
			  </thead>
			  <tbody>
			  	@foreach($vehicle->notes as $note)
			  	<tr>
			  	  <td>{{ $note->user->name }}</td>
			  	  <td>{{$note->note}}</td>
			  	  <td title="{{ $note->created_at->format('d/m/Y H:i:s') }}">{{ $note->created_at->diffForHumans() }}</td>
			  	  <td>
			  	  	<form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.vehicles.notes.destroy', [$vehicle, $note]) }}">
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
	@endif

	@component('components.card', ['compressed' => true])
		@slot('title', 'Añadir Incidencia')
		@include('fleet.vehicles.notes.incidents.create')
	@endcomponent

	@if($vehicle->incidents->count() > 0)
		@component('components.card', ['is_table' => true])
			@slot('title', 'Incidencias del vehículo')
			<table >
			  <thead >
			    <tr >
			      <th></th>
			      <th>Incidencia</th>
			      <th>Fecha</th>
			      <th></th>
			    </tr>
			  </thead>
			  <tbody>
			  	@foreach($vehicle->incidents as $incidence)
			  	<tr>
			  	  <td>{{ $incidence->user->name }}</td>
			  	  <td>{{$incidence->incidence}}</td>
			  	  <td title="{{ $incidence->created_at->format('d/m/Y H:i:s') }}">{{ $incidence->created_at->diffForHumans() }}</td>
			  	  <td>
			  	  	<form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.vehicles.incidents.destroy', [$vehicle, $incidence]) }}">
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
	@endif
@endsection
