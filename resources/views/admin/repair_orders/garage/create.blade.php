@extends('layouts.admin')

@section('title', 'Nueva Orden de Reparación')

@section('content')

	@component('components.search-card')
		@include('admin.garages.search', ['route' => ['admin.repair-orders.garages.create', $repair_order]])
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
			  	  	<form method="POST" action="{{ route('admin.repair-orders.garages.store', $repair_order) }}">
			  	  		@csrf
			  	  		<input type="hidden" name="garage_id" value="{{ $garage->id }}">
			  	  		<button><i class="icon fas fa-hand-pointer"></i></button>
			  	  	</form>
			  	  </td>
			  	</tr>
			  	@endforeach
			  </tbody>
			</table>
		@endcomponent
	@endif

@endsection
