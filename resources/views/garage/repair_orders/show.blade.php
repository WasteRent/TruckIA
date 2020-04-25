@extends('layouts.garage')

@include('garage.repair_orders.tabs', ['active_summary' => true])

@section('content')
	
	@component('components.card')
		@slot('title', 'Orden de Reparación')

		@if($repair_order->isAuthorized() && !$repair_order->isFinished())
			@slot('corner')
				<a href="{{ route('garage.show.operation', [$repair_order, $repair_order->operations->first()]) }}" class="btn-indigo">
				  Continuar Reparación
				</a>
			@endslot
		@endif
	
		@component('components.table')
			@slot('items', [
				'ID' => $repair_order->id,
				'Fecha' => $repair_order->created_at->format('d/m/Y H:i:s'),
				'Observaciones' => $repair_order->remarks,
			])
		@endcomponent
	@endcomponent
	
	@include('shared.repair_orders.appointment', ['repair_order' => $repair_order])


	@if($repair_order->type == 'pre-itv')
		@include('garage.repair_orders.itv')
	@endif

	@component('components.card', ['is_table' => true])
		@slot('title', 'Operaciones')

		@if($repair_order->isAuthorized() && !$repair_order->isFinished())
			@slot('corner')
				<a href="{{ route('garage.show.operation', [$repair_order, $repair_order->operations->first()]) }}" class="btn-indigo">
				  Continuar Reparación
				</a>
			@endslot
		@endif

		<table>
		  <thead>
		    <tr>
		      <th>Descripción</th>
		      <th>Estado</th>
		      <th>H. Estimadas</th>
		      <th>H. Reales</th>
		      <th>Total</th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($repair_order->operations as $operation)
		    <tr>
		      <td>
		      	<div class="text-gray-700 py-1">
		      		{{ $operation->operation_code }} &middot; {{ $operation->operation_name }}
		      		<p class="text-sm text-gray-600">{{ $operation->operation_description }}</p>
		      	</div>
		      </td>
		      <td>
		      	<div class="flex items-center">
		      		@if($operation->isCompleted())
		      			<i class="fas fa-check fa-xs text-green-600 mr-1"></i>
		      			<span class="text-xs text-gray-600 mr-2">
		      				{{ Carbon\Carbon::parse($operation->completed_at)->format('d/m/Y H:i:s') }}
		      			</span>
		      			@if($operation->file)
		      				<a href="{{ $operation->file->getLink() }}">
		      					<i class="fas fa-cloud-download-alt"></i>
		      				</a>
		      			@endif
		      		@else	
		      			<i class="fas fa-exclamation-circle fa-xs text-red-600 mr-1"></i>
		      			Pendiente
		      		@endif
		      	</div>
		      	<p class="text-xs mt-1">
		      		{{ $operation->garage_observations }}
		      	</p>
		      </td>
		      <td class="text-center">{{ $operation->estimated_time_in_hours }}</td>
		      <td class="text-center">{{ $operation->real_time_in_hours }}</td>
		      <td class="text-right">{{ $operation->getAmount() }}&euro;</td>
		    </tr>
		    @endforeach
		    <tr>
		    	<td></td>
		    	<td></td>
		    	<td></td>
		    	<td class="text-center"><span class="font-medium">Total</span></td>
		    	<td class="text-right">
		    		{{ number_format($repair_order->getAmount(), 2, ',', '.') }}&euro;
		    	</td>
		    </tr>
		  </tbody>
		</table>
	@endcomponent


@endsection
