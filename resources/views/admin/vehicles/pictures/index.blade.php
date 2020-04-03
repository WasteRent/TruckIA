@extends('layouts.admin')

@section('content')

	@include('admin.vehicles.edit_tabs', ['active_pictures' => true])


	@component('components.card')
		@slot('title', 'Añadir foto')
		@include('admin.vehicles.pictures.create')
	@endcomponent

	<br><br>

	@component('components.card', ['is_table' => true])
		@slot('title', 'Fotos del vehículo')
		<table >
		  <thead >
		    <tr >
		      <td>Descripción</td>
		      <td>Fecha</td>
		      <td></td>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($vehicle->pictures as $file)
		  	<tr >
		  	  <td><img class="w-1/2" src="{{$file->getLink()}}"></td>
		  	  <td>{{$file->created_at->format('d/m/Y H:i:s')}}</td>
		  	  <td class="px-6 py-2 flex">
		  	  	<form method="POST" onsubmit="return confirmDelete()" action="{{ route('admin.vehicles.pictures.destroy', [$vehicle, $file]) }}">
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
