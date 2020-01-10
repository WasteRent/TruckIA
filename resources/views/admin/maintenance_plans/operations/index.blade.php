@extends('layouts.admin')

@section('title', $plan->name . ' > Operaciones')

@section('content')

	@component('components.search-card')
		<div class="pb-3 px-3 font-medium">
			Buscar operaciones
		</div>
		@include('admin.maintenance_plans.operations.search')
	@endcomponent

	@if(isset($operations_search))
		@component('components.card', ['title' => 'Resultados de la busqueda...', 'is_table' => true])
			<table class="table-auto w-full">
			  <thead class="uppercase text-xs font-bold tracking-wide">
			    <tr class="bg-gray-100 border-t border-b">
			      <td class="px-6 py-2">Código</td>
			      <td class="px-6 py-2">Descripción</td>
			      <td class="px-6 py-2">Tiempo (hrs)</td>
			      <td class="px-6 py-2"></td>
			    </tr>
			  </thead>
			  <tbody>
			  		@foreach($operations_search as $operation)
			  		<tr class="border-t border-b text-gray-700">
			  		  <td class="px-6 py-2">
			  		  	<span class="uppercase">{{ $operation->code }}</span>
			  		  	<div class="flex items-center text-xs">
			  		  		<span>{{ $operation->vehicle_type }}</span>
			  		  		<ion-icon class="text-gray-500" name="ios-arrow-forward"></ion-icon>
			  		  		<span>{{ $operation->subfamily->family->name }}</span>
			  		  		<ion-icon class="text-gray-500" name="ios-arrow-forward"></ion-icon>
			  		  		<span>{{ $operation->subfamily->name }}</span>
			  		  	</div>
			  		  </td>
			  		  <td class="px-6 py-2">
			  		  	{{ $operation->name }}
			  		  	<p class="text-xs text-gray-600">{{ $operation->description }}</p>
			  		  </td>
			  		  <td class="px-6 py-2">{{ $operation->time_in_hours }}</td>
			  		  <td class="px-6 py-2">
			  		  	<form method="POST" action="{{ route('admin.maintenance-plans.operations.store', $plan) }}">
			  		  		@csrf
			  		  		<input type="hidden" name="operation_id" value="{{$operation->id}}">
			  		  		<button><i class="icon fas fa-plus-circle"></i></button>
			  		  	</form>
			  		  </td>
			  		</tr>
			  		@endforeach
			  </tbody>
			</table>
		@endcomponent
	@endif

	<div class="py-6"></div>

	@component('components.card', ['is_table' => true])
		<div class="border-b py-4 px-6 font-bold">
			Operaciones incluídas
		</div>
		<table class="table-auto w-full">
		  <thead class="uppercase text-xs font-bold tracking-wide">
		    <tr class="bg-gray-100 border-t border-b">
		      <td class="px-6 py-2">Código</td>
		      <td class="px-6 py-2">Descripción</td>
		      <td class="px-6 py-2">Tiempo (hrs)</td>
		      <td class="px-6 py-2"></td>
		    </tr>
		  </thead>
		  <tbody>
		  		@foreach($operations as $operation)
		  		<tr class="border-t border-b text-gray-700">
		  		  <td class="px-6 py-2">
		  		  	<span class="uppercase">{{ $operation->code }}</span>
		  		  	<div class="flex items-center text-xs">
		  		  		<span>{{ $operation->vehicle_type }}</span>
		  		  		<ion-icon class="text-gray-500" name="ios-arrow-forward"></ion-icon>
		  		  		<span>{{ $operation->subfamily->family->name }}</span>
		  		  		<ion-icon class="text-gray-500" name="ios-arrow-forward"></ion-icon>
		  		  		<span>{{ $operation->subfamily->name }}</span>
		  		  	</div>
		  		  </td>
		  		  <td class="px-6 py-2">
		  		  	{{ $operation->name }}
		  		  	<p class="text-xs text-gray-600">{{ $operation->description }}</p>
		  		  </td>
		  		  <td class="px-6 py-2">{{ $operation->time_in_hours }}</td>
		  		  <td class="px-6 py-2">
		  		  	<form method="POST" action="{{ route('admin.maintenance-plans.operations.destroy', [$plan, $operation]) }}">
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
