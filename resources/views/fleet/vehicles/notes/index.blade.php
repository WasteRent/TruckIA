@extends('layouts.fleet')

@section('title', $vehicle->plate . ' ' . $vehicle->chassis)

@section('content')

	@include('fleet.vehicles.edit_tabs', ['active_notes' => true])

	@component('components.card', ['compressed' => true])
		@slot('title', __('Añadir nota'))
		@include('fleet.vehicles.notes.create')
	@endcomponent

	<br><br>

	@if($vehicle->notes->count() > 0)
		@component('components.card', ['is_table' => true])
			@slot('title', __('Notas del vehículo'))
			<table >
			  <thead >
			    <tr >
			      <th>{{ __('Nota') }}</th>
			      <th>{{ __('Usuario') }}</th>
			      <th>{{ __('Creado') }}</th>
			      <th></th>
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
			  	  <td>
			  	  	@if($note->user->id == auth()->user()->id || auth()->user()->job == 'fleet_manager' || auth()->user()->job == 'zone_administrator')
						<div class="flex gap-4">
							<a href="{{ route('fleet.vehicles.notes.edit', [$vehicle, $note]) }}"><i class="icon fas fa-pencil-alt"></i></a>
			  	  			<form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.vehicles.notes.destroy', [$vehicle, $note]) }}">
			  	  				@csrf
			  	  				@method('DELETE')
			  	  				<button><i class="icon fas fa-trash-alt"></i></button>
			  	  			</form>
			  	  		</div>
			  	  	@endif
			  	  </td>
			  	</tr>
			  	@endforeach
			  </tbody>
			</table>
		@endcomponent
	@endif
@endsection
