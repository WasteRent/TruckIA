@extends('layouts.fleet')

@section('title', $plan->name . ' ' . optional($plan->manufacturer)->name .' '. optional($plan->model)->name . ' > Operaciones')

@section('content')

	@component('components.card', ['is_table' => true])
		@slot('title', 'Operaciones incluídas')
		@slot('corner')
			<a href="{{ route('fleet.maintenance-plans.operations.create', $plan) }}" class="btn-outline-gray flex items-center">
				<i class="icon fas fa-plus-circle mr-2"></i>
				Nuevo
			</a>
		@endslot
			
		<table>
		  <thead>
		    <tr>
		      <th>Área</th>
		      <th>Nombre</th>
		      <th>Descripción</th>
		      <th>Tiempo (hrs)</th>
		      <th>Adjunto</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  		@foreach($operations as $operation)
			  		@if(!$operation->isRestricted())
			  		<tr>
			  		  <td>
			  		  	@if($operation->subfamily)
			  		  	<div class="flex items-center text-xs">
			  		  		<span>{{ $operation->subfamily->family->name }}</span>
			  		  		<i class="icon fas fa-angle-right text-gray-500 px-1"></i>
			  		  		<span>{{ $operation->subfamily->name }}</span>
			  		  	</div>
			  		  	@endif
			  		  </td>
			  		  <td>{{ $operation->name }}</td>
			  		  <td>
			  		  	<p class="text-xs text-gray-600">{{ $operation->description }}</p>
			  		  </td>
			  		  <td>{{ $operation->time_in_hours }}</td>
			  		  <td>
			  		  	@if($operation->attachment)
			  		  		<a target="_blank" href="{{ $operation->attachment->getLink() }}">
			  		  			@if($operation->attachment->content_type == 'application/pdf')
			  		  				<i class="fas fa-file-pdf fa-2x text-red-700"></i>
			  		  			@else
			  		  				<img src="{{ $operation->attachment->getLink() }}">
			  		  			@endif
			  		  		</a>
			  		  	@endif
			  		  </td>
			  		  <td>
			  		  	<div class="flex">
			  		  		<form class="mr-2" method="POST" action="{{ route('fleet.maintenance-plans.restrictions.update', $plan->id) }}">
			  		  			@csrf
			  		  			@method('PUT')
			  		  			<input type="hidden" name="operation_id" value="{{ $operation->id }}">
			  		  			<button class="">Excluir</button>
			  		  		</form>

			  		  		<a href="{{ route('fleet.maintenance-plans.operations.edit', [$plan, $operation]) }}" class="mr-3">
			  		  			<i class="icon fas fa-edit"></i>
			  		  		</a>
			  		  		<form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.maintenance-plans.operations.destroy', [$plan, $operation]) }}">
			  		  			@csrf
			  		  			@method('DELETE')
			  		  			<button><i class="icon fas fa-trash-alt"></i></button>
			  		  		</form>
			  		  	</div>
			  		  </td>
			  		</tr>
			  		@endif
		  		@endforeach
		  </tbody>
		</table>
	@endcomponent

	@component('components.card', ['is_table' => true])
		@slot('title', 'Operaciones excluidas')
		<table>
		  <thead>
		    <tr>
		      <th>Área</th>
		      <th>Nombre</th>
		      <th>Descripción</th>
		      <th>Tiempo (hrs)</th>
		      <th>Adjunto</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  		@foreach($operations as $operation)
			  		@if($operation->isRestricted())
			  		<tr>
			  		  <td>
			  		  	@if($operation->subfamily)
			  		  	<div class="flex items-center text-xs">
			  		  		<span>{{ $operation->subfamily->family->name }}</span>
			  		  		<i class="icon fas fa-angle-right text-gray-500 px-1"></i>
			  		  		<span>{{ $operation->subfamily->name }}</span>
			  		  	</div>
			  		  	@endif
			  		  </td>
			  		  <td>{{ $operation->name }}</td>
			  		  <td>
			  		  	<p class="text-xs text-gray-600">{{ $operation->description }}</p>
			  		  </td>
			  		  <td>{{ $operation->time_in_hours }}</td>
			  		  <td>
			  		  	@if($operation->attachment)
			  		  		<a target="_blank" href="{{ $operation->attachment->getLink() }}">
			  		  			@if($operation->attachment->content_type == 'application/pdf')
			  		  				<i class="fas fa-file-pdf fa-2x text-red-700"></i>
			  		  			@else
			  		  				<img src="{{ $operation->attachment->getLink() }}">
			  		  			@endif
			  		  		</a>
			  		  	@endif
			  		  </td>
			  		  <td>
			  		  	<div class="flex">
			  		  		<form class="mr-2" method="POST" action="{{ route('fleet.maintenance-plans.restrictions.update', $plan->id) }}">
			  		  			@csrf
			  		  			@method('PUT')
			  		  			<input type="hidden" name="operation_id" value="{{ $operation->id }}">
			  		  			<button class="">Incluir</button>
			  		  		</form>

			  		  		<a href="{{ route('fleet.maintenance-plans.operations.edit', [$plan, $operation]) }}" class="mr-3">
			  		  			<i class="icon fas fa-edit"></i>
			  		  		</a>
			  		  		<form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.maintenance-plans.operations.destroy', [$plan, $operation]) }}">
			  		  			@csrf
			  		  			@method('DELETE')
			  		  			<button><i class="icon fas fa-trash-alt"></i></button>
			  		  		</form>
			  		  	</div>
			  		  </td>
			  		</tr>
			  		@endif
		  		@endforeach
		  </tbody>
		</table>
	@endcomponent

@endsection
