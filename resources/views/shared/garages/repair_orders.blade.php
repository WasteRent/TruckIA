@component('components.card')
	@slot('title', 'Ordenes de reparación')
	
	@foreach($garage->repairOrders()->latest()->get() as $repairOrder)
		<div class="border py-3 px-6 rounded">
			<div class="flex justify-between">
				<div>
					@component('components.table')
						@slot('items', [
							'Flota' => $repairOrder->vehicle ? $repairOrder->vehicle->fleet->name:'',
							'Matrícula' => $repairOrder->vehicle ? $repairOrder->vehicle->plate:'',
							'Vehículo' => '',
							'Solicitada' => $repairOrder->created_at->format('d/m/Y H:i:s'),
							'Finalizada' => $repairOrder->finished_at
						])
					@endcomponent
				</div>	
				<div class="flex">
					<div>
						<div class="{{ $repairOrder->completed ? 'bg-green-200 text-green-800':'bg-red-200 text-red-800' }} rounded-full px-3 py-1 text-xs">
							{{ $repairOrder->completed ? 'Completada':'Pendiente' }}
						</div>
					</div>
				</div>
			</div>
		</div>
		@if(!$loop->last)
			<div class="h-8 w-1 bg-gray-300 ml-6"></div>
		@endif
	@endforeach

@endcomponent