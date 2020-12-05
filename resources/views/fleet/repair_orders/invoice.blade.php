@extends('layouts.pdf')

@section('content')
	<div class="text-xl">
	  <span class="font-bold mr-4">OR #{{$repair_order->id}}</span> {{Carbon\Carbon::parse($repair_order->finished_at)->format('d/m/Y H:i')}}
	</div>

	<p class="text-lg mb-4">
	  {{$repair_order->vehicle->plate }}
	  {{$repair_order->vehicle->chassis }} &middot;
	  @foreach($repair_order->vehicle->equipments as $equipment)
	  {{$equipment->maker->name}} {{$equipment->model->name}}
	  @endforeach
	</p>


	<h1 class="font-bold mt-4">Operaciones</h1>

	<table class="table-auto">
	  <thead>
	    <tr>
	      <th class="px-4 py-2">Descripción</th>
	      <th class="px-4 py-2">Tiempo (h)</th>
	      <th class="px-4 py-2">Importe</th>
	    </tr>
	  </thead>
	  <tbody>
	      @foreach($repair_order->operations as $operation)
	        <tr>
	          <td class="border px-4 py-2">
	            <strong>{{ $operation->operation_name }}</strong>
	          </td>
	          <td class="border px-4 py-2">
	            {{ (float)$operation->real_time_in_hours }}h
	          </td>
	          <td class="border px-4 py-2">
	            {{ $operation->getAmount() }}&euro;
	          </td>
	        </tr>
	      @endforeach
			<tr>
				<td class="border px-4 py-2"></td>
				<td class="border px-4 py-2"><strong>Total</strong></td>
				<td class="border px-4 py-2">
					<strong>{{ $repair_order->getAmount() }}&euro;</strong>
				</td>
			</tr>
	  </tbody>
	</table>

	<h1 class="font-bold mt-4">Recambios</h1>

	<table class="table-auto">
	  <thead>
	    <tr>
	      <th class="px-4 py-2">Descripción</th>
	      <th class="px-4 py-2">Cantidad</th>
	      <th class="px-4 py-2">Importe</th>
	    </tr>
	  </thead>
	  <tbody>
	      @foreach($repair_order->parts as $part)
	        <tr>
	          <td class="border px-4 py-2">
	            {{ $part->manufacturer }} {{ $part->reference }} &middot; <strong>{{ $part->description }}</strong>
	          </td>
	          <td class="border px-4 py-2">
	            {{ $part->quantity }}
	          </td>
	          <td class="border px-4 py-2">
	            {{ $part->total_price }}&euro;
	          </td>
	        </tr>
	      @endforeach
	      	<tr>
			  <td class="border px-4 py-2"></td>
	          <td class="border px-4 py-2"><strong>Total</strong></td>
	          <td class="border px-4 py-2">
	            <strong>{{ $repair_order->parts->sum('total_price') }}&euro;</strong>
	          </td>
	      	</tr>
	  </tbody>
	</table>

	<div class="text-right text-lg mt-6">
		<span class="font-medium">Total: </span>
		<span class="font-extrabold">{{ $repair_order->getAmount() + $repair_order->parts->sum('total_price') }}&euro;</span>
	</div>

@endsection
