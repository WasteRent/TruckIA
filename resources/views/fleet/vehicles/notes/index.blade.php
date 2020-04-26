@extends('layouts.fleet')

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
@endsection
