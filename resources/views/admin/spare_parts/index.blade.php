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
		    <tr >
		      <td>Referencia</td>
		      <td>Descripción</td>
		      <td class="px-6 py-2 text-right">Precio</td>
		      <td></td>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($spare_parts as $spare_part)
		  	<tr >
		  	  <td>{{ $spare_part->reference }}</td>
		  	  <td>{{ $spare_part->description }}</td>
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
