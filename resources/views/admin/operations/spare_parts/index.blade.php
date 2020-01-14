@extends('layouts.admin')

@section('title', $operation->code . ' ' . $operation->name . ': Recambios')

@section('content')

	@component('components.search-card')
		@include('admin.operations.spare_parts.search')
	@endcomponent

	@if(isset($spare_parts_search))
		@component('components.card', ['title' => 'Resultados de la busqueda...', 'is_table' => true])
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
			  	@foreach($spare_parts_search as $spare_part)
			  	<tr class="border-t border-b text-gray-700">
			  	  <td class="px-6 py-2">{{ $spare_part->reference }}</td>
			  	  <td class="px-6 py-2">{{ $spare_part->description }}</td>
			  	  <td class="px-6 py-2 text-right">{{ $spare_part->getFormattedPrice() }}</td>
			  	  <td class="px-6 py-2">
			  	  	<form method="POST" action="{{ route('admin.operations.spare-parts.store', $operation) }}">
			  	  		@csrf
			  	  		<input type="hidden" name="spare_part_id" value="{{$spare_part->id}}">
			  	  		<button><i class="icon fas fa-plus-circle"></i></button>
			  	  	</form>
			  	  </td>
			  	</tr>
			  	@endforeach
			  </tbody>
			</table>
		@endcomponent
	@endif

	<div class="py-6"></div>


	@component('components.card', ['is_table' => true])
		<div class="border-b py-4 px-6 font-bold">
			Recambios asociados
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
		  	  <td class="px-6 py-2">
		  	  	{{ $spare_part->reference }}
		  	  	@if($spare_part->units > 1)
		  	  		<span class="text-sm p-1 bg-gray-300 text-gray-700 rounded-full">{{ $spare_part->units }}x</span>
		  	  	@endif
		  	  </td>
		  	  <td class="px-6 py-2">{{ $spare_part->description }}</td>
		  	  <td class="px-6 py-2 text-right">{{ $spare_part->getFormattedPrice() }}</td>
		  	  <td class="px-6 py-2">
		  	  	<form method="POST" onsubmit="return confirmDelete()" action="{{ route('admin.operations.spare-parts.destroy', [$operation, $spare_part]) }}">
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
