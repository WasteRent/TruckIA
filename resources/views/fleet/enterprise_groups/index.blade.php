@extends('layouts.fleet')

@section('title', __('Empresas'))

@section('content')
	
	@component('components.card', ['is_table' => true])
		@slot('corner')
			<a class="mr-4 text-green-600" href="{{ route('fleet.export.enterprise-groups') }}"><i class="fas fa-lg fa-file-excel"></i></a>
			<a href="{{ route('fleet.enterprise-groups.create') }}" class="btn-outline-gray flex items-center">
				<i class="icon fas fa-plus-circle mr-2"></i>
				{{ __('Nuevo') }}
			</a>
		@endslot

		<table>
		  <thead>
		    <tr>
		      <th>{{ __('Nombre') }}</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($enterprises as $enterprise)
		  	<tr>
		  	  <td>{{$enterprise->name}}</td>
		  	  <td>
		  	  	<div class="flex">
		  	  		<a href="{{ route('fleet.enterprise-groups.edit', $enterprise) }}" class="mr-3">
		  	  			<i class="icon fas fa-edit fa-lg"></i>
		  	  		</a>
		  	  		<form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.enterprise-groups.destroy', $enterprise) }}">
		  	  			@csrf
		  	  			@method('DELETE')
		  	  			<button><i class="icon fas fa-trash-alt fa-lg"></i></button>
		  	  		</form>
		  	  	</div>
		  	  </td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent
@endsection
