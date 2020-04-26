@extends('layouts.fleet')

@section('content')

	@include('fleet.vehicles.edit_tabs', ['active_pictures' => true])


	@component('components.card', ['compressed' => true])
		@slot('title', 'Añadir foto')
		@include('fleet.vehicles.pictures.create')
	@endcomponent

	<br><br>

	@if($vehicle->pictures->count() > 0)
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
			  	@foreach($vehicle->pictures->sortByDesc('pivot.cover') as $file)
			  	<tr >
			  	  <td>
			  	  	<a target="_blank" href="{{$file->getLink()}}">
			  	  		<img class="w-1/2" src="{{$file->getLink()}}">
			  	  	</a>
			  	  </td>
			  	  <td>{{$file->created_at->format('d/m/Y H:i:s')}}</td>
			  	  <td>
			  	  	@if(!$file->pivot->cover)
			  	  	<form method="POST" action="{{ route('fleet.vehicles.pictures.update', [$vehicle, $file]) }}">
			  	  		@csrf
			  	  		@method('PUT')
			  	  		<input type="hidden" name="cover" value="1">
			  	  		<button class="text-indigo-600 hover:text-indigo-900 focus:outline-none focus:underline">Portada</button>
			  	  	</form>
			  	  	@endif

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
	@endif
@endsection
