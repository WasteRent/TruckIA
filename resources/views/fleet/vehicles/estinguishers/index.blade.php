@extends('layouts.fleet')

@section('title', $vehicle->plate . ' ' . $vehicle->chassis)

@section('content')
	
	@include('fleet.vehicles.edit_tabs', ['active_estinguishers' => true])


	@component('components.card', ['is_table' => true])
		@slot('corner')
			<a href="{{ route('fleet.vehicles.estinguishers.create', $vehicle) }}" class="btn-outline-gray flex items-center">
				<i class="icon fas fa-plus-circle mr-2"></i>
				{{ __('Nuevo') }}
			</a>
		@endslot
		<table>
		  <thead>
		    <tr>
		      <th>{{ __('Nombre') }}</th>
		      <th>{{ __('Código') }}</th>
		      <th>{{ __('Expira') }}</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($vehicle->estinguishers as $estinguisher)
		  	<tr>
		  	  <td>{{$estinguisher->name}}</td>
		  	  <td>{{$estinguisher->code}}</td>
		  	  <td>{{ Carbon\Carbon::parse($estinguisher->expiration_date)->format('d/m/Y') }}</td>
		  	  <td>
		  	  	<div class="flex">
		  	  		<a href="{{ route('fleet.vehicles.estinguishers.edit', [$vehicle, $estinguisher]) }}" class="mr-3">
		  	  			<i class="icon fas fa-edit"></i>
		  	  		</a>
		  	  		<form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.vehicles.estinguishers.destroy', [$vehicle, $estinguisher]) }}">
		  	  			@csrf
		  	  			@method('DELETE')
		  	  			<button><i class="icon fas fa-trash-alt"></i></button>
		  	  		</form>
		  	  	</div>
		  	  </td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent

@endsection
