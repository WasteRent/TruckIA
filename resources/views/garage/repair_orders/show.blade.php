@extends('layouts.garage')

@section('progress')
	<div class="mb-8">
		@include('shared.steps', [
			'steps' => [
				[
					'name' => 'Vehículo',
					'url' => route('garage.repair-orders.vehicle', $repair_order),
					'active' => false,
					'icon' => 'fas fa-bus-alt'
				],
				[
					'name' => 'Operaciones',
					'url' => route('garage.repair-orders.operations.index', $repair_order),
					'active' => false,
					'icon' => 'fas fa-cogs'
				],
				[
					'name' => 'Autorización',
					'url' => route('garage.repair-orders.authorization', $repair_order),					'active' => false,
					'icon' => 'fas fa-rocket'
				],
				[
					'name' => 'Resumen',
					'url' => route('garage.repair-orders.show', $repair_order),
					'active' => true,
					'icon' => 'fas fa-clipboard'
				]
			]
		])
	</div>
@endsection

@section('content')

	<div class="text-right mb-8">
		<a href="{{ route('garage.show.operation', [$repair_order, $repair_order->operations->first()]) }}" class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
		  Continuar
		</a>
	</div>

	@component('components.card')
		@slot('title', 'Orden de Reparación')
		@component('components.table')
			@slot('items', [
				'ID' => $repair_order->id,
				'Fecha' => $repair_order->created_at->format('d/m/Y H:i:s'),
				'Observaciones' => $repair_order->remarks,
			])
		@endcomponent
	@endcomponent
	
	@include('shared.vehicles.show', ['vehicle' => $repair_order->vehicle])

	@component('components.card')
		@slot('title', 'Operaciones')
		@slot('corner')
			<a href="{{ route('garage.show.operation', [$repair_order, $repair_order->operations->first()]) }}" class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
			  Continuar
			</a>
		@endslot

		<table class="table-auto w-full">
		  <thead>
		    <tr>
		      <th class="px-4 py-2">Descripción</th>
		      <th class="px-4 py-2">Estado</th>
		      <th class="px-4 py-2">Horas</th>
		      <th class="px-4 py-2">Total</th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($repair_order->operations as $operation)
		    <tr>
		      <td class="border px-4 py-2">
		      	<div class="text-gray-700 py-1">
		      		{{ $operation->code }} &middot; {{ $operation->name }}
		      		<p class="text-sm text-gray-600">{{ $operation->description }}</p>
		      	</div>
		      </td>
		      <td class="border px-4 py-2">
		      	<div class="flex items-center">
		      		@if($operation->pivot->completed)
		      			<i class="fas fa-check fa-xs text-green-600 mr-1"></i>

		      			<span class="text-xs text-gray-600 mr-2">
		      				{{ Carbon\Carbon::parse($operation->pivot->completed_at)->format('d/m/Y H:i:s') }}
		      			</span>

		      			@if($operation->pivot->file)
		      				<a href="{{ Storage::url('truckts/mantenimientos/operaciones/'.$operation->pivot->file) }}">
		      					<i class="fas fa-cloud-download-alt"></i>
		      				</a>
		      			@endif
		      		@else	
		      			<i class="fas fa-exclamation-circle fa-xs text-red-600 mr-1"></i>
		      		@endif
		      	</div>
		      </td>
		      <td class="border px-4 py-2 text-center">{{ $operation->pivot->real_time_in_hours }}</td>
		      <td class="border px-4 py-2 text-right">{{ number_format($operation->pivot->real_time_in_hours * $repair_order->garage->hourly_price, 2) }}&euro;</td>
		    </tr>
		    @endforeach
		    <tr>
		    	<td></td>
		    	<td></td>
		    	<td class="border px-4 py-2 text-center"><span class="font-medium">Total</span></td>
		    	<td class="border px-4 py-2 text-right">
		    		{{ number_format($repair_order->getInvoiceAmount(), 2, ',', '.') }}&euro;
		    	</td>
		    </tr>
		  </tbody>
		</table>
	@endcomponent


@endsection
