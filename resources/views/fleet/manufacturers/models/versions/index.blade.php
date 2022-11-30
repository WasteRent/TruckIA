@extends('layouts.fleet')

@section('title', 'Den. com de - ' . $manufacturer->name . ' ' . $model->name)

@section('content')
	
	@component('components.card', ['is_table' => true])
		<div class="float-right my-2 mr-3">
			<a href="{{ route('fleet.models.versions.create', $model) }}" class="btn-outline-gray flex items-center">
				<i class="icon fas fa-plus-circle mr-2"></i>
				Nuevo
			</a>
		</div>
		<table >
		  <thead >
		    <tr >
		      <th>Nombre</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($versions as $version)
		  	<tr >
		  	  <td>{{$version->name}}</td>
		  	  <td>
		  	  	<div class="flex">
		  	  		@if(auth()->id() == 928)
		  	  		<a href="{{ route('fleet.models.versions.edit', [$model, $version]) }}" class="mr-3">
		  	  			<i class="icon fas fa-edit fa-lg"></i>
		  	  		</a>
		  	  		@endif
		  	  	</div>
		  	  </td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent
@endsection
