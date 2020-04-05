@extends('layouts.fleet')

@section('title', 'Modelos de ' . $manufacturer->name)

@section('content')
	
	@component('components.card', ['is_table' => true])
		<div class="float-right my-2 mr-3">
			<a href="{{ route('fleet.manufacturers.models.create', $manufacturer) }}" class="btn-outline-gray flex items-center">
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
		  	@foreach($models as $model)
		  	<tr >
		  	  <td>{{$model->name}}</td>
		  	  <td>
		  	  	<div class="flex">
		  	  		<a href="{{ route('fleet.manufacturers.models.edit', [$manufacturer, $model]) }}" class="mr-3">
		  	  			<i class="icon fas fa-edit"></i>
		  	  		</a>
		  	  		<form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.manufacturers.models.destroy', [$manufacturer, $model]) }}">
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
