@component('components.card')
	@slot('title', 'Datos del vehículo')
	<div class="flex">
		<div class="w-1/2">
			@component('components.table')
				@slot('items', [
					'Matrícula' => $vehicle->plate,
					'Chasis' => $vehicle->chassis,
					'Caja' => $vehicle->box,
					'Kms' => $vehicle->kms,
					'F. matriculación' => $vehicle->registration_date->format('d/m/Y')
				])
			@endcomponent
		</div>
		<div class="w-1/2">
			<img src="https://www.modelmotor.es/large/Camion-de-basura-Mercedes-Faun-Variopress-Siku-2938-escala-150-i20408.jpg">
		</div>
	</div>
@endcomponent