@extends('layouts.admin')

@section('title', 'Talleres')

@section('content')

	@component('components.search-card')
		@include('admin.garages.search', ['route' => 'admin.garages.index'])
	@endcomponent

	@component('components.card', ['is_table' => true])
		@slot('corner')
			<a href="{{ route('admin.garages.create') }}" class="btn-outline-gray flex items-center">
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
		      <th>Servicio Oficial</th>
		      <th>Especialidades</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($garages as $garage)
		  	<tr>
		  	  <td>{{$garage->name}} </td>
		  	  <td>{{$garage->email}}</td>
		  	  <td>{{$garage->phone}}</td>
		  	  <td>
		  	  	{{$garage->officialService1 ? $garage->officialService1->name : ''}}
		  	  	{{$garage->officialService2 ? $garage->officialService2->name : ''}}
		  	  	{{$garage->officialService3 ? $garage->officialService3->name : ''}}
		  	  	{{$garage->officialService4 ? $garage->officialService4->name : ''}}
		  	  	{{$garage->officialService5 ? $garage->officialService5->name : ''}}
		  	  </td>
		  	  <td>@include('shared.garages.specs')</td>
		  	  <td>
		  	  	<div class="flex">
		  	  		<a href="{{ route('admin.garages.edit', $garage) }}" class="mr-2">
		  	  			<i class="icon fas fa-edit"></i>
		  	  		</a>
		  	  		<a href="{{ route('admin.garages.show', $garage) }}">
		  	  			<i class="icon fas fa-eye"></i>
		  	  		</a>
		  	  	</div>
		  	  </td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent

	{{ $garages->appends(request()->query())->links() }}
@endsection
