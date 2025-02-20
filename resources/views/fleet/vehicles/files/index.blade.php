@extends('layouts.fleet')

@section('title', $vehicle->plate . ' ' . $vehicle->chassis)

@section('content')

	@include('fleet.vehicles.edit_tabs', ['active_files' => true])


	

	@component('components.card', ['compressed' => true])
		@slot('title', __('Añadir archivo'))
		@include('fleet.vehicles.files.create')
	@endcomponent

	@component('components.card')
	@slot('title', __('Archivos subidos'))
	{!! Form::open([
		'route' => ['fleet.vehicle-checklists-files.store', ['vehicle_id'=>$vehicle]],
		'method' => 'POST',
		'class' => 'w-full'
	]) !!}

	<div class="flex flex-col justify-start items-start gap-2">
		<div class="flex flex-col gap-3">
			@foreach ($vehicle_checklist_file_types as $type)
			<div class="text-sm">
				<label>
					{!! Form::hidden("vehicle_checklist_files[$type->id]", 0) !!}

					{!! Form::checkbox(
						"vehicle_checklist_files[$type->id]", 
						1, 
						optional($vehicle->vehicleChecklistFiles->firstWhere('vehicle_checklist_file_type_id', $type->id))->is_checked == 1 ? true : false,
						['class' => 'mr-1 focus:ring-green-500 h-6 w-6 lg:h-5 lg:w-5 text-green-600 border-gray-300']
					) !!}
					{{ __($type->name) }}
				</label>
			</div>
		@endforeach
		</div>
		<div class="btn-outline-gray mt-2">
			<button>{{ __('Actualizar') }}</button>
		</div>
	</div>
	
	{!! Form::close() !!}
	@endcomponent

	<br><br>
	@component('components.card', ['is_table' => true])
	@slot('title', __('Archivos del vehículo'))
	@slot('corner')
	<a class="mr-4 text-green-600" href="{{ route('fleet.export.archives', ['vehicle' => $vehicle->id]) }}"><i class="fas fa-lg fa-file-excel"></i></a>
	@endslot
		<table >
		  <thead >
		    <tr >
		      <th>{{ __('Descripción') }}</th>
		      <th>{{ __('Fecha') }}</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($vehicle->files as $file)
		  	<tr>
		  	  <td>
		  	  	<a class="font-medium" target="_blank" href="{{$file->getLink()}}">
		  	  		{{$file->description}} ({{ $file->size }})
		  	  	</a>
		  	  </td>
		  	  <td>{{$file->created_at->format('d/m/Y H:i:s')}}</td>
		  	  <td>
		  	  	<div class="flex">
		  	  		<a target="_blank" href="{{$file->getLink()}}"  class="mr-4">
		  	  			<i class="icon fas fa-eye fa-lg"></i>
		  	  		</a>
					@if(!in_array(Auth::user()->job, ['garage_boss', 'garage', 'mechanic']))
		  	  		<form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.vehicles.files.destroy', [$vehicle, $file]) }}">
		  	  			@csrf
		  	  			@method('DELETE')
		  	  			<button><i class="icon fas fa-trash-alt fa-lg"></i></button>
		  	  		</form>
					@endif
		  	  	</div>
		  	  </td>
		  	</tr>
		  	@endforeach


		  	@foreach($vehicle_models as $model)
			  	@if(auth()->user()->allowOriginalPlans() && $model?->technicalHandbook)
			  	<tr>
			  	  <td>
			  	  	<a class="font-medium" target="_blank" href="{{$model->technicalHandbook->getLink()}}">
			  	  		{{ __('Manual técnico') }} {{$model->manufacturer->name}} {{$model->name}}  ({{ $model->technicalHandbook->size }})
			  	  	</a>
			  	  </td>
			  	  <td>{{$model->technicalHandbook->created_at->format('d/m/Y H:i:s')}}</td>
			  	  <td>
			  	  	<div class="flex">
			  	  		<a target="_blank" href="{{$model->technicalHandbook->getLink()}}"  class="mr-4">
			  	  			<i class="icon fas fa-eye"></i>
			  	  		</a>
			  	  	</div>
			  	  </td>
			  	</tr>
			  	@endif
			  	@if(auth()->user()->allowOriginalPlans() && $model?->usageHandbook)
			  	<tr>
			  	  <td>
			  	  	<a class="font-medium" target="_blank" href="{{$model->usageHandbook->getLink()}}">
			  	  		{{ __('Manual de uso') }} {{$model->manufacturer->name}} {{$model->name}} ({{ $model->usageHandbook->size }})
			  	  	</a>
			  	  </td>
			  	  <td>{{$model->usageHandbook->created_at->format('d/m/Y H:i:s')}}</td>
			  	  <td>
			  	  	<div class="flex">
			  	  		<a target="_blank" href="{{$model->usageHandbook->getLink()}}"  class="mr-4">
			  	  			<i class="icon fas fa-eye"></i>
			  	  		</a>
			  	  	</div>
			  	  </td>
			  	</tr>
			  	@endif
		  	@endforeach

		  </tbody>
		</table>
	@endcomponent
@endsection
