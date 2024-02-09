@extends('layouts.fleet')

@section('title', $vehicle->plate . ' ' . $vehicle->chassis)

@section('content')

	@include('fleet.vehicles.edit_tabs', ['active_files' => true])

	@component('components.card', ['compressed' => true])
		@slot('title', __('Añadir archivo'))
		@include('fleet.vehicles.files.create')
	@endcomponent

	<br><br>

	@component('components.card', ['is_table' => true])
		@slot('title', __('Archivos del vehículo'))
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
		  	  		<form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.vehicles.files.destroy', [$vehicle, $file]) }}">
		  	  			@csrf
		  	  			@method('DELETE')
		  	  			<button><i class="icon fas fa-trash-alt fa-lg"></i></button>
		  	  		</form>
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
