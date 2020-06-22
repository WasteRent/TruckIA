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
	
@endif

@component('components.card', ['is_table' => true])
	@slot('title', 'Operaciones incluídas')
	
	@slot('corner')
		<a class="mr-6" href="{{ route('fleet.repair-orders.operations.pdf', $repair_order) }}" target="_blank">
			<i class="fas fa-file-pdf fa-lg text-red-700"></i> Imprimir
		</a>
	@endslot

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
	  		@foreach($operations as $operation)
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



@endsection
