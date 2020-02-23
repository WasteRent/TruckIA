@extends('layouts.admin')

@section('title', 'Talleres')

@section('content')

	@component('components.search-card')
		@include('admin.garages.search', ['route' => 'admin.garages.index'])
	@endcomponent

	@component('components.card', ['is_table' => true])
		@slot('corner')
			<a href="{{ route('admin.garages.create') }}" class="border px-4 py-1 rounded hover:bg-gray-100 shadow flex items-center">
				<i class="icon fas fa-plus-circle mr-2"></i>
				Nuevo
			</a>
		@endslot
		<table class="table-auto w-full">
		  <thead class="uppercase text-xs font-bold tracking-wide">
		    <tr class="bg-gray-100 border-t border-b">
		      <td class="px-6 py-2">Nombre</td>
		      <td class="px-6 py-2">Email</td>
		      <td class="px-6 py-2">Tel.</td>
		      <td class="px-6 py-2">Dirección</td>
		      <td class="px-6 py-2">Especialidades</td>
		      <td class="px-6 py-2"></td>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($garages as $garage)
		  	<tr class="border-t border-b text-gray-700">
		  	  <td class="px-6 py-2">{{$garage->name}} </td>
		  	  <td class="px-6 py-2">{{$garage->email}}</td>
		  	  <td class="px-6 py-2">{{$garage->phone}}</td>
		  	  <td class="px-6 py-2">{{$garage->full_address}}</td>
		  	  <td class="px-6 py-2">@include('shared.garages.specs')</td>
		  	  <td class="px-6 py-2 flex">
		  	  	<a href="{{ route('admin.garages.edit', $garage) }}" class="mr-2">
		  	  		<i class="icon fas fa-edit"></i>
		  	  	</a>
		  	  	<a href="{{ route('admin.garages.show', $garage) }}">
		  	  		<i class="icon fas fa-eye"></i>
		  	  	</a>
		  	  </td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent

	{{ $garages->appends(request()->query())->links() }}
@endsection
