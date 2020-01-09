@extends('layouts.admin')

@section('title', 'Subfamilias de ' . $family->name)

@section('content')
	
	@component('components.card', ['is_table' => true])
		<div class="float-right my-2 mr-3">
			<a href="{{ route('admin.families.subfamilies.create', $family) }}" class="border px-4 py-1 rounded hover:bg-gray-100 shadow flex items-center">
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
		  	@foreach($subfamilies as $subfamily)
		  	<tr class="border-t border-b text-gray-700">
		  	  <td class="px-6 py-2">{{$subfamily->name}}</td>
		  	  <td class="px-6 py-2 flex">
		  	  	<a href="{{ route('admin.families.subfamilies.edit', [$family, $subfamily]) }}" class="mr-2">
		  	  		<i class="icon fas fa-edit"></i>
		  	  	</a>
		  	  </td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent
@endsection
