@extends('layouts.customer')

@section('title', 'Vehículos')

@section('content')
	@component('components.search-card')
		@include('customer.vehicles.search', ['route' => 'customer.vehicles.index'])
	@endcomponent

	@component('components.card', ['is_table' => true])
		<table>
		  <thead>
		    <tr>
		      <th>Matrícula</th>
		      <th>Chasis</th>
		      <th>Tipo</th>
		      <th>Kms</th>
		      <th>F. matriculación</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($vehicles as $vehicle)
		  	<tr>
		  	  <td>{{ $vehicle->plate }}</td>
		  	  <td>{{ $vehicle->chassis }}</td>
		  	  <td>
		  	  	{{ optional($vehicle->type)->name }}
		  	  </td>
		  	  <td>{{ $vehicle->kms }}</td>
		  	  <td>{{ Carbon\Carbon::parse($vehicle->registration_date)->format('d/m/Y') }}</td>
		  	  <td>
		  	  	<div class="flex">
		  	  		<a href="{{ route('customer.vehicles.show', $vehicle) }}"  class="mr-3">
		  	  			<i class="icon fas fa-eye"></i>
		  	  		</a>
		  	  	</div>
		  	  </td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent

	{{ $vehicles->appends(request()->query())->links() }}
@endsection
