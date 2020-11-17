@extends('layouts.admin')

@section('title', 'Recambios')

@section('content')

	@component('components.search-card')
		@include('admin.spare_parts.search', ['route' => 'admin.spare-parts.index'])
	@endcomponent
	
	@component('components.card', ['is_table' => true])
		@slot('corner')
			<a href="{{ route('admin.spare-parts.create') }}" class="btn-outline-gray flex items-center">
				<i class="icon fas fa-plus-circle mr-2"></i>
				Nuevo
			</a>
		@endslot
		<table >
		  <thead >
		    <tr>
		      <th>Descripción</th>
		      <th>Marca</th>
		      <th>Referencia</th>
		      <th class="px-6 py-2 text-right">Precio</th>
		      <th>Gama</th>
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
		  	  <td>
		  	  	{{ optional($spare_part->vehicleManufacturer)->name }}
		  	  	{{ optional($spare_part->vehicleModel)->name }} - 
		  	  	{{ optional($spare_part->vehiclePlan)->name }}
		  	  </td>
		  	  <td>
		  	  	<div class="flex">
		  	  		<a href="{{ route('admin.spare-parts.edit', $spare_part) }}" class="mr-3">
		  	  			<i class="icon fas fa-edit"></i>
		  	  		</a>
		  	  		<form method="POST" onsubmit="return confirmDelete()" action="{{ route('admin.spare-parts.destroy', $spare_part) }}">
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

	{{ $spare_parts->appends(request()->query())->links() }}

@endsection
