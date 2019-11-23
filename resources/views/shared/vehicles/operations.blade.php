@component('components.card')
	@slot('title', 'Operaciones')
	
	@foreach($vehicle->operations()->latest()->get() as $operation)
		<div class="border py-3 px-6 rounded">
			<div class="flex justify-between">
				<div>
					@component('components.table')
						@slot('items', [
							'Taller' => $operation->garage->name,
							'Plan de mant.' => $operation->maintenance_plan->name,
							'Solicitada' => $operation->created_at->format('d/m/Y H:i:s'),
							'Finalizada' => $operation->finished_at
						])
					@endcomponent
				</div>	
				<div class="flex">
					<div>
						<div class="{{ $operation->completed ? 'bg-green-200 text-green-800':'bg-red-200 text-red-800' }} rounded-full px-3 py-1 text-xs">
							{{ $operation->completed ? 'Completada':'Pendiente' }}
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