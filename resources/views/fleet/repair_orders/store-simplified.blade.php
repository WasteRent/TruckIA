@extends('layouts.fleet')
@section('title')
	<div class='flex items-center'>
		<span class='mr-2'>
			OR# {{ $repair_order->id }}
			@if(isset($active_summary))
				Resumen
			@elseif(isset($active_auth))	
				Autorización
			@elseif(isset($active_operations))	
				Operaciones
			@elseif(isset($active_garage))	
				Taller
			@elseif(isset($active_vehicle))	
				Vehículo
			@endif
		</span>
		<span class='text-sm px-8 text-gray-600'>
			{{ $repair_order->vehicle->plate }} &middot;
			{{ $repair_order->vehicle->chassis }}
			{{ $repair_order->vehicle->equipment }}
		</span>
		<span class='{{ $repair_order->state->color }} badge'>
			{{ $repair_order->state->name }}
		</span>
	</div>
@endsection
@section('content')
	<!-- Ver datos vehículo -->
	@component('components.card')
	@slot('title', 'Datos del vehículo')
	<div class="sm:flex">
		<div class="sm:w-1/2">
			@php 
				$equipments = "";
				foreach($repair_order->vehicle->equipments as $equipment){
					$equipments .= "{$equipment->type} {$equipment->maker->name} {$equipment->model->name}<br>";
				}
			@endphp

			@component('components.table')
				@slot('items', [
					'Matrícula' => $repair_order->vehicle->plate,
					'Tipo' => optional($repair_order->vehicle->type)->name,
					'Chasis' => $repair_order->vehicle->chassis,
					'Equipo' => $equipments,
					'Estado' => $repair_order->vehicle->customer ? ($repair_order->vehicle->state->name . ' - ' . $repair_order->vehicle->customer->name) : optional($repair_order->vehicle->state)->name,
					'Fecha de Fabricación' => $repair_order->vehicle->created_at
				])
			@endcomponent
		</div>
		<div class="sm:w-1/2 mt-4 sm:mt-0">
			@if($repair_order->vehicle->pictures->count() > 0)
				<img loading="lazy" src="{{ $repair_order->vehicle->getCover()->getLink() }}">
			@else
				<i class="fas fa-image text-gray-300" style="font-size: 12rem;"></i>
			@endif
		</div>
	</div>

	<div class="text-gray-800">
		<br>
		@if(isset($repair_order->vehicle->chassisModel->technicalHandbook))
			<a target="_blank" href="{{$repair_order->vehicle->chassisModel->technicalHandbook->getLink()}}"><i class="fas fa-cloud-download-alt"></i> Manual técnico {{$vehicle->chassis}}</a><br>
		@endif
		@if(isset($repair_order->vehicle->chassisModel->usageHandbook))
			<a target="_blank" href="{{$repair_order->vehicle->chassisModel->usageHandbook->getLink()}}"><i class="fas fa-cloud-download-alt"></i> Manual de uso {{$vehicle->chassis}}</a><br>
		@endif

		@foreach($repair_order->vehicle->equipments as $equipment)
			@if(isset($equipment->model->technicalHandbook))
				<a target="_blank" href="{{ $equipment->model->technicalHandbook->getLink() }}"><i class="fas fa-cloud-download-alt"></i> Manual técnico {{ $equipment->maker->name }} {{ $equipment->model->name }}</a><br>
			@endif
			@if(isset($equipment->model->usageHandbook))
				<a target="_blank" href="{{ $equipment->model->usageHandbook->getLink() }}"><i class="fas fa-cloud-download-alt"></i> Manual de uso {{ $equipment->maker->name }} {{ $equipment->model->name }}</a><br>
			@endif
		@endforeach
	</div>

	@if(isset($show_counters) && $show_counters)
		<div>
			<display-more>
				<template v-slot:head>
					@foreach($repair_order->vehicle->counters->sortByDesc('completedPercent')->take(5) as $counter)
						<div class="mb-5">@include('fleet.vehicles.counters.progress')</div>
					@endforeach
				</template>
				<template v-slot:body>
					@foreach($repair_order->vehicle->counters->sortByDesc('completedPercent')->slice(5) as $counter)
						<div class="mb-5">@include('fleet.vehicles.counters.progress')</div>
					@endforeach
				</template>
			</display-more>
		</div>
	@endif

	
	@endcomponent	
	<!-- Ver datos tracking vehículo -->
    @include('fleet.vehicles.tracking', ['vehicle' => $repair_order->vehicle])
    <!-- Ver datos garage -->
    @include('shared.garages.show', ['garage' => $repair_order->garage])

		<!-- Datos Generales -->
	@component('components.card')
		@slot('title', 'Datos generales')

		{!! Form::model($repair_order, [
			'route' => ['fleet.repair-orders.update', $repair_order],
			'method' => 'PUT',
			'class' => 'w-full'
		]) !!}	
			<div class="flex flex-wrap -mx-3">
			  <div class="w-full md:w-3/12 px-3 mb-6 md:mb-0">
			    <label class="form-label" >
			      Fecha de apertura
			    </label>
			    {!! Form::text('created_at', null, ['class' => 'form-input datepicker']) !!}
			  </div>

			  <div class="w-full md:w-3/12 px-3 mb-6 md:mb-0">
			      <label class="form-label">
			        Asignada a
			      </label>
			        {!! Form::select('assigned_user_id', $repair_order->garage->users->pluck('name', 'id'), null, ['placeholder' => '', 'class' => 'form-select']) !!}
			  </div>

			  <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
			    <label class="form-label" >
			      Kms
			    </label>
			    {!! Form::number('kms', null, ['class' => 'form-input']) !!}
			  </div>
			  <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
			    <label class="form-label" >
			      Horas Chasis
			    </label>
			    {!! Form::number('work_hours_chassis', null, ['class' => 'form-input', 'step' => 'any']) !!}
			  </div>
			  <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
			    <label class="form-label" >
			      Horas Equipo
			    </label>
			    {!! Form::number('work_hours_equipment', null, ['class' => 'form-input', 'step' => 'any']) !!}
			  </div>
			  <div class="w-full mt-6 px-3 md:mb-0">
			  	<label class="form-label" >
			  	  Nota interna de OR
			  	</label>
			  	{!! Form::textarea('internal_notes', null, ['class' => 'form-input', 'rows' => 2]) !!}
			  </div>
			</div>
			<div class="flex justify-end">
				<button class="btn-indigo">Actualizar</button>
			</div>
		{!! Form::close() !!}
	@endcomponent

    <!-- Sección mantenimientos -->
	@if($repair_order->type == 'preventive')
		<form method="POST" action="{{ route('fleet.repair-orders.maintenance-plans.store', $repair_order) }}">
			@csrf
			@foreach($plans->groupBy('manufacturer_id') as $plans_group)
				@component('components.card', ['is_table' => true])
					@slot('title', 'Mantenimientos > ' . optional($plans_group->first()->manufacturer)->name .' '. optional($plans_group->first()->model)->name)

					<table>
					<thead>
						<tr>
						<th>Nombre</th>
						<th>Frecuencia</th>
						<th></th>
						</tr>
					</thead>
					<tbody>
						@foreach($plans_group->sortBy('name') as $plan)
						<tr>
						<td class="max-w-sm">{{ $plan->name }}</td>
						<td class="w-1/2">
							@include('fleet.repair_orders.operations.plans_counters')
						</td>
						<td>
							<input type="checkbox" name="plan_ids[]" value="{{ $plan->id }}">
						</td>
						</tr>
						@endforeach
					</tbody>
					</table>
				@endcomponent
			@endforeach

			<div class="text-right">
				<button type="submit" class="btn-outline-gray my-4"><i class="icon fas fa-plus-circle mr-2"></i>Añadir mantenimientos</button>
			</div>
		</form>
	@endif

	<!-- Sección Operaciones -->
	@if($repair_order->type == 'corrective')
		@component('components.card')
			@slot('corner')	
			<div class="flex">
			<create-custom-operation endpoint="{{ route('fleet.repair-orders.custom-operation.store', $repair_order) }}"></create-custom-operation>			
			</div>
			@endslot

			@include('fleet.repair_orders.operations.search', [
				'route' => ['fleet.repair-orders.store-simplified', $repair_order]
			])
		@endcomponent
		<div id="search-results">
			@include('fleet.repair_orders.operations.search_results', [
				'add_route' => route('fleet.repair-orders.operations.store', $repair_order)
			])
		</div>
		@foreach($operations->groupBy('maintenance_plan_id') as $plan_ops)
			@component('components.card', ['is_table' => true])
				@slot('title', $plan_ops->first()->maintenance_plan_name)
			
				<table>
				<thead>
					<tr>
					<th class="hidden sm:table-cell">Código</th>
					<th>Descripción</th>
					<th>Tiempo (hrs)</th>
					<th></th>
					</tr>
				</thead>
				<tbody>
						@foreach($plan_ops as $operation)
						<tr>
						<td class="hidden sm:table-cell">
							<span class="uppercase">{{ $operation->operation_code }}</span>
							<div class="flex items-center text-xs">
								<span>{{ $operation->operation_family }}</span>
								<i class="icon fas fa-angle-right text-gray-500 px-1"></i>
								<span>{{ $operation->operation_subfamily }}</span>
							</div>
						</td>
						<td>
							{{ $operation->operation_name }}
							@if($operation->operationAttachment)
								<a href="{{$operation->operationAttachment->getLink()}}" target="_blank">
									<i class="fas fa-question-circle"></i>
								</a>
							@endif
							<p class="text-xs text-gray-600">{{ $operation->operation_description }}</p>
						</td>
						<td>{{ $operation->estimated_time_in_hours }}</td>
						<td>
							<form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.repair-orders.operations.destroy', [$repair_order, $operation]) }}">
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
		@endforeach
	@endif

	<!-- Sección Pre-ITV -->
	@if($repair_order->type == 'pre-itv' && Auth::user()->fleet->module_ITV)
		@include('fleet.repair_orders.itv')
	@endif

	<!-- Sección Operaciones -->
	@if($repair_order->type == 'preventive')
		@component('components.card', ['is_table' => true])
			@slot('title', 'Operaciones Realizadas')
			@include('shared.repair_orders.operations', ['repair_order' => $repair_order])
		@endcomponent
	@endif

	<!-- Sección Recambios -->
	@component('components.card', ['is_table' => true])
		@slot('title', 'Recambios')
		@include('shared.repair_orders.parts', ['repair_order' => $repair_order])
	@endcomponent
	<div class="float-right">
    @if(!$repair_order->isFinished())
			
				<div class="flex">
					<form class="mr-4" method="POST" action="{{ route('fleet.repair-orders.destroy', $repair_order) }}">
						@csrf
						@method('DELETE')
						<button class="btn-outline-red">
							Cancelar
						</button>
					</form>
					<a class="mr-4" href="{{ route('fleet.repair-orders.index') }}">
						<button class="btn-outline-gray">
							Guardar O.R
						</button>
					</a>
					<form method="POST" action="{{ route('fleet.repair-orders.finish', $repair_order) }}">
						@csrf
						@method('PUT')
						<button class="btn-outline-gray">
							Intervención Finalizada
						</button>
					</form>
				</div>
			
		@else
				<a class="btn-outline-gray" href="{{ route('fleet.repair-orders.invoice.show',$repair_order ) }}" target="_blank">
					<i class="fas fa-file-invoice-dollar mr-2"></i> Factura
				</a>
			
		@endif
	</div>

@endsection
