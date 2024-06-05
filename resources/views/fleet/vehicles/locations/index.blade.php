@extends('layouts.fleet')

@section('title', 'Ubicaciones')

@section('content')


	@component('components.card', ['is_table' => true])
		@slot('corner')
			<a href="{{ route('fleet.locations.create') }}" class="btn-outline-gray flex items-center">
				<i class="icon fas fa-plus-circle mr-2"></i>
				Nuevo
			</a>
		@endslot
		<table >
		  <thead >
		    <tr>
		      <th>Nombre</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($locations as $location)
		  	<tr >
		  	  <td>{{ $location->name }}</td>
		  	  <td>
		  	  	<div class="flex">
		  	  		<a href="{{ route('fleet.locations.edit', $location) }}" class="mr-3">
		  	  			<i class="icon fas fa-edit"></i>
		  	  		</a>
		  	  	</div>
		  	  </td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent

	{{ $locations->appends(request()->query())->links() }}

@endsection
