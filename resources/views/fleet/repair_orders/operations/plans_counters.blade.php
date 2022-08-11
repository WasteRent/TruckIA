<div class="">
	@if($plan->kms)
		<div class="flex">
			@php
			$counter = $repair_order->vehicle->counters
								->where('plan_id', $plan->id)
								->where('type', 'kms')
								->first()
			@endphp
			<div class="w-1/4">{{ optional($counter)->max }} kms</div>
			<div class="w-3/4">
				@include('fleet.vehicles.counters.progress-slim', [
					'counter' => $counter
				])
			</div>
		</div>
	@endif	
	@if($plan->natural_hours)
		<div class="flex">
			@php
			$counter = $repair_order->vehicle->counters
							->where('plan_id', $plan->id)
							->where('type', 'natural_hours')
							->first();
			@endphp			
			<div class="w-1/4">{{ optional($counter)->max }} Horas Naturales</div>
			<div class="w-3/4">
				@include('fleet.vehicles.counters.progress-slim', [
					'counter' => $counter
					])
			</div>
		</div>
	@endif
	@if($plan->can_hours)
		<div class="flex">
			@php
			$counter = $repair_order->vehicle->counters
								->where('plan_id', $plan->id)
								->where('type', 'work_hours')
								->first();
			@endphp
			<div class="w-1/4">{{ optional($counter)->max }} Horas CAN</div>
			<div class="w-3/4">
				@include('fleet.vehicles.counters.progress-slim', [
					'counter' => $counter
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
								->where('plan_id', $plan->id)
								->where('type', 'work_hours')
								->first()
				])
			</div>
		</div>
	@endif
</div>