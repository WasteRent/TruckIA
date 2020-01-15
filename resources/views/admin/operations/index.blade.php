@extends('layouts.admin')

@section('title', 'Operaciones')

@section('content')
	
	@component('components.search-card')
		@include('admin.operations.search')
	@endcomponent

	@component('components.card', ['is_table' => true])
		<div class="float-right my-2 mr-3">
			<a href="{{ route('admin.operations.create') }}" class="border px-4 py-1 rounded hover:bg-gray-100 shadow flex items-center">
				<i class="icon fas fa-plus-circle mr-2"></i>
				Nuevo
			</a>
		</div>
		<table class="table-auto w-full">
		  <thead class="uppercase text-xs font-bold tracking-wide">
		    <tr class="bg-gray-100 border-t border-b">
		      <td class="px-6 py-2">Código</td>
		      <td class="px-6 py-2">Descripción</td>
		      <td class="px-6 py-2">Tiempo (hrs)</td>
		      <td class="px-6 py-2"></td>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($operations as $operation)
		  	<tr class="border-t border-b text-gray-700">
		  	  <td class="px-6 py-2">
		  	  	<span class="uppercase">{{ $operation->code }}</span>
		  	  	<div class="flex items-center flex-wrap text-xs">
		  	  		<span>{{ $operation->vehicle_type }}</span>
		  	  		<i class="icon fas fa-angle-right text-gray-500 px-1"></i>
		  	  		<span>{{ $operation->subfamily->family->name }}</span>
		  	  		<i class="icon fas fa-angle-right text-gray-500 px-1"></i>
		  	  		<span>{{ $operation->subfamily->name }}</span>
		  	  	</div>
		  	  </td>
		  	  <td class="px-6 py-2">
		  	  	{{ $operation->name }}
		  	  	<p class="text-xs text-gray-600">{{ $operation->description }}</p>

		  	  	@if($operation->spareParts->count() > 0)
		  	  	<fieldset class="text-xs mt-4 border p-2 rounded">
		  	  		<legend class="mx-1 text-gray-600">Recambios</legend>
		  	  		<ul>
		  	  		@foreach($operation->sparePartsGrouped() as $spare_part)
		  	  			<li>
		  	  				@if($spare_part->units > 1)
		  	  					<span style="padding: 0.1rem;" class="bg-gray-300 text-gray-700 rounded-full">{{ $spare_part->units }}x</span>
		  	  				@endif
		  	  				{{ $spare_part->reference }} &middot; {{ $spare_part->description }}
		  	  			</li>
		  	  		@endforeach
		  	  		</ul>
		  	  	</fieldset>

		  	  	@endif

		  	  </td>
		  	  <td class="px-6 py-2">{{ $operation->time_in_hours }}</td>
		  	  <td class="px-6 py-2">
  	  		  	<a href="{{ route('admin.operations.spare-parts.index', $operation) }}" class="mr-3">
  	  	        	<i class="icon fas fa-wrench"></i>
  	  		  	</a>
		  	  	<a href="{{ route('admin.operations.edit', $operation) }}" class="mr-3">
		          	<i class="icon fas fa-edit"></i>
		  	  	</a>
		  	  	<form method="POST" onsubmit="return confirmDelete()" action="{{ route('admin.operations.destroy', $operation) }}">
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
