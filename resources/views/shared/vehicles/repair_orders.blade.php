@component('components.card')
	@slot('title', 'Ordenes de reparación')
	
	@foreach($vehicle->repairOrders()->latest()->get() as $repairOrder)
		<a href="{{ route('fleet.repair-orders.show', $repairOrder) }}">
			<div class="border py-3 px-6 rounded">
				<div class="flex justify-between">
					<div>
						OR #{{$repairOrder->id}}
						<p>{{ $repairOrder->garage->name }}</p>
						<small>{{ $repairOrder->created_at->format('d/m/Y H:i:s') }}</small>
					</div>	
					<div class="flex">
						<div>
							<span class="{{ $repairOrder->state->color }} rounded-full px-3 py-1 text-xs font-medium">
								{{ $repairOrder->state->name }}
							</span>
						</div>
					</div>
				</div>
			</div>
		</a>
		@if(!$loop->last)
			<div class="h-8 w-1 bg-gray-300 ml-6"></div>
		@endif
	@endforeach

@endcomponent