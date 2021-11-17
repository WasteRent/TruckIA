@extends('layouts.fleet')

@section('title', $vehicle->plate . '  &middot;  ' . $vehicle->chassis)

@section('content')
		
	@include('fleet.vehicles.edit_tabs', ['active_counters' => true])

	@component('components.card')
	  @slot('title', 'Contadores')

	  @slot('corner')
	  	<div class="flex">
	  		<import-vehicle-counters class="mr-3"
	  			:plans="{{ json_encode($vehicle->getMaintenancePlans()) }}"
	  			:vehicle-id="{{$vehicle->id}}"
	  			:current-counters="{{ json_encode($vehicle->counters) }}">
	  		</import-vehicle-counters>
	  		
	  		<a href="{{ route('fleet.vehicles.counters.create', $vehicle) }}" class="btn-outline-gray flex items-center">
	  			<i class="icon fas fa-plus-circle mr-2"></i>
	  			Nuevo
	  		</a>
	  	</div>
	  @endslot

	  {!! Form::model($vehicle, [
	  	'route' => ['fleet.vehicles.update', $vehicle],
	  	'method' => 'PUT',
	  	'class' => 'w-full'
	  ]) !!}
	  	<input type="hidden" name="plate" value="{{$vehicle->plate}}">
	  	<input type="hidden" name="chassis_maker_id" value="{{$vehicle->chassis_maker_id}}">
	  	<input type="hidden" name="chassis_model_id" value="{{$vehicle->chassis_model_id}}">
	  	<div class="flex flex-wrap -mx-3 mb-3">
			@if($fleet->module_km)
				<div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
					<label class="form-label" >
						Kms
					</label>
					{!! Form::number('kms', null, ['class' => 'form-input', 'step' => 'any']) !!}
				</div>
			@endif
			@if ($fleet->module_can_hours)
	  	  <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
	  	    <label class="form-label" >
	  	      Horas Can Chasis
	  	    </label>
	  	    {!! Form::number('chassis_can_work_hours', null, ['class' => 'form-input', 'step' => 'any']) !!}
	  	  </div>
			@endif
			
			@if ($fleet->module_gps_chassis_hours)
	  	  <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
	  	    <label class="form-label">
	  	      Horas GPS Chasis
	  	    </label>
	  	    {!! Form::number('chassis_gps_work_hours', null, ['class' => 'form-input', 'step' => 'any']) !!}
	  	  </div>
			@endif

			@if ($fleet->module_tdf_hours)
	  	  <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
	  	    <label class="form-label" >
	  	      Horas TDF Equipo
	  	    </label>
	  	    {!! Form::number('equipment_work_hours', null, ['class' => 'form-input', 'step' => 'any']) !!}
			</div>
			@endif
	  	</div>

	  	<div class="flex flex-wrap -mx-3 mb-3">
			@if ($fleet->module_rc_chassis_box)
	  		<div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
	  			<div class="flex">
	  			  <label class="form-label">
	  			    R.C. Chasis/Caja 
	  			  </label>
	  			  <div class="tooltip">
	  			    <i class="fas fa-info-circle fa-xs"></i>
	  			    <span class="tooltiptext">
	  			      Ratio de conversión entre chasis y caja. Cada X horas de chasis se incrementa una de equipo.
	  			    </span>
	  			  </div>
	  			</div>
	  			{!! Form::number('work_ratio_chassis_equipment', null, ['class' => 'form-input', 'step' => 'any']) !!}
			  </div>
			@endif			  

			@if ($fleet->module_rc_gps_can)
	  		<div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
	  			<div class="flex">
	  			  <label class="form-label">
	  			    R.C. GPS/CAN 
	  			  </label>
	  			  <div class="tooltip">
	  			    <i class="fas fa-info-circle fa-xs"></i>
	  			    <span class="tooltiptext">
	  			      Ratio de conversión entre horas GPS y CAN. Cada X GPS se incrementa una de CAN.
	  			    </span>
	  			  </div>
	  			</div>
	  			{!! Form::number('gps_can_ratio', null, ['class' => 'form-input', 'step' => 'any']) !!}
			  </div>
			@endif
			  
			@if ($fleet->module_source)
				<div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
					<label class="form-label">Fuente</label>
					{!! Form::select('counters_source', [
					'gps' => 'GPS',
					'can' => 'CAN'
					], null, ['class' => 'form-select']) !!}
				</div>
			@endif	
	  	</div>

	  	<div class="ml-3">
	  		@if(in_array(Auth::id(), [920,929]))
	  		<div class="flex justify-end">
	  			<button class="btn-indigo">Actualizar</button>
	  		</div>
	  		@endif
	  	</div>
	 
		
	  {!! Form::close() !!}

	@endcomponent

	@component('components.card', ['is_table' => true])
		@slot('title', 'Mantenimientos Chasis')
		<table>
		  <thead>
		    <tr>
		      <th>Descripción</th>
		      <th>Actual</th>
		      <th>Máximo</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($vehicle->counters->where('vehicle_category', 'chassis') as $counter)
		  	<tr>
		  	  <td>
		  	  	{{ $counter->description }}
		  	  </td>
		  	  <td>{{ round($counter->current, 2) }} ({{ $counter->completedPercent  }}%)</td>
		  	  <td>
		  	  	<strong>{{ $counter->max }}</strong>
		  	  	@if($counter->type == 'work_hours')
		  	  		H. Trabajo
		  	  	@elseif($counter->type == 'natural_hours')
		  	  		H. Naturales
		  	  	@elseif($counter->type == 'kms')
		  	  		Kms
		  	  	@endif
		  	  </td>
		  	  <td>
		  	  	@if(in_array(Auth::id(), [920,929]))
		  	  	<div class="flex">
		  	  		<form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.vehicles.counters.reset', [$vehicle, $counter]) }}">
		  	  			@csrf
		  	  			<button class="text-indigo-600 hover:text-indigo-900 focus:outline-none focus:underline mr-3">Reiniciar</button>
		  	  		</form>

		  	  		<a href="{{ route('fleet.vehicles.counters.edit', [$vehicle, $counter]) }}" class="mr-3">
		  	  			<i class="icon fas fa-edit"></i>
		  	  		</a>
		  	  		<form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.vehicles.counters.destroy', [$vehicle, $counter]) }}">
		  	  			@csrf
		  	  			@method('DELETE')
		  	  			<button><i class="icon fas fa-trash-alt"></i></button>
		  	  		</form>
		  	  	</div>
		  	  	@endif
		  	  </td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent

	@component('components.card', ['is_table' => true])
		@slot('title', 'Mantenimientos Equipo')
		<table>
		  <thead>
		    <tr>
		      <th>Descripción</th>
		      <th>Actual</th>
		      <th>Máximo</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($vehicle->counters->where('vehicle_category', 'equipment') as $counter)
		  	<tr>
		  	  <td>
		  	  	{{ $counter->description }}
		  	  </td>
		  	  <td>{{ round($counter->current, 2) }} ({{ $counter->completedPercent  }}%)</td>
		  	  <td>
		  	  	<strong>{{ $counter->max }}</strong>
		  	  	@if($counter->type == 'work_hours')
		  	  		H. Trabajo
		  	  	@elseif($counter->type == 'natural_hours')
		  	  		H. Naturales
		  	  	@elseif($counter->type == 'kms')
		  	  		Kms
		  	  	@endif
		  	  </td>
		  	  <td>
		  	  	@if(in_array(Auth::id(), [920,929]))
		  	  	<div class="flex">
		  	  		<form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.vehicles.counters.reset', [$vehicle, $counter]) }}">
		  	  			@csrf
		  	  			<button class="text-indigo-600 hover:text-indigo-900 focus:outline-none focus:underline mr-3">Reiniciar</button>
		  	  		</form>

		  	  		<a href="{{ route('fleet.vehicles.counters.edit', [$vehicle, $counter]) }}" class="mr-3">
		  	  			<i class="icon fas fa-edit"></i>
		  	  		</a>
		  	  		<form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.vehicles.counters.destroy', [$vehicle, $counter]) }}">
		  	  			@csrf
		  	  			@method('DELETE')
		  	  			<button><i class="icon fas fa-trash-alt"></i></button>
		  	  		</form>
		  	  	</div>
		  	  	@endif
		  	  </td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent

@endsection