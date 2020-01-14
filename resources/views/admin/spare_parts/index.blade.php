@extends('layouts.admin')

@section('title', 'Recambios')

@section('content')

	@component('components.search-card')
		@include('admin.spare_parts.search', ['route' => 'admin.spare-parts.index'])
	@endcomponent
	
	@component('components.card', ['is_table' => true])
		<div class="float-right my-2 mr-3">
			<a href="{{ route('admin.spare-parts.create') }}" class="border px-4 py-1 rounded hover:bg-gray-100 shadow flex items-center">
				<i class="icon fas fa-plus-circle mr-2"></i>
				Nuevo
			</a>
		</div>
		<table class="table-auto w-full">
		  <thead class="uppercase text-xs font-bold tracking-wide">
		    <tr class="bg-gray-100 border-t border-b">
		      <td class="px-6 py-2">Referencia</td>
		      <td class="px-6 py-2">Descripción</td>
		      <td class="px-6 py-2 text-right">Precio</td>
		      <td class="px-6 py-2"></td>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($spare_parts as $spare_part)
		  	<tr class="border-t border-b text-gray-700">
		  	  <td class="px-6 py-2">{{ $spare_part->reference }}</td>
		  	  <td class="px-6 py-2">{{ $spare_part->description }}</td>
		  	  <td class="px-6 py-2 text-right">{{ $spare_part->getFormattedPrice() }}</td>
		  	  <td class="px-6 py-2 flex">
		  	  	<a href="{{ route('admin.spare-parts.edit', $spare_part) }}" class="mr-3">
		  	  		<i class="icon fas fa-edit"></i>
		  	  	</a>
		  	  	<form method="POST" onsubmit="return confirmDelete()" action="{{ route('admin.spare-parts.destroy', $spare_part) }}">
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

	{{ $spare_parts->appends(request()->query())->links() }}

@endsection
