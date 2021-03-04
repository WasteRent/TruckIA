<div class="">
	@if($plan->kms)
		<div class="flex">
			<div class="w-1/4">{{ $plan->kms }} kms</div>
			<div class="w-3/4">
				@include('fleet.vehicles.counters.progress-slim', [
					'counter' => $repair_order->vehicle->counters
									->where('type', 'kms')
									->where('vehicle_category', $plan->vehicle_category)
									->where('max', $plan->kms)
									->first()
				])
			</div>
		</div>
	@endif	
	@if($plan->natural_hours)
		<div class="flex">
			<div class="w-1/4">{{ $plan->natural_hours }} Horas Naturales</div>
			<div class="w-3/4">
				@include('fleet.vehicles.counters.progress-slim', [
					'counter' => $repair_order->vehicle->counters
							->where('type', 'natural_hours')
							->where('max', $plan->natural_hours)
							->where('vehicle_category', $plan->vehicle_category)
							->first()
					])
			</div>
		</div>
	@endif
	@if($plan->can_hours)
		<div class="flex">
			<div class="w-1/4">{{ $plan->can_hours }} Horas CAN</div>
			<div class="w-3/4">
				@include('fleet.vehicles.counters.progress-slim', [
					'counter' => $repair_order->vehicle->counters
								->where('type', 'work_hours')
								->where('max', $plan->can_hours)
								->where('vehicle_category', $plan->vehicle_category)
								->first()
				])
			</div>
		</div>
	@endif
	@if($plan->grua_hours)
		<div class="flex">
			<div class="w-1/4">{{ $plan->grua_hours }} Horas Uso Grua</div>
			<div class="w-3/4">
				@include('fleet.vehicles.counters.progress-slim', [
					'counter' => $repair_order->vehicle->counters
								->where('type', 'work_hours')
								->where('max', $plan->grua_hours)
								->where('vehicle_category', $plan->vehicle_category)
								->first()
				])
			</div>
		</div>
	@endif
</div>