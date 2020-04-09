@include('fleet.vehicles.tracking')

@component('components.card')
	@slot('title', 'Datos del vehículo')
	@slot('corner')
		<a href="{{ route('fleet.vehicles.edit', $vehicle) }}" class="btn-outline-gray">Ver ficha completa</a>
	@endslot

	<div class="flex">
		<div class="w-1/2">
			@component('components.table')
				@slot('items', [
					'Matrícula' => $vehicle->plate,
					'Vehículo' => $vehicle->chassis,
					'Tipo' => optional($vehicle->type)->name,
					'F. matriculación' => Carbon\Carbon::parse($vehicle->registration_date)->format('d/m/Y')
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