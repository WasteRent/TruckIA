@extends('layouts.fleet')

@section('title', $vehicle->plate . '  &middot;  ' . $vehicle->chassis)

@section('content')
		
	@include('fleet.vehicles.edit_tabs', ['active_counters' => true])

	@component('components.card')
	  @slot('title', 'Contadores')

	  {!! Form::model($vehicle, [
	  	'route' => ['fleet.vehicles.update', $vehicle],
	  	'method' => 'PUT',
	  	'class' => 'w-full'
	  ]) !!}
	  	<input type="hidden" name="plate" value="{{$vehicle->plate}}">
	  	<input type="hidden" name="chassis_maker_id" value="{{$vehicle->chassis_maker_id}}">
	  	<input type="hidden" name="chassis_model_id" value="{{$vehicle->chassis_model_id}}">
	  	<div class="flex flex-wrap -mx-3 mb-6">
	  	  <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
	  		<label class="form-label" >
	  		  Kms
	  		</label>
	  		{!! Form::number('kms', null, ['class' => 'form-input', 'step' => '0.1']) !!}
	  	  </div>
	  	  <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
	  	    <label class="form-label" >
	  	      Horas Can Chasis
	  	    </label>
	  	    {!! Form::number('chassis_can_work_hours', null, ['class' => 'form-input', 'step' => '0.1']) !!}
	  	  </div>
	  	  <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
	  	    <label class="form-label">
	  	      Horas GPS Chasis
	  	    </label>
	  	    {!! Form::number('chassis_gps_work_hours', null, ['class' => 'form-input', 'step' => '0.1']) !!}
	  	  </div>
	  	  <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
	  	    <label class="form-label" >
	  	      Horas TDF Equipo
	  	    </label>
	  	    {!! Form::number('equipment_work_hours', null, ['class' => 'form-input', 'step' => '0.1']) !!}
	  	  </div>
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
	  	    {!! Form::number('work_ratio_chassis_equipment', null, ['class' => 'form-input', 'step' => '0.1']) !!}
	  	  </div>

	  	  <div class="sm:mt-8 ml-3">
	  	  	<div class="flex justify-end">
	  	  		<button class="btn-indigo">Actualizar</button>
	  	  	</div>
	  	  </div>
	  	</div>
	 
		
	  {!! Form::close() !!}

	@endcomponent

	@component('components.card', ['is_table' => true])
		@slot('title', 'Mantenimientos')
		@slot('corner')
			<a href="{{ route('fleet.vehicles.counters.create', $vehicle) }}" class="btn-outline-gray flex items-center">
				<i class="icon fas fa-plus-circle mr-2"></i>
				Nuevo
			</a>
		@endslot
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
		  	@foreach($vehicle->counters as $counter)
		  	<tr>
		  	  <td>
		  	  	<span class="uppercase font-medium text-xs">
		  	  		@if($counter->vehicle_category == 'chassis')
		  	  			Chasis
		  	  		@else
		  	  			Equipo
		  	  		@endif
		  	  	</span>
		  	  	&middot; {{ $counter->description }}
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
		  	  </td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent

@endsection