@extends('layouts.fleet')

@section('title', $vehicle->plate . '  &middot;  ' . $vehicle->chassis)

@section('content')

	@include('fleet.vehicles.edit_tabs', ['active_files' => true])

	@component('components.card', ['compressed' => true])
		@slot('title', 'Añadir archivo')
		@include('fleet.vehicles.files.create')
	@endcomponent

	<br><br>

	@component('components.card', ['is_table' => true])
		@slot('title', 'Archivos del vehículo')
		<table >
		  <thead >
		    <tr >
		      <th>Descripción</th>
		      <th>Fecha</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($vehicle->files as $file)
		  	<tr>
		  	  <td>
		  	  	<a class="font-medium" target="_blank" href="{{$file->getLink()}}">
		  	  		{{$file->description}} ({{ $file->size }})
		  	  	</a>
		  	  </td>
		  	  <td>{{$file->created_at->format('d/m/Y H:i:s')}}</td>
		  	  <td>
		  	  	<div class="flex">
		  	  		<a target="_blank" href="{{$file->getLink()}}"  class="mr-4">
		  	  			<i class="icon fas fa-eye fa-lg"></i>
		  	  		</a>
		  	  		<form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.vehicles.files.destroy', [$vehicle, $file]) }}">
		  	  			@csrf
		  	  			@method('DELETE')
		  	  			<button><i class="icon fas fa-trash-alt fa-lg"></i></button>
		  	  		</form>
		  	  	</div>
		  	  </td>
		  	</tr>
		  	@endforeach

		  	@foreach($vehicle_models as $model)
			  	@if($model->technicalHandbook)
			  	<tr>
			  	  <td>
			  	  	<a class="font-medium" target="_blank" href="{{$model->technicalHandbook->getLink()}}">
			  	  		Manual Técnico {{$model->manufacturer->name}} {{$model->name}}  ({{ $model->technicalHandbook->size }})
			  	  	</a>
			  	  </td>
			  	  <td>{{$model->technicalHandbook->created_at->format('d/m/Y H:i:s')}}</td>
			  	  <td>
			  	  	<div class="flex">
			  	  		<a target="_blank" href="{{$model->technicalHandbook->getLink()}}"  class="mr-4">
			  	  			<i class="icon fas fa-eye"></i>
			  	  		</a>
			  	  	</div>
			  	  </td>
			  	</tr>
			  	@endif
			  	@if($model->usageHandbook)
			  	<tr>
			  	  <td>
			  	  	<a class="font-medium" target="_blank" href="{{$model->usageHandbook->getLink()}}">
			  	  		Manual de Uso {{$model->manufacturer->name}} {{$model->name}} ({{ $model->usageHandbook->size }})
			  	  	</a>
			  	  </td>
			  	  <td>{{$model->usageHandbook->created_at->format('d/m/Y H:i:s')}}</td>
			  	  <td>
			  	  	<div class="flex">
			  	  		<a target="_blank" href="{{$model->usageHandbook->getLink()}}"  class="mr-4">
			  	  			<i class="icon fas fa-eye"></i>
			  	  		</a>
			  	  	</div>
			  	  </td>
			  	</tr>
			  	@endif
		  	@endforeach

		  </tbody>
		</table>
	@endcomponent
@endsection
