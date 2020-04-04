@extends('layouts.admin')

@section('content')

	@include('admin.vehicles.edit_tabs', ['active_garages' => true])

	@component('components.search-card')
		@include('admin.garages.search', ['route' => ['admin.vehicles.garages.index', $vehicle]])
	@endcomponent

	@if(count($garages_search) > 0)
		@component('components.card', ['is_table' => true])
			@slot('title', 'Seleccionar taller')

			<table >
			  <thead >
			    <tr >
			      <td>Nombre</td>
			      <td>Email</td>
			      <td>Tel.</td>
			      <td>Dirección</td>
			      <td></td>
			      <td></td>
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
		  	  		<form method="POST" action="{{ route('admin.vehicles.garages.store', $vehicle) }}">
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
		  	@foreach($garages as $garage)
		  	<tr >
		  	  <td>{{$garage->name}} </td>
		  	  <td>{{$garage->email}}</td>
		  	  <td>{{$garage->phone}}</td>
		  	  <td>{{$garage->full_address}}</td>
		  	  <td>@include('shared.garages.specs')</td>
		  	  <td>
		  	  	<form method="POST" onsubmit="return confirmDelete()" action="{{ route('admin.vehicles.garages.destroy', [$vehicle, $garage]) }}">
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
