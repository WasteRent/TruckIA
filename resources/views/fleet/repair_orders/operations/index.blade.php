@extends('layouts.fleet')

@include('fleet.repair_orders.tabs', ['active_operations' => true])

@section('content')

	@component('components.tabs', [
		'items' => [
			[
				'name' => 'Operaciones',
				'url' => '',
				'active' => true
			],
			[
				'name' => 'Planes de mantenimiento',
				'url' => route('fleet.repair-orders.maintenance-plans.index', $repair_order),
				'active' => false
			]
		]
	])
	@endcomponent

	@component('components.card')
		@slot('corner')	
		<div class="flex">
			<a class="mr-6" href="{{ route('fleet.repair-orders.operations.pdf', $repair_order) }}" target="_blank">
				<i class="fas fa-file-pdf fa-lg text-red-700"></i> Imprimir
			</a>

			<create-custom-operation endpoint="{{ route('fleet.repair-orders.custom-operation.store', $repair_order) }}"></create-custom-operation>	
			<button  class="btn-outline-gray ml-4" >
				<i class="fas fa-thumbs-up mr-1"> </i><a href="{{route('fleet.repair-orders.authorization', $repair_order)}}"> Autorizar orden</a>
			</button>
						
		</div>
		@endslot

		@include('fleet.repair_orders.operations.search', [
			'route' => ['fleet.repair-orders.operations.index', $repair_order]
		])
	@endcomponent

	<div id="search-results">
		@include('fleet.repair_orders.operations.search_results', [
			'add_route' => route('fleet.repair-orders.operations.store', $repair_order)
		])
	</div>
	

	<br>
	
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
			  		  	<p class="text-xs text-gray-600 max-w-lg">{{ $operation->operation_description }}</p>
			  		  </td>
			  		  <td>
			  		  	<form method="POST" action="{{ route('fleet.repair-orders.operations.update', [$repair_order, $operation]) }}">
			  		  		@csrf
			  		  		@method('PUT')
			  		  		<label class="block text-gray-500 text-xs font-medium mb-1">Tiempo dedicado (h)</label>
	  		  		    	{!! Form::number('real_time_in_hours', $operation->real_time_in_hours, ['step' => 'any', 'class' => 'block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-2 px-4 rounded leading-tight mb-2']) !!}
			  		  		<label class="block text-gray-500 text-xs font-medium mb-1">Importe</label>
	  		  		    	{!! Form::number('amount', $operation->amount, ['step' => 'any', 'class' => 'block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-2 px-4 rounded leading-tight mb-2']) !!}
			  		  		<button class="border p-1 rounded">Actualizar</button>
			  		  	</form>
			  		  </td>
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

	@push('js')
	<script type="text/javascript">
		$("#operation_input").keyup(function(e){
			let url = "{{ route('fleet.repair-orders.operations.search', $repair_order) }}";
			let term = $("#operation_input").val();
			let family_id = $("#family_id_input").val();
			$.get(`${url}?family_id=${family_id}&search=${term}`, (data) => $("#search-results").html(data));
		});
	</script>
	@endpush

@endsection
