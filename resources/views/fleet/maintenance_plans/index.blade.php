@extends('layouts.fleet')

@section('title', 'Planes de mantenimiento')

@section('content')

	@component('components.search-card')
		@include('fleet.maintenance_plans.search', ['route' => 'fleet.maintenance-plans.index'])
	@endcomponent

	@component('components.card', ['is_table' => true])
		<table>
		  <thead>
		    <tr>
		      <th>Nombre</th>
		      <th>Marca</th>
		      <th>Modelo</th>
		      <th>Den. Com.</th>
		      <th>Euro</th>
		      <th>Tipo</th>
		      <th>Frecuencia</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($plans as $plan)
		  	<tr>
		  	  <td>{{ $plan->name }}</td>
		  	  <td>{{ optional($plan->manufacturer)->name }}</td>
		  	  <td>{{ optional($plan->model)->name }}</td>
		  	  <td>{{ optional($plan->version)->name }}</td>
		  	  <td>{{ $plan->euro }}</td>
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
		  	  <td>
		  	  	<a href="{{ route('fleet.maintenance-plans.operations.index', $plan) }}" class="mr-3">
		  	  		<i class="icon fas fa-cogs"></i>
		  	  	</a>
		  	  </td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent

	{{ $plans->appends(request()->query())->links() }}

@endsection
