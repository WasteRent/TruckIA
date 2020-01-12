@extends('layouts.admin')

@section('title', 'Marcas')

@section('content')
	
	@component('components.card', ['is_table' => true])
		<div class="float-right my-2 mr-3">
			<a href="{{ route('admin.manufacturers.create') }}" class="border px-4 py-1 rounded hover:bg-gray-100 shadow flex items-center">
				<i class="icon fas fa-plus-circle mr-2"></i>
				Nuevo
			</a>
		</div>
		<table class="table-auto w-full">
		  <thead class="uppercase text-xs font-bold tracking-wide">
		    <tr class="bg-gray-100 border-t border-b">
		      <td class="px-6 py-2">Nombre</td>
		      <td class="px-6 py-2"></td>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($manufacturers as $manufacturer)
		  	<tr class="border-t border-b text-gray-700">
		  	  <td class="px-6 py-2">{{$manufacturer->name}}</td>
		  	  <td class="px-6 py-2 flex">
		  	  	<a href="{{ route('admin.manufacturers.models.index', $manufacturer) }}" class="mr-3">
		  	  		Modelos
		  	  	</a>
		  	  	<a href="{{ route('admin.manufacturers.edit', $manufacturer) }}" class="mr-3">
		  	  		<i class="icon fas fa-edit"></i>
		  	  	</a>
		  	  	<form onsubmit="return confirmDelete()" method="POST" action="{{ route('admin.manufacturers.destroy', $manufacturer) }}">
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
