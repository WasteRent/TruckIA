@extends('layouts.admin')

@section('title', 'Clientes del vehículo')

@section('content')

	@component('components.tabs', [
		'items' => [
			[
				'name' => 'Datos vehículo',
				'url' => route('admin.vehicles.edit', $vehicle),
				'active' => false
			],
			[
				'name' => 'Talleres asignados',
				'url' => route('admin.vehicles.garages.index', $vehicle),
				'active' => false
			],
			[
				'name' => 'Clientes asignados',
				'url' => route('admin.vehicles.customers.index', $vehicle),
				'active' => true
			]
		]
	])
	@endcomponent

	@component('components.search-card')
		@include('admin.customers.search', ['route' => ['admin.vehicles.customers.index', $vehicle]])
	@endcomponent

	@if(count($customers_search) > 0)
		@component('components.card', ['is_table' => true])
			@slot('title', 'Seleccionar cliente')

			<table class="table-auto w-full">
			  <thead class="uppercase text-xs font-bold tracking-wide">
			    <tr class="bg-gray-100 border-t border-b">
			      <td class="px-6 py-2">Nombre</td>
			      <td class="px-6 py-2">Email</td>
			      <td class="px-6 py-2">Tel.</td>
			      <td class="px-6 py-2">Dirección</td>
			      <td class="px-6 py-2"></td>
			    </tr>
			  </thead>
			  <tbody>
			  	@foreach($customers_search as $customer)
			  	<tr class="border-t border-b text-gray-700">
			  	  <td class="px-6 py-2">{{$customer->name}}</td>
			  	  <td class="px-6 py-2">{{$customer->email}}</td>
			  	  <td class="px-6 py-2">{{$customer->phone}}</td>
			  	  <td class="px-6 py-2">{{$customer->full_address}}</td>
			  	  <td class="px-6 py-2 flex">
		  	  		<form method="POST" action="{{ route('admin.vehicles.customers.store', $vehicle) }}">
		  	  			@csrf
		  	  			<input type="hidden" name="customer_id" value="{{$customer->id}}">
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
		@slot('title', 'Clientes asignados')
		<table class="table-auto w-full">
		  <thead class="uppercase text-xs font-bold tracking-wide">
		    <tr class="bg-gray-100 border-t border-b">
		      <td class="px-6 py-2">Nombre</td>
		      <td class="px-6 py-2">Email</td>
		      <td class="px-6 py-2">Tel.</td>
		      <td class="px-6 py-2">Dirección</td>
		      <td class="px-6 py-2"></td>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($customers as $customer)
		  	<tr class="border-t border-b text-gray-700">
		  	  <td class="px-6 py-2">{{$customer->name}} </td>
		  	  <td class="px-6 py-2">{{$customer->email}}</td>
		  	  <td class="px-6 py-2">{{$customer->phone}}</td>
		  	  <td class="px-6 py-2">{{$customer->full_address}}</td>
		  	  <td class="px-6 py-2 flex">
		  	  	<form method="POST" onsubmit="return confirmDelete()" action="{{ route('admin.vehicles.customers.destroy', [$vehicle, $customer]) }}">
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
