@extends('layouts.admin')

@section('title', 'Flotas')

@section('content')
	
	@component('components.card', ['is_table' => true])
		@slot('corner')
			<a href="{{ route('admin.fleets.create') }}" class="btn-outline-gray flex items-center">
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
		  	@foreach($fleets as $fleet)
		  	<tr>
		  	  <td>
		  	  	<div class="flex items-center">
		  	  		<img class="w-24 mr-3" src="{{$fleet->logo}}">
		  	  		{{$fleet->name}}
		  	  	</div>
		  	  </td>
		  	  <td>
		  	  	<div class="flex">
		  	  		<a href="{{ route('admin.fleets.edit', $fleet) }}" class="mr-3">
		  	  			<i class="icon fas fa-edit"></i>
		  	  		</a>
		  	  		<form method="POST" onsubmit="return confirmDelete()" action="{{ route('admin.fleets.destroy', $fleet) }}">
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
