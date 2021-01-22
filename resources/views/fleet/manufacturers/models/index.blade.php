@extends('layouts.fleet')

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
		  	  </td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent
@endsection
