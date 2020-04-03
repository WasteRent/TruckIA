@extends('layouts.admin')

@section('content')

	@include('admin.vehicles.edit_tabs', ['active_notes' => true])

	@component('components.card')
		@slot('title', 'Añadir Nota')
		@include('admin.vehicles.notes.create')
	@endcomponent

	<br><br>

	@component('components.card', ['is_table' => true])
		@slot('title', 'Notas del vehículo')
		<table >
		  <thead >
		    <tr >
		      <td>Nota</td>
		      <td>Fecha</td>
		      <td></td>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($vehicle->notes as $note)
		  	<tr >
		  	  <td>{{$note->note}}</td>
		  	  <td title="{{ $note->created_at->format('d/m/Y H:i:s') }}">{{ $note->created_at->diffForHumans() }}</td>
		  	  <td class="px-6 py-2 flex">
		  	  	<form method="POST" onsubmit="return confirmDelete()" action="{{ route('admin.vehicles.notes.destroy', [$vehicle, $note]) }}">
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
