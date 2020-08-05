@if(count($operations_search) > 0)
	@component('components.card', ['is_table' => true])
		@slot('title', 'Añadir operaciones')
		<table >
		  <thead >
		    <tr >
		      <th>Código</th>
		      <th>Descripción</th>
		      <th>Tiempo (hrs)</th>
		      <th></th>
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
		  	  	{!! $operation->name !!}
		  	  	<p class="text-xs text-gray-600">{!! $operation->description !!}</p>
		  	  </td>
		  	  <td>{{ $operation->time_in_hours }}</td>
		  	  <td>
  	  		  	<form method="POST" action="{{ route('fleet.repair-orders.operations.store', $repair_order) }}">
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