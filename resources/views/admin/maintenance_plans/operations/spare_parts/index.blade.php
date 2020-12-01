@extends('layouts.admin')

@section('title', $operation->plan->name . ' ' . optional($operation->plan->manufacturer)->name .' '. optional($operation->plan->model)->name . ' > Operaciones > ' . $operation->name)

@section('content')
	
	<div class="mb-4">
		<a href="{{ route('admin.maintenance-plans.operations.index', $operation->plan) }}"><i class="fas fa-arrow-alt-circle-left fa-lg text-indigo-600"></i></a>
	</div>
	
	@component('components.card', ['is_table' => true])
		@slot('title', 'Recambios')
		@slot('corner')
			<a href="{{ route('admin.maintenance-plans-operation.spare-parts.create', $operation) }}" class="btn-outline-gray flex items-center">
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
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($operation->parts as $spare_part)
		  	<tr >
		  	  <td>{{ $spare_part->description }}</td>
		  	  <td>{{ $spare_part->manufacturer }}</td>
		  	  <td>{{ $spare_part->reference }}</td>
		  	  <td class="text-right">{{ $spare_part->getFormattedPrice() }}</td>
		  	  <td>
		  	  	<div class="flex">
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

@endsection
