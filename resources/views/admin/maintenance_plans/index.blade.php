@extends('layouts.admin')

@section('title', 'Planes de mantenimiento')

@section('content')

	@component('components.search-card')
		@include('admin.maintenance_plans.search', ['route' => 'admin.maintenance-plans.index'])
	@endcomponent

	@component('components.card', ['is_table' => true])
		@slot('corner')
			<a href="{{ route('admin.maintenance-plans.create') }}" class="btn-outline-gray flex items-center">
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
		      <th>Tipo</th>
		      <th>Frecuencia</th>
		      <th>Creado</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($plans as $plan)
		  	<tr>
		  	  <td>{{ $plan->name }}</td>
		  	  <td>{{ optional($plan->manufacturer)->name }}</td>
		  	  <td>{{ optional($plan->model)->name }}</td>
		  	  <td>{{ $plan->type == 'periodic' ? 'Periódico' : 'Sólo una vez'  }}</td>
		  	  <td>
		  	  	@if($plan->kms)
		  	  		{{ $plan->kms }} kms <br>
		  	  	@endif
		  	  	@if($plan->natural_hours)
		  	  		{{ $plan->natural_hours }} Horas Naturales <br>
		  	  	@endif
		  	  	@if($plan->work_hours)
		  	  		{{ $plan->work_hours }} Horas de Trabajo <br>
		  	  	@endif
		  	  	@if($plan->can_hours)
		  	  		{{ $plan->can_hours }} Horas CAN <br>
		  	  	@endif
		  	  	@if($plan->grua_hours)
		  	  		{{ $plan->grua_hours }} Horas Uso Grua <br>
		  	  	@endif
		  	  </td>
		  	  <td>{{ Carbon\Carbon::parse($plan->created_at)->format('d/m/Y H:i:s') }}</td>
		  	  <td>
		  	  	<div class="flex">
		  	  		<a href="{{ route('admin.maintenance-plans.edit', $plan) }}" class="mr-3">
		  	  			<i class="icon fas fa-edit"></i>
		  	  		</a>
		  	  		<a href="{{ route('admin.maintenance-plans.operations.index', $plan) }}" class="mr-3">
		  	  			<i class="icon fas fa-cogs"></i>
		  	  		</a>

		  	  		<form class="mr-3" method="POST" action="{{ route('admin.maintenance-plans.clone', $plan) }}">
		  	  			@csrf
		  	  			<button><i class="icon fas fa-clone"></i></button>
		  	  		</form>

		  	  		<form method="POST" onsubmit="return confirmDelete()" action="{{ route('admin.maintenance-plans.destroy', $plan) }}">
		  	  			@csrf
		  	  			@method('DELETE')
		  	  			<button><i class="icon fas fa-trash-alt"></i></button>
		  	  		</form>
		  	  	</div>
		  	  </td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent

	{{ $plans->appends(request()->query())->links() }}

@endsection
