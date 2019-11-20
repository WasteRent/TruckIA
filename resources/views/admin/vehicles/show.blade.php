@extends('layouts.admin')

@section('content')
	
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
						'F. matriculación' => $vehicle->registration_date
					])
				@endcomponent
			</div>
			<div class="w-1/2">
				<img src="https://www.modelmotor.es/large/Camion-de-basura-Mercedes-Faun-Variopress-Siku-2938-escala-150-i20408.jpg">
			</div>
		</div>
	@endcomponent

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
								'Solicitada' => $operation->created_at,
								'Finalizada' => $operation->finished_at,
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

@endsection
