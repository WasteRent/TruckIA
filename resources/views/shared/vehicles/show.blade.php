@component('components.card')
	@slot('title', 'Datos del vehículo')
	<div class="flex">
		<div class="w-1/2">
			@component('components.table')
				@slot('items', [
					'Matrícula' => $vehicle->plate,
					'Chasis' => $vehicle->chassis . ' (Garantía '.  Carbon\Carbon::parse($vehicle->warranty_chassis)->format('d/m/Y') . ')',
					'Equipo' => $vehicle->equipment . ' (Garantía '.  Carbon\Carbon::parse($vehicle->warranty_equipment1)->format('d/m/Y') . ')',
					'Equipo2' => $vehicle->equipment2 . ' (Garantía '.  Carbon\Carbon::parse($vehicle->warranty_equipment2)->format('d/m/Y') . ')',
					'Equipo3' => $vehicle->equipment3 . ' (Garantía '.  Carbon\Carbon::parse($vehicle->warranty_equipment3)->format('d/m/Y') . ')',
					'Kms' => $vehicle->kms,
					'F. matriculación' => Carbon\Carbon::parse($vehicle->registration_date)->format('d/m/Y')
				])
			@endcomponent
		</div>
		<div class="w-1/2">
			@if($vehicle->pictures->count() > 0)
				<img src="{{ $vehicle->pictures->first()->getLink() }}">
			@else
				<a href="{{ route('admin.vehicles.pictures.index', $vehicle) }}">
					<img class="w-1/2" src="{{ asset('img/image-placeholder.jpg') }}">
				</a>
			@endif
		</div>
	</div>
@endcomponent