@extends('layouts.fleet')

@section('title', 'Marcas')

@section('content')

	@component('components.search-card')
		@include('fleet.manufacturers.search')
	@endcomponent
	
	@component('components.card', ['is_table' => true])		
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
		  	  		<a href="{{ route('fleet.manufacturers.edit', $manufacturer) }}" class="mr-3">
		  	  			<i class="icon fas fa-edit fa-lg"></i>
		  	  		</a>
		  	  	</div>
		  	  </td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent
@endsection
