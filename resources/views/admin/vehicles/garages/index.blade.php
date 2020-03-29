@extends('layouts.admin')

@section('title', 'Talleres del vehículo')

@section('content')

	@component('components.tabs', [
		'items' => [
			[
				'name' => 'Datos vehículo',
				'url' => route('admin.vehicles.edit', $vehicle),
				'active' => false
			],
			[
				'name' => 'Archivos',
				'url' => route('admin.vehicles.files.index', $vehicle),
				'active' => false
			],
			[
				'name' => 'Talleres asignados',
				'url' => route('admin.vehicles.garages.index', $vehicle),
				'active' => true
			],
			[
				'name' => 'Clientes asignados',
				'url' => route('admin.vehicles.customers.index', $vehicle),
				'active' => false
			]
		]
	])
	@endcomponent

	@component('components.search-card')
		@include('admin.garages.search', ['route' => ['admin.vehicles.garages.index', $vehicle]])
	@endcomponent

	@if(count($garages_search) > 0)
		@component('components.card', ['is_table' => true])
			@slot('title', 'Seleccionar taller')

			<table class="table-auto w-full">
			  <thead class="uppercase text-xs font-bold tracking-wide">
			    <tr class="bg-gray-100 border-t border-b">
			      <td class="px-6 py-2">Nombre</td>
			      <td class="px-6 py-2">Email</td>
			      <td class="px-6 py-2">Tel.</td>
			      <td class="px-6 py-2">Dirección</td>
			      <td class="px-6 py-2"></td>
			      <td class="px-6 py-2"></td>
			    </tr>
			  </thead>
			  <tbody>
			  	@foreach($garages_search as $garage)
			  	<tr class="border-t border-b text-gray-700">
			  	  <td class="px-6 py-2">{{$garage->name}}</td>
			  	  <td class="px-6 py-2">{{$garage->email}}</td>
			  	  <td class="px-6 py-2">{{$garage->phone}}</td>
			  	  <td class="px-6 py-2">{{$garage->full_address}}</td>
			  	  <td class="px-6 py-2">@include('shared.garages.specs')</td>
			  	  <td class="px-6 py-2 flex">
		  	  		<form method="POST" action="{{ route('admin.vehicles.garages.store', $vehicle) }}">
		  	  			@csrf
		  	  			<input type="hidden" name="garage_id" value="{{$garage->id}}">
		  	  			<button><i class="icon fas fa-plus-circle"></i></button>
		  	  		</form>
			  	  </td>
			  	</tr>
			  	@endforeach
			  </tbody>
			</table>
		@endcomponent
	@endif

	<br><br>

	@component('components.card', ['is_table' => true])
		@slot('title', 'Talleres asignados')
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
		  	  	<form method="POST" onsubmit="return confirmDelete()" action="{{ route('admin.vehicles.garages.destroy', [$vehicle, $garage]) }}">
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
@endsection
