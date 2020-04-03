@extends('layouts.admin')

@section('title', 'Subfamilias de ' . $family->name)

@section('content')
	
	@component('components.card', ['is_table' => true])
		<div class="float-right my-2 mr-3">
			<a href="{{ route('admin.families.subfamilies.create', $family) }}" class="btn-outline-gray flex items-center">
				<i class="icon fas fa-plus-circle mr-2"></i>
				Nuevo
			</a>
		</div>
		<table>
		  <thead>
		    <tr>
		      <th>Nombre</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($subfamilies as $subfamily)
		  	<tr>
		  	  <td>{{$subfamily->name}}</td>
		  	  <td class="flex">
		  	  	<a href="{{ route('admin.families.subfamilies.edit', [$family, $subfamily]) }}" class="mr-3">
		  	  		<i class="icon fas fa-edit"></i>
		  	  	</a>
		  	  	<form method="POST" onsubmit="return confirmDelete()" action="{{ route('admin.families.subfamilies.destroy', [$family, $subfamily]) }}">
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
