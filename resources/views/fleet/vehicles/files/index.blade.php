@extends('layouts.fleet')

@section('content')

	@include('fleet.vehicles.edit_tabs', ['active_files' => true])

	@component('components.card')
		@slot('title', 'Añadir archivo')
		@include('fleet.vehicles.files.create')
	@endcomponent

	<br><br>

	@if($vehicle->files->count() > 0)
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
			  	  <td>
			  	  	<a class="font-medium" target="_blank" href="{{$file->getLink()}}">
			  	  		{{$file->description}} ({{ $file->size }})
			  	  	</a>
			  	  </td>
			  	  <td>{{$file->created_at->format('d/m/Y H:i:s')}}</td>
			  	  <td>
			  	  	<div class="flex">
			  	  		<a target="_blank" href="{{$file->getLink()}}"  class="mr-4">
			  	  			<i class="icon fas fa-eye"></i>
			  	  		</a>
			  	  		<form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.vehicles.files.destroy', [$vehicle, $file]) }}">
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
	@endif
@endsection
