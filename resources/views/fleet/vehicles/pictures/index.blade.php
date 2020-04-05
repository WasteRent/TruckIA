@extends('layouts.fleet')

@section('content')

	@include('fleet.vehicles.edit_tabs', ['active_pictures' => true])


	@component('components.card')
		@slot('title', 'Añadir foto')
		@include('fleet.vehicles.pictures.create')
	@endcomponent

	<br><br>

	@component('components.card', ['is_table' => true])
		@slot('title', 'Fotos del vehículo')
		<table >
		  <thead >
		    <tr >
		      <th>Descripción</th>
		      <th>Fecha</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($vehicle->pictures as $file)
		  	<tr >
		  	  <td><img class="w-1/2" src="{{$file->getLink()}}"></td>
		  	  <td>{{$file->created_at->format('d/m/Y H:i:s')}}</td>
		  	  <td>
		  	  	<form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.vehicles.pictures.destroy', [$vehicle, $file]) }}">
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
