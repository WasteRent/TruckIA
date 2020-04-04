@extends('layouts.admin')

@section('content')

	@include('admin.vehicles.edit_tabs', ['active_files' => true])

	@component('components.card')
		@slot('title', 'Añadir archivo')
		@include('admin.vehicles.files.create')
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
		  	<tr >
		  	  <td>{{$file->description}}</td>
		  	  <td>{{$file->created_at->format('d/m/Y H:i:s')}}</td>
		  	  <td>
		  	  	<div class="flex">
		  	  		<a target="_blank" href="{{$file->getLink()}}"  class="mr-4">
		  	  			<i class="icon fas fa-eye"></i>
		  	  		</a>
		  	  		<form method="POST" onsubmit="return confirmDelete()" action="{{ route('admin.vehicles.files.destroy', [$vehicle, $file]) }}">
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
