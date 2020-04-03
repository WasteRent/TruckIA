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
		<table>
		  <thead>
		    <tr>
		      <th>Nombre</th>
		      <th>Marca</th>
		      <th>Modelo</th>
		      <th>Frecuencia</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($plans as $plan)
		  	<tr>
		  	  <td>{{ $plan->name }}</td>
		  	  <td>{{ $plan->manufacturer->name }}</td>
		  	  <td>{{ $plan->model->name }}</td>
		  	  <td>
		  	  	{{ $plan->frequency_1 }} {{ $plan->frequency_type_1 }},
		  	  	{{ $plan->frequency_2 }} {{ $plan->frequency_type_2 }},
		  	  	{{ $plan->frequency_3 }} {{ $plan->frequency_type_3 }}
		  	  </td>
		  	  <td>
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
