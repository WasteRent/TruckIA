@component('components.card')
	@slot('title', 'Ordenes de reparación')
	
	@foreach($vehicle->repairOrders()->latest()->get() as $repairOrder)
		<div class="border py-3 px-6 rounded">
			<div class="flex">
				<div class="w-1/2">
					<a href="{{ route('fleet.repair-orders.show', $repairOrder) }}">
						<span class="{{ $repairOrder->state->color }} rounded-full px-3 py-1 text-xs font-medium">
							{{ $repairOrder->state->name }}
						</span>

						<div class="my-3"></div>

						<span class="text-gray-600">OR</span> #{{$repairOrder->id}}
						<p class="text-xs uppercase font-medium">{{$repairOrder->formattedType()}}</p>
						<small class="text-gray-600">{{ $repairOrder->created_at->format('d/m/Y H:i:s') }}</small>

						@if(!empty($repairOrder->internal_notes))
						<p class="text-gray-700 mt-3">
							Nota: {{$repairOrder->internal_notes}}
						</p>
						@endif
					</a>
				</div>
				<div class="w-1/2">
					<p class="form-label">Mantenimientos</p>
					<ul class="text-gray-700">
						@foreach($repairOrder->operations->pluck('maintenance_plan_name')->unique() as $plan)
						<li>{{$plan}}</li>
						@endforeach
					</ul>
					<repair-order-operations :operations="{{ $repairOrder->operations->toJson() }}"></repair-order-operations>
				</div>
			</div>
		</div>
		@if(!$loop->last)
			<div class="h-8 w-1 bg-gray-300 ml-6"></div>
		@endif
	@endforeach

@endcomponent