@extends('layouts.fleet')

@section('title', 'Marcas')

@section('content')

	@component('components.search-card')
		@include('fleet.manufacturers.search')
	@endcomponent
	
	@component('components.card', ['is_table' => true])
		@slot('corner')
			<a href="{{ route('fleet.manufacturers.create') }}" class="btn-outline-gray flex items-center">
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
		  	@foreach($manufacturers as $manufacturer)
		  	<tr >
		  	  <td>{{$manufacturer->name}}</td>
		  	  <td>
		  	  	<div class="flex">
		  	  		<a href="{{ route('fleet.manufacturers.models.index', $manufacturer) }}" class="mr-3">
		  	  			Modelos
		  	  		</a>
		  	  	</div>
		  	  </td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent
@endsection
