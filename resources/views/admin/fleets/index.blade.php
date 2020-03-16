@extends('layouts.admin')

@section('title', 'Flotas')

@section('content')
	
	@component('components.card', ['is_table' => true])
		@slot('corner')
			<a href="{{ route('admin.fleets.create') }}" class="border px-4 py-1 rounded hover:bg-gray-100 shadow flex items-center">
				<i class="icon fas fa-plus-circle mr-2"></i>
				Nuevo
			</a>
		@endslot
		
		<table class="table-auto w-full">
		  <thead class="uppercase text-xs font-bold tracking-wide">
		    <tr class="bg-gray-100 border-t border-b">
		      <td class="px-6 py-2">Nombre</td>
		      <td class="px-6 py-2"></td>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($fleets as $fleet)
		  	<tr class="border-t border-b text-gray-700">
		  	  <td class="px-6 py-2">
		  	  	<div class="flex items-center">
		  	  		<img class="w-24 mr-3" src="{{$fleet->logo}}">
		  	  		{{$fleet->name}}
		  	  	</div>
		  	  </td>
		  	  <td class="px-6 py-2 flex">
		  	  	<a href="{{ route('admin.fleets.edit', $fleet) }}" class="mr-3">
		  	  		<i class="icon fas fa-edit"></i>
		  	  	</a>
		  	  	<form method="POST" onsubmit="return confirmDelete()" action="{{ route('admin.fleets.destroy', $fleet) }}">
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
