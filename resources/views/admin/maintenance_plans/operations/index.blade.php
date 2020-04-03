@extends('layouts.admin')

@section('title', $plan->name . ' > Operaciones')

@section('content')

	@component('components.search-card')
		@include('admin.maintenance_plans.operations.search')
	@endcomponent

	@if(isset($operations_search))
		@component('components.card', ['title' => 'Resultados de la busqueda...', 'is_table' => true])
			<table>
			  <thead>
			    <tr>
			      <th>Código</th>
			      <th>Descripción</th>
			      <th>Tiempo (hrs)</th>
			      <th></th>
			    </tr>
			  </thead>
			  <tbody>
			  		@foreach($operations_search as $operation)
			  		<tr>
			  		  <td>
			  		  	<span class="uppercase">{{ $operation->code }}</span>
			  		  	<div class="flex items-center text-xs">
			  		  		<span>{{ $operation->vehicle_type }}</span>
			  		  		<i class="icon fas fa-angle-right text-gray-500 px-1"></i>
			  		  		<span>{{ $operation->subfamily->family->name }}</span>
			  		  		<i class="icon fas fa-angle-right text-gray-500 px-1"></i>
			  		  		<span>{{ $operation->subfamily->name }}</span>
			  		  	</div>
			  		  </td>
			  		  <td>
			  		  	{{ $operation->name }}
			  		  	<p class="text-xs text-gray-600">{{ $operation->description }}</p>
			  		  </td>
			  		  <td>{{ $operation->time_in_hours }}</td>
			  		  <td>
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
		<table>
		  <thead>
		    <tr>
		      <td>Código</td>
		      <td>Descripción</td>
		      <td>Tiempo (hrs)</td>
		      <td></td>
		    </tr>
		  </thead>
		  <tbody>
		  		@foreach($operations as $operation)
		  		<tr>
		  		  <td>
		  		  	<span class="uppercase">{{ $operation->code }}</span>
		  		  	<div class="flex items-center text-xs">
		  		  		<span>{{ $operation->vehicle_type }}</span>
		  		  		<i class="icon fas fa-angle-right text-gray-500 px-1"></i>
		  		  		<span>{{ $operation->subfamily->family->name }}</span>
		  		  		<i class="icon fas fa-angle-right text-gray-500 px-1"></i>
		  		  		<span>{{ $operation->subfamily->name }}</span>
		  		  	</div>
		  		  </td>
		  		  <td>
		  		  	{{ $operation->name }}
		  		  	<p class="text-xs text-gray-600">{{ $operation->description }}</p>
		  		  </td>
		  		  <td>{{ $operation->time_in_hours }}</td>
		  		  <td>
		  		  	<form method="POST" onsubmit="return confirmDelete()" action="{{ route('admin.maintenance-plans.operations.destroy', [$plan, $operation]) }}">
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
