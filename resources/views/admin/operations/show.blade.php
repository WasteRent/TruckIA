@extends('layouts.admin')

@section('content')

	@component('components.card')
		@slot('title', 'Operación')
		@component('components.table')
			@slot('items', [
				'ID' => $operation->id,
				'Fecha' => $operation->created_at,
				'Completada' => $operation->finished ? 'Si':'No'
			])
		@endcomponent
	@endcomponent
	
	@component('components.card')
		@slot('title', 'Datos del vehículo')
		<div class="flex">
			<div class="w-1/2">
				@component('components.table')
					@slot('items', [
						'Matrícula' => $operation->vehicle->plate,
						'Chasis' => $operation->vehicle->chassis,
						'Caja' => $operation->vehicle->box,
						'Kms' => $operation->vehicle->kms,
						'F. matriculación' => $operation->vehicle->registration_date
					])
				@endcomponent
			</div>
			<div class="w-1/2">
				<img src="https://www.modelmotor.es/large/Camion-de-basura-Mercedes-Faun-Variopress-Siku-2938-escala-150-i20408.jpg">
			</div>
		</div>
	@endcomponent

	@component('components.card')
		@slot('title', 'Datos del taller')
		<div class="flex">
			<div class="w-1/2">
				@component('components.table')
					@slot('items', [
						'Nombre' => $operation->garage->name,
						'Email' => $operation->garage->email,
						'Teléfono' => $operation->garage->phone
					])
				@endcomponent
			</div>
			<div class="w-1/2">
				<p class="text-sm text-gray-800 mb-4">
					{{$operation->garage->full_address}}
				</p>
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d47282.447413471076!2d-8.763538118216742!3d42.21117528718119!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xd1688eb921553af5!2sTalleres%20Garc%C3%ADa%20Barreiro%2C%20S.L.!5e0!3m2!1ses!2ses!4v1568141538557!5m2!1ses!2ses" width="100%" height="200" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
			</div>
		</div>
	@endcomponent

	@component('components.card')
		@slot('title', 'Plan de mantenimiento')
		@foreach($operation->maintenance_plan->operations as $operation)
			<div class="flex py-1">
				<div class="w-1/2 flex items-center text-gray-700">
					<ion-icon class="mr-2" name="arrow-dropright"></ion-icon>
					{{$operation->name}}
				</div>
				<div class="w-1/2 flex items-center text-gray-800">
					<ion-icon class="mr-2" name="ios-build"></ion-icon>
					{{$operation->acceptance}}
				</div>
			</div>
			<div class="flex items-center pt-1 pb-3 mb-3 border-b">
				<ion-icon class="mr-2 text-xl text-green-600" name="checkmark"></ion-icon>
				<span class="text-xs text-gray-600 mr-2">2019-11-19 17:55:35</span>
				<ion-icon class="mr-2 text-xl text-gray-700" name="ios-document"></ion-icon>
				<span class="text-xs text-gray-800">Documentación</span>
			</div>
		@endforeach
	@endcomponent

@endsection
