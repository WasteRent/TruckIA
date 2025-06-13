@extends('layouts.fleet')

@section('title', 'Recambios')

@section('content')

	@component('components.search-card')
		@include('fleet.spare_parts.search', ['route' => 'fleet.spare-parts.index'])
	@endcomponent
	
	@component('components.card', ['is_table' => true])
		@slot('corner')
			<a class="mr-4 text-green-600" href="{{ route('fleet.export.spare-parts', request()->query()) }}"><i class="fas fa-lg fa-file-excel"></i></a>
			<a href="{{ route('fleet.import-spare-parts.create') }}" class="btn-outline-gray flex items-center">
				<i class="fas fa-upload mr-2"></i>
				{{ __('Importar') }}
			</a>
			<a href="{{ route('fleet.spare-parts.create') }}" class="btn-outline-gray flex items-center">
				<i class="icon fas fa-plus-circle mr-2"></i>
				{{ __('Nuevo') }}
			</a>
		@endslot
		<table >
		  <thead >
		    <tr>
		      <th>Descripción</th>
		      <th>Marca</th>
		      <th>Referencia</th>
		      <th class="px-6 py-2 text-right">Precio</th>
			  <th>Stock</th>
			  <th>Centro</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($spare_parts as $spare_part)
		  	<tr >
		  	  <td>{{ $spare_part->description }}</td>
		  	  <td>{{ $spare_part->manufacturer }}</td>
		  	  <td>{{ $spare_part->reference }}</td>
		  	  <td class="text-right">{{ $spare_part->getFormattedPrice() }}</td>
			  <td>{{ $spare_part->stock }}</td>
			  <td>{{ $spare_part->customer?->name }}</td>
			  @if(auth()->user()->job == 'fleet_manager')
		  	  <td>
		  	  	<div class="flex">
		  	  		<a href="{{ route('fleet.spare-parts.edit', $spare_part) }}" class="mr-3">
		  	  			<i class="icon fas fa-edit"></i>
		  	  		</a>
		  	  		<form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.spare-parts.destroy', $spare_part) }}">
		  	  			@csrf
		  	  			@method('DELETE')
		  	  			<button><i class="icon fas fa-trash-alt"></i></button>
		  	  		</form>
		  	  	</div>
		  	  </td>
			  @endif
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent

	{{ $spare_parts->appends(request()->query())->links() }}

@endsection
