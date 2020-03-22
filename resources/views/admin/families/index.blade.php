@extends('layouts.admin')

@section('title', 'Familias')

@section('content')
	
	@component('components.card', ['is_table' => true])
		@slot('corner')
			<a href="{{ route('admin.families.create') }}" class="border px-4 py-1 rounded hover:bg-gray-100 shadow flex items-center">
				<i class="icon fas fa-plus-circle mr-2"></i>
				Nuevo
			</a>
		@endslot

		<table>
		  <thead>
		    <tr>
		      <th>Nombre</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($families as $family)
		  	<tr>
		  	  <td>{{$family->name}}</td>
		  	  <td class="flex">
		  	  	<a href="{{ route('admin.families.subfamilies.index', $family) }}" class="mr-3">
		  	  		Subfamilias
		  	  	</a>
		  	  	<a href="{{ route('admin.families.edit', $family) }}" class="mr-3">
		  	  		<i class="icon fas fa-edit"></i>
		  	  	</a>
		  	  	<form method="POST" onsubmit="return confirmDelete()" action="{{ route('admin.families.destroy', $family) }}">
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
