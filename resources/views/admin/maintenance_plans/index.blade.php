@extends('layouts.admin')

@section('title', 'Planes de mantenimiento')

@section('content')

	@component('components.search-card')
		@include('admin.maintenance_plans.search', ['route' => 'admin.maintenance-plans.index'])
	@endcomponent

	@component('components.card', ['is_table' => true])
		@slot('corner')
			<a href="{{ route('admin.maintenance-plans.create') }}" class="border px-4 py-1 rounded hover:bg-gray-100 shadow flex items-center">
				<i class="icon fas fa-plus-circle mr-2"></i>
				Nuevo
			</a>
		@endslot
		<table class="table-auto w-full">
		  <thead class="uppercase text-xs font-bold tracking-wide">
		    <tr class="bg-gray-100 border-t border-b">
		      <td class="px-6 py-2">Nombre</td>
		      <td class="px-6 py-2">Marca</td>
		      <td class="px-6 py-2">Modelo</td>
		      <td class="px-6 py-2">Frecuencia</td>
		      <td class="px-6 py-2"></td>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($plans as $plan)
		  	<tr class="border-t border-b text-gray-700">
		  	  <td class="px-6 py-2">{{ $plan->name }}</td>
		  	  <td class="px-6 py-2">{{ $plan->manufacturer->name }}</td>
		  	  <td class="px-6 py-2">{{ $plan->model->name }}</td>
		  	  <td class="px-6 py-2">{{ $plan->frequency }} {{ $plan->frequency_type }}</td>
		  	  <td class="px-6 py-2">
		  	  	<a href="{{ route('admin.maintenance-plans.edit', $plan) }}" class="mr-3">
		  	  		<i class="icon fas fa-edit"></i>
		  	  	</a>
		  	  	<a href="{{ route('admin.maintenance-plans.operations.index', $plan) }}" class="mr-3">
		  	  		<i class="icon fas fa-cogs"></i>
		  	  	</a>
		  	  	<form method="POST" onsubmit="return confirmDelete()" action="{{ route('admin.maintenance-plans.destroy', $plan) }}">
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
