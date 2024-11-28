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
		
			<button id="remove-selected-operations" class="btn-outline-gray mr-2">Borrar seleccionadas</button>
			
			<create-custom-operation endpoint="{{ route('fleet.repair-orders.custom-operation.store', $repair_order) }}"></create-custom-operation>	

			@if(!$repair_order->authorized_at)
			<button  class="btn-outline-gray ml-4" >
				<i class="fas fa-thumbs-up mr-1"> </i><a href="{{route('fleet.repair-orders.authorization', $repair_order)}}"> Autorizar orden</a>
			</button>
			@endif

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
			@slot('title')
				<input type="checkbox" name="plan_{{$plan_ops->first()->maintenance_plan_id}}" class="mr-2">
				{{ $plan_ops->first()->maintenance_plan_name }}
			@endslot
		
			<table>
			  <thead>
			    <tr>
			      <th></th>
			      <th>Descripción</th>
			      <th>Tiempo (hrs)</th>
			      <th></th>
			    </tr>
			  </thead>
			  <tbody>
			  		@foreach($plan_ops as $operation)
			  		<tr>
			  		  <td>
			  		  	<input type="checkbox" name="plan_{{$plan_ops->first()->maintenance_plan_id}}_op_{{$operation->id}}" class="mr-2">
			  		  </td>
			  		  <td>
			  		  	<details>
			  		  	  <summary>
			  		  	  	<span>{{ $operation->operation_family }}</span>
			  		  	  	<i class="icon fas fa-angle-right text-gray-500 px-1"></i>
			  		  	  	<span>{{ $operation->operation_subfamily }}: </span>

			  		  	  	{{ $operation->operation_name }}

			  		  	  	@if($operation->operationAttachment)
			  		  	  		<a href="{{$operation->operationAttachment->getLink()}}" target="_blank">
			  		  	  			<i class="fas fa-question-circle"></i>
			  		  	  		</a>
			  		  	  	@endif
			  		  	  </summary>
			  		  	  <p class="text-xs text-gray-600 max-w-lg">{{ $operation->operation_description }}</p>
			  		  	</details>
			  		  	<!--
			  		  	@include('fleet.repair_orders.operations.parts')
			  		  -->
			  		  </td>
			  		  <td>
			  		  	{{ $operation->real_time_in_hours }}
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
		var items = []
		var endpoint = '{{ route('fleet.repair-orders.operations.destroyAll', $repair_order) }}'

		$("input[name^=plan_]").change(function () {
			if ($(this).is(':checked')) {
				//Full group
				$(`input[name^=${$(this).attr("name")}_op_]`).each(function(i, check) {
					$(check).prop("checked", true)
					items.push($(check).attr('name'))
				})
				//Single item
				items.push($(`input[name=${$(this).attr("name")}]`).attr('name'))
			} else {
				//Full group
				$(`input[name^=${$(this).attr("name")}_op_]`).each(function(i, check) {
					$(check).prop("checked", false)
					items.splice(items.indexOf($(check).attr('name')), 1)
				})
				//Single item
				items.splice(items.indexOf($(`input[name=${$(this).attr("name")}]`).attr('name')), 1)
			}

			items = $.unique(items);
			items = items.filter(function(val) {
				return !/plan_[0-9]+$/gm.test(val);
			});
		});

		$("#remove-selected-operations").click(function() {
			$.ajax({
			    url: endpoint,
			    type: 'DELETE',
			    data: {
			    	operations: items
			    },
			    success: function(result) {
			    	location.reload();
			    }
			});
		})

		$('.autocomplete_price').change(function() {
			var hourly_rate = Number({{ $repair_order->garage?->hourly_price }})
			var price = ($(this).val() * hourly_rate).toFixed(2)
			var element = $(this).closest('form').find('input[name="amount"]')
			element.val(price)
		})
	</script>
	@endpush

@endsection
