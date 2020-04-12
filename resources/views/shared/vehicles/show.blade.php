@component('components.card')
	@slot('title', 'Datos del vehículo')
	
	@if(Auth::user()->hasRole('fleet'))
		@slot('corner')
			<a href="{{ route('fleet.vehicles.edit', $vehicle) }}" class="btn-outline-gray">Ver ficha completa</a>
		@endslot
	@endif

	<div class="flex">
		<div class="w-1/2">
			@php 
				$equipments = "";
				foreach($vehicle->equipments as $equipment){
					$equipments .= "{$equipment->type} {$equipment->maker->name} {$equipment->model->name}<br>";
				}
			@endphp

			@component('components.table')
				@slot('items', [
					'Matrícula' => $vehicle->plate,
					'Tipo' => optional($vehicle->type)->name,
					'Chasis' => $vehicle->chassis,
					'Equipo' => $equipments
				])
			@endcomponent
		</div>
		<div class="w-1/2">
			@if($vehicle->pictures->count() > 0)
				<img src="{{ $vehicle->pictures->first()->getLink() }}">
			@else
				<i class="fas fa-image text-gray-300" style="font-size: 12rem;"></i>
			@endif
		</div>
	</div>
@endcomponent