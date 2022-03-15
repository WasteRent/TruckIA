@extends('layouts.fleet')

@section('title', 'Talleres')

@section('content')

	@component('components.search-card')
		@include('fleet.garages.search', ['route' => 'fleet.garages.index'])
	@endcomponent

	@component('components.card', ['is_table' => true])
		@slot('corner')
			<a class="mr-4 text-green-600" href="{{ route('fleet.export.garages') }}"><i class="fas fa-lg fa-file-excel"></i></a>
			<a href="{{ route('fleet.garages.create') }}" class="btn-outline-gray flex items-center">
				<i class="icon fas fa-plus-circle mr-2"></i>
				Nuevo
			</a>
		@endslot
		<table>
		  <thead>
		    <tr>
		      <th>Nombre</th>
		      <th>Email</th>
		      <th>Tel.</th>
		      <th>Zona</th>
		      <th class="hidden sm:table-cell">Servicio Oficial</th>
		      <th class="hidden sm:table-cell">Especialidades</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($garages as $garage)
		  	<tr>
		  	  <td>
		  	  	<span class="mr-1">{{$garage->name}}</span>
		  	  	@if($garage->is_manager)
		  	  		<i class="fas fa-medal text-yellow-300 fa-lg"></i>
		  	  	@endif
		  	  </td>
		  	  <td>{{$garage->garage_email}}</td>
		  	  <td>{{$garage->garage_phone}}</td>
		  	  <td>{{$garage->state}} - {{$garage->province}}</td>
		  	  <td class="hidden sm:table-cell">
		  	  	{{$garage->officialService1 ? $garage->officialService1->name : ''}}
		  	  	{{$garage->officialService2 ? $garage->officialService2->name : ''}}
		  	  	{{$garage->officialService3 ? $garage->officialService3->name : ''}}
		  	  	{{$garage->officialService4 ? $garage->officialService4->name : ''}}
		  	  	{{$garage->officialService5 ? $garage->officialService5->name : ''}}
		  	  </td>
		  	  <td class="hidden sm:table-cell">@include('shared.garages.specs')</td>
		  	  <td>
		  	  	<div class="flex">
		  	  		<a href="{{ route('fleet.garages.show', $garage) }}" class="mr-3">
		  	  			<i class="icon fas fa-eye fa-lg"></i>
		  	  		</a>
		  	  		<a href="{{ route('fleet.garages.edit', $garage) }}" class="mr-3">
		  	  			<i class="icon fas fa-edit fa-lg"></i>
		  	  		</a>
		  	  		<form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.garages.destroy', $garage) }}">
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

	{{ $garages->appends(request()->query())->links() }}
@endsection
