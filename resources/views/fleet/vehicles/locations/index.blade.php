@extends('layouts.fleet')

@section('title', 'Ubicaciones')

@section('content')

	@component('components.search-card')
	{!!
	  Form::model(request()->all(), [
	    'route' => ['fleet.locations.index'],
	    'method' => 'GET',
	    'class' => ['md:flex items-center']
	  ])
	!!}
	    <div class="lg:px-3 lg:mb-0 mb-3">
	      <label class="form-label">{{__('Nombre')}}</label>
	      {!! Form::text('name', null, ['placeholder' => '', 'class' => 'form-input']) !!}
	    </div>
	    <div class="text-right">
	        <button class="btn-search">
	          <i class="fas fa-search"></i>
	        </button>
	    </div>
	{!! Form::close() !!}
	@endcomponent

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

  		  	  		@if(auth()->user()->job == 'fleet_manager')
  		  	  		<form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.locations.destroy', $location) }}">
  		  	  			@csrf
  		  	  			@method('DELETE')
  		  	  			<button><i class="icon fas fa-trash-alt"></i></button>
  					</form>
  					@endif
		  	  	</div>
		  	  </td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent

	{{ $locations->appends(request()->query())->links() }}

@endsection
