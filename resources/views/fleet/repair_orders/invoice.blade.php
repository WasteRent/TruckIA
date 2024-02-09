@extends('layouts.pdf')

@section('content')
	<div class="text-xl">
	  <span class="font-bold mr-4">OR #{{$repair_order->id}}</span> {{Carbon\Carbon::parse($repair_order->finished_at)->format('d/m/Y H:i')}}
	</div>

	<p class="text-lg mb-4">
	  {{$repair_order->vehicle->plate }}
	  {{$repair_order->vehicle->chassis }} &middot;
	  @foreach($repair_order->vehicle->equipments as $equipment)
	  {{$equipment->maker?->name}} {{$equipment->model?->name}}
	  @endforeach
	</p>


	<h1 class="font-bold mt-4">Mano de Obra</h1>

	<table class="table-auto">
	  <thead>
	    <tr>
	      <th class="px-4 py-2">Descripción</th>
	      <th class="px-4 py-2">Tiempo (h)</th>
	      <th class="px-4 py-2">Importe &euro;</th>
	    </tr>
	  </thead>
	  <tbody>
	      @foreach($repair_order->operations->groupBy('maintenance_plan_name') as $plan => $operations)
	        <tr>
	          <td class="border px-4 py-2">
	            <strong>{{ $plan }}</strong>
	          </td>
	          <td class="border px-4 py-2">
	            {{ number_format($operations->sum('real_time_in_hours'), 2, ',', '') }}
	          </td>
	          <td class="border px-4 py-2">
	            {{ number_format($operations->sum('amount'), 2, ',', '') }}
	          </td>
	        </tr>
	      @endforeach
			<tr>
				<td class="border px-4 py-2 text-right"><strong>Total</strong></td>
				<td class="border px-4 py-2">
				  {{ number_format($repair_order->operations->sum('real_time_in_hours'), 2, ',', '.') }}
				</td>
				<td class="border px-4 py-2">
				  {{ number_format($repair_order->operations->sum('amount'), 2, ',', '.') }}
				</td>
			</tr>
	  </tbody>
	</table>

	<h1 class="font-bold mt-4">Recambios</h1>

	<table class="table-auto">
	  <thead>
	    <tr>
	      <th class="px-4 py-2">Descripción</th>
	      <th class="px-4 py-2">Gama</th>
	      <th class="px-4 py-2">Cantidad</th>
	      <th class="px-4 py-2">Importe &euro;</th>
	    </tr>
	  </thead>
	  <tbody>
	      @foreach($repair_order->parts as $part)
	        <tr>
	          <td class="border px-4 py-2">
	            {{ $part->manufacturer }} {{ $part->reference }} &middot; <strong>{{ $part->description }}</strong>
	          </td>
	          <td class="border px-4 py-2">
	          	@if($part->operation && $part->operation->maintenance_plan)
	          		{{ $part->operation->maintenance_plan->fullname }}
	          	@endif
	          </td>
	          <td class="border px-4 py-2">
	            {{ number_format($part->quantity, 2, ',', '') }}
	          </td>
	          <td class="border px-4 py-2">
	            {{ number_format($part->total_price, 2, ',', '') }}
	          </td>
	        </tr>
	      @endforeach
	      	<tr>
			  <td class="border px-4 py-2"></td>
			  <td class="border px-4 py-2"></td>
	          <td class="border px-4 py-2"><strong>Total</strong></td>
	          <td class="border px-4 py-2">
	            <strong>{{ number_format($repair_order->parts->sum('total_price'), 2, ',', '') }}</strong>
	          </td>
	      	</tr>
	  </tbody>
	</table>

	<div class="text-right text-lg mt-6">
		<span class="font-medium">Total: </span>
		<span class="font-extrabold">
			{{ 
				number_format($repair_order->operations->sum('amount') + $repair_order->parts->sum('total_price'), 2, ',', '') 
			}}
		&euro;</span>
	</div>

@endsection
