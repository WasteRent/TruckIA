@component('components.card')
	@slot('title', __('Ordenes de reparación'))
	
	@foreach($garage->repairOrders()->latest()->get() as $repairOrder)
	<a href="{{ route('fleet.repair-orders.show', $repairOrder) }}">
		<div class="border py-3 px-6 rounded">
			<div class="flex justify-between">
				<div>
					@component('components.table')
						@slot('items', [
							__('O.R.') => $repairOrder->id,
							__('Matrícula') => $repairOrder->vehicle ? $repairOrder->vehicle->plate:'',
							__('Vehículo') => '',
							__('Solicitada') => $repairOrder->created_at->format('d/m/Y H:i:s'),
						])
					@endcomponent
				</div>	
				<div class="flex">
					<div>
						<div class="{{ $repairOrder->finished_at ? 'bg-green-200 text-green-800':'bg-red-200 text-red-800' }} rounded-full px-3 py-1 text-xs">
							{{ $repairOrder->finished_at ? __('Completada'):__('Pendiente') }}
						</div>
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