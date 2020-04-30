@extends('layouts.fleet')

@include('fleet.repair_orders.tabs', ['active_operations' => true])

@section('content')

@if(!$repair_order->isAuthorized())
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
	
	@component('components.search-card')
		@include('fleet.repair_orders.operations.search', ['route' => ['fleet.repair-orders.operations.index', $repair_order]])
	@endcomponent

	<div id="search-results">
		@include('fleet.repair_orders.operations.search_results')
	</div>

	<br><br>
@endif

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


@push('js')
<script type="text/javascript">
	$("#operation_input").keyup(function(e){
		let url = "{{ route('fleet.repair-orders.operations.search', $repair_order) }}";
		let term = $("#operation_input").val();
		$.get(`${url}?search=${term}`, (data) => $("#search-results").html(data));
	});
</script>
@endpush

@endsection
