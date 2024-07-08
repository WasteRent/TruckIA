@extends('layouts.fleet')

@section('title', __('Tipos de vehículo'))

@section('content')

	@component('components.card', ['is_table' => true])
		@slot('corner')
			<a href="{{ route('fleet.vehicle-types.create') }}" class="btn-outline-gray flex items-center">
				<i class="icon fas fa-plus-circle mr-2"></i>
				Nuevo
			</a>
		@endslot

		<table >
		  <thead >
		    <tr >
		      <th>Nombre</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($vehicle_types as $vehicle_type)
		  	<tr >
		  	  <td>{{$vehicle_type->name}}</td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent
@endsection
