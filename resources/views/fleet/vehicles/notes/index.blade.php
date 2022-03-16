@extends('layouts.fleet')

@section('title', $vehicle->plate . ' ' . $vehicle->chassis)

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
			      <th>Nota</th>
			      <th>Usuario</th>
			      <th>Creado</th>
			    </tr>
			  </thead>
			  <tbody>
			  	@foreach($vehicle->notes->sortByDesc('created_at') as $note)
			  	<tr>
			  	  <td>
			  	  	{!! $note->note !!}
			  	  </td>
			  	  <td>{{ $note->user->name }}</td>
			  	  <td title="{{ $note->created_at->diffForHumans() }}">{{ $note->created_at->format('d/m/Y H:i:s') }}</td>
			  	</tr>
			  	@endforeach
			  </tbody>
			</table>
		@endcomponent
	@endif
@endsection
