@extends('layouts.admin')

@section('title', 'Modelos de ' . $manufacturer->name)

@section('content')
	
	@component('components.card', ['is_table' => true])
		<div class="float-right my-2 mr-3">
			<a href="{{ route('admin.manufacturers.models.create', $manufacturer) }}" class="btn-outline-gray flex items-center">
				<i class="icon fas fa-plus-circle mr-2"></i>
				Nuevo
			</a>
		</div>
		<table >
		  <thead >
		    <tr >
		      <th>Nombre</th>
		      <th>Categoría</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($models as $model)
		  	<tr >
		  	  <td>{{$model->name}}</td>
		  	  <td>
		  	  	@if($model->category == 'chassis')
		  	  		Chasis
		  	  	@elseif($model->category == 'equipment')
		  	  		Equipo
		  	  	@elseif($model->category == 'sweeper')
		  	  		Barredora
		  	  	@elseif($model->category == 'elevator')
		  	  		Elevador
		  	  	@endif
		  	  </td>
		  	  <td>
		  	  	<div class="flex">
		  	  		<a href="{{ route('admin.handbooks.index', $model) }}" class="text-indigo-600 hover:text-indigo-900 focus:outline-none focus:underline mr-3">Manuales</a>

		  	  		<a href="{{ route('admin.models.versions.index', $model) }}" class="mr-3">
		  	  			Den. com.
		  	  		</a>

		  	  		<a href="{{ route('admin.manufacturers.models.edit', [$manufacturer, $model]) }}" class="mr-3">
		  	  			<i class="icon fas fa-edit fa-lg"></i>
		  	  		</a>
		  	  		<form method="POST" onsubmit="return confirmDelete()" action="{{ route('admin.manufacturers.models.destroy', [$manufacturer, $model]) }}">
		  	  			@csrf
		  	  			@method('DELETE')
		  	  			<button><i class="icon fas fa-trash-alt fa-lg"></i></button>
		  	  		</form>
		  	  	</div>
		  	  </td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent
@endsection
