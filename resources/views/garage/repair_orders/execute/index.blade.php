@extends('layouts.garage')

@section('title', 'Orden de Reparación #' . $repair_order->id)

@section('content')
	<div class="flex">
		<div class="w-3/12 mr-6 mt-6">
			@include('garage.repair_orders.execute.sidebar')
		</div>
		<div class="w-full">
			@include('garage.repair_orders.execute.progress')
			<br>

			@component('components.card')
				@slot('title', $current_operation->code . ' : ' . $current_operation->name)

				@component('components.table')
					@slot('items', [
						'Vehículo' => $repair_order->vehicle->getChassisAttribute() . ' / ' . $repair_order->vehicle->getBoxAttribute(),
						'Área' => $current_operation->family->name,
						'Descripción' => $current_operation->description,
						'Tiempo estimado (h)' => $current_operation->time_in_hours
					])
				@endcomponent
			@endcomponent

			@component('components.card')
				@if(empty($current_operation->pivot->completed_at))
					@include('garage.repair_orders.execute.create')
				@else
					@include('garage.repair_orders.execute.edit')
				@endif
			@endcomponent
		</div>
	</div>
@endsection
