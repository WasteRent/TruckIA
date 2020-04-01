@extends('layouts.admin')

@section('title', 'Archivos del vehículo')

@section('content')

	@include('admin.vehicles.edit_tabs', ['active_files' => true])

	@component('components.card')
		@slot('title', 'Añadir archivo')
		@include('admin.vehicles.files.create')
	@endcomponent

	<br><br>

	@component('components.card', ['is_table' => true])
		@slot('title', 'Archivos del vehículo')
		<table class="table-auto w-full">
		  <thead class="uppercase text-xs font-bold tracking-wide">
		    <tr class="bg-gray-100 border-t border-b">
		      <td class="px-6 py-2">Descripción</td>
		      <td class="px-6 py-2">Fecha</td>
		      <td class="px-6 py-2"></td>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($vehicle->files as $file)
		  	<tr class="border-t border-b text-gray-700">
		  	  <td class="px-6 py-2">{{$file->description}}</td>
		  	  <td class="px-6 py-2">{{$file->created_at->format('d/m/Y H:i:s')}}</td>
		  	  <td class="px-6 py-2 flex">
		  	  	<a target="_blank" href="{{$file->getLink()}}"  class="mr-4">
		  	  		<i class="icon fas fa-eye"></i>
		  	  	</a>
		  	  	<form method="POST" onsubmit="return confirmDelete()" action="{{ route('admin.vehicles.files.destroy', [$vehicle, $file]) }}">
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
