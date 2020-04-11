@extends('layouts.garage')

@include('garage.repair_orders.tabs', ['active_operations' => true])

@section('content')
	@if($repair_order->creator_user_id == Auth::user()->id)
		@component('components.tabs', [
			'items' => [
				[
					'name' => 'Operaciones',
					'url' => '',
					'active' => true
				],
				[
					'name' => 'Planes de mantenimiento',
					'url' => route('garage.repair-orders.maintenance-plans.index', $repair_order),
					'active' => false
				]
			]
		])
		@endcomponent
		
		@component('components.search-card')
			@include('admin.operations.search', ['route' => ['garage.repair-orders.operations.index', $repair_order]])
		@endcomponent

		@if(count($operations_search) > 0)
			@component('components.card', ['is_table' => true])
				@slot('title', 'Añadir operaciones')
				<table >
				  <thead >
				    <tr >
				      <td>Código</td>
				      <td>Descripción</td>
				      <td>Tiempo (hrs)</td>
				      <td></td>
				    </tr>
				  </thead>
				  <tbody>
				  	@foreach($operations_search as $operation)
				  	<tr >
				  	  <td>
				  	  	<span class="uppercase">{{ $operation->code }}</span>
				  	  	<div class="flex items-center flex-wrap text-xs">
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

				  	  	@if($operation->spareParts->count() > 0)
				  	  	<fieldset class="text-xs mt-4 border p-2 rounded">
				  	  		<legend class="mx-1 text-gray-600">Recambios</legend>
				  	  		<ul>
				  	  		@foreach($operation->sparePartsGrouped() as $spare_part)
				  	  			<li>
				  	  				@if($spare_part->units > 1)
				  	  					<span style="padding: 0.1rem;" class="bg-gray-300 text-gray-700 rounded-full">{{ $spare_part->units }}x</span>
				  	  				@endif
				  	  				{{ $spare_part->reference }} &middot; {{ $spare_part->description }}
				  	  			</li>
				  	  		@endforeach
				  	  		</ul>
				  	  	</fieldset>
				  	  	@endif
				  	  </td>
				  	  <td>{{ $operation->time_in_hours }}</td>
				  	  <td>
		  	  		  	<form method="POST" action="{{ route('garage.repair-orders.operations.store', $repair_order) }}">
		  	  		  		@csrf
		  	  		  		<input type="hidden" name="operation_id" value="{{ $operation->id }}">
		  	  		  		<button><i class="icon fas fa-plus-circle"></i></button>
		  	  		  	</form>
				  	  </td>
				  	</tr>
				  	@endforeach
				  </tbody>
				</table>
			@endcomponent
		@endif
		<br><br>
	@endif

	@if($operations->count() > 0)		
		@component('components.card', ['is_table' => true])
			@slot('title', 'Operaciones incluídas')
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
			  		@foreach($operations as $operation)
			  		<tr>
			  		  <td>
			  		  	<span class="uppercase">{{ $operation->operation_code }}</span>
			  		  	<div class="flex items-center text-xs">
			  		  		<span>{{ $operation->operation_family }}</span>
			  		  		<i class="icon fas fa-angle-right text-gray-500 px-1"></i>
			  		  		<span>{{ $operation->operation_subfamily }}</span>
			  		  	</div>
			  		  </td>
			  		  <td>
			  		  	{{ $operation->operation_name }}
			  		  	<p class="text-xs text-gray-600">{{ $operation->operation_description }}</p>
			  		  </td>
			  		  <td>{{ $operation->estimated_time_in_hours }}</td>
			  		  <td>
			  		  	@if($repair_order->creator_user_id == Auth::user()->id)
			  		  	<form method="POST" onsubmit="return confirmDelete()" action="{{ route('garage.repair-orders.operations.destroy', [$repair_order, $operation]) }}">
			  		  		@csrf
			  		  		@method('DELETE')
			  		  		<button><i class="icon fas fa-trash-alt"></i></button>
			  		  	</form>
			  		  	@endif
			  		  </td>
			  		</tr>
			  		@endforeach
			  </tbody>
			</table>
		@endcomponent
	@else
		@component('components.no-results')
			No hay operaciones
		@endcomponent
	@endif

@endsection
