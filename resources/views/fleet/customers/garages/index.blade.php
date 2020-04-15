@extends('layouts.fleet')

@section('title', $customer->name)

@section('content')

	@include('fleet.customers.tabs', ['active_garages' => true])

	@component('components.search-card')
		@include('fleet.garages.search', ['route' => ['fleet.customers.garages.index', $customer]])
	@endcomponent

	@if(count($garages_search) > 0)
		@component('components.card', ['is_table' => true])
			@slot('title', 'Seleccionar taller')
			<table>
			  <thead>
			    <tr>
			      <th>Nombre</th>
			      <th>Email</th>
			      <th>Tel.</th>
			      <th>Dirección</th>
			      <th></th>
			      <th></th>
			    </tr>
			  </thead>
			  <tbody>
			  	@foreach($garages_search as $garage)
			  	<tr >
			  	  <td>{{$garage->name}}</td>
			  	  <td>{{$garage->email}}</td>
			  	  <td>{{$garage->phone}}</td>
			  	  <td>{{$garage->full_address}}</td>
			  	  <td>@include('shared.garages.specs')</td>
			  	  <td>
		  	  		<form method="POST" action="{{ route('fleet.customers.garages.store', $customer) }}">
		  	  			@csrf
		  	  			<input type="hidden" name="garage_id" value="{{$garage->id}}">
		  	  			<button><i class="icon fas fa-plus-circle"></i></button>
		  	  		</form>
			  	  </td>
			  	</tr>
			  	@endforeach
			  </tbody>
			</table>
		@endcomponent
	@endif

	<br><br>

	@if($customer->garages->count() > 0)
		@component('components.card', ['is_table' => true])
			@slot('title', 'Talleres asignados')
			<table >
			  <thead >
			    <tr >
			      <th>Nombre</th>
			      <th>Email</th>
			      <th>Tel.</th>
			      <th>Dirección</th>
			      <th>Especialidades</th>
			      <th></th>
			    </tr>
			  </thead>
			  <tbody>
			  	@foreach($customer->garages as $garage)
			  	<tr >
			  	  <td>{{$garage->name}} </td>
			  	  <td>{{$garage->email}}</td>
			  	  <td>{{$garage->phone}}</td>
			  	  <td>{{$garage->full_address}}</td>
			  	  <td>@include('shared.garages.specs')</td>
			  	  <td>
			  	  	<form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.customers.garages.destroy', [$customer, $garage]) }}">
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
