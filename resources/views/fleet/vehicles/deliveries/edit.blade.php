@extends('layouts.fleet')

@section('title', 'Nuevo albarán de entrega')

@section('content')
	<div class="grid grid-cols-2 gap-4">
		<div class="flex">
			@component('components.card')
				@slot('title', __('Datos del vehículo'))
				@php
					$vehicle = auth()->user()->fleet->vehicles->first();
				@endphp

				<div>
					@php 
						$equipments = "";
						foreach($vehicle->equipments as $equipment){
							$equipments .= "{$equipment->type} {$equipment->maker->name} {$equipment->model->name}<br>";
						}
					@endphp
					@component('components.table')
						@slot('items', [
							__('Matrícula') => $vehicle->plate,
							__('Tipo') => optional($vehicle->type)->name,
							__('Chasis') => $vehicle->chassis,
							__('Equipo') => $equipments,
							__('Estado') => $vehicle->customer ? ($vehicle->state->name . ' - ' . $vehicle->customer->name) : optional($vehicle->state)->name,
							__('Fecha de fabricación') => $vehicle->manufacturing_date ? Carbon\Carbon::parse($vehicle->manufacturing_date)->format('d/m/Y'):null,
							__('Ubicación') => $vehicle->location,
						])
					@endcomponent
				</div>
			@endcomponent
		</div>
		<div class="flex">
			@component('components.card')
				@slot('title', __('Datos del cliente'))
				@php
					$customer = App\Models\Customer::first();
				@endphp

				<div class="">
					@component('components.table')
						@slot('items', [
							__('Nombre') => $customer->name,
							__('Empresa') => optional($customer->enterprise)->name,
						])
					@endcomponent
				</div>
			@endcomponent
		</div>
	</div>
	
	@component('components.card')
		<div class="grid grid-cols-3">
			<div class="col-span-2 mr-4">
				<div class="mb-8 flex">
					<div>
					  <label class="text-base font-medium text-gray-900">Tipo</label>
					  <fieldset class="mt-4 border-0 px-0">
					    <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
					      <div class="flex items-center">
					        <input id="email" name="notification-method" type="radio" checked class="focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300">
					        <label for="email" class="ml-3 block text-sm font-medium text-gray-700"> Entrega </label>
					      </div>
					      <div class="flex items-center">
					        <input id="sms" name="notification-method" type="radio" class="focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300">
					        <label for="sms" class="ml-3 block text-sm font-medium text-gray-700"> Devolución </label>
					      </div>
					    </div>
					  </fieldset>
				  	</div>
			  		<div class="pl-12">
			  			<label class="text-base font-medium text-gray-900">Fecha</label>
			  			<input type="text" name="" class="mt-1.5 form-input datepicker" value="{{ now()->format('Y-m-d') }}">
			  	  	</div>
				</div>

				<div>
					<label class="text-base font-medium text-gray-900">Observaciones</label>
					<x-trix class="mb-8" name="comments"></x-trix>
				</div>

				<div class="mb-8">
				  <label class="text-base font-medium text-gray-900">Nivel de combustible</label>
				  <fieldset class="mt-4 border-0 px-0">
				    <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
				      <div class="flex items-center">
				        <input id="email" name="notification-method" type="radio" checked class="focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300">
				        <label for="email" class="ml-3 block text-sm font-medium text-gray-700"> Vacío </label>
				      </div>
				      <div class="flex items-center">
				        <input id="sms" name="notification-method" type="radio" class="focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300">
				        <label for="sms" class="ml-3 block text-sm font-medium text-gray-700"> 1/4 </label>
				      </div>

				      <div class="flex items-center">
				        <input id="push" name="notification-method" type="radio" class="focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300">
				        <label for="push" class="ml-3 block text-sm font-medium text-gray-700"> 1/2 </label>
				      </div>

				      <div class="flex items-center">
				        <input id="push" name="notification-method" type="radio" class="focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300">
				        <label for="push" class="ml-3 block text-sm font-medium text-gray-700"> 3/4 </label>
				      </div>

				      <div class="flex items-center">
				        <input id="push" name="notification-method" type="radio" class="focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300">
				        <label for="push" class="ml-3 block text-sm font-medium text-gray-700"> Full </label>
				      </div>
				    </div>
				  </fieldset>
				</div>


				<div>
					<label class="text-base font-medium text-gray-900">Estado</label>
					<fieldset class="space-y-5 mt-4 border-0 px-0">
					  <div class="relative flex items-start">
					    <div class="flex items-center h-5">
					      <input id="comments" aria-describedby="comments-description" name="comments" type="checkbox" class="focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300 rounded">
					    </div>
					    <div class="ml-3 text-sm">
					      <label for="comments" class="font-medium text-gray-700">Neumáticos delanteros</label>
					      <p id="comments-description" class="text-gray-500">Comprobar buen estado y presiones.</p>
					    </div>
					  </div>
					  <div class="relative flex items-start">
					    <div class="flex items-center h-5">
					      <input id="candidates" aria-describedby="candidates-description" name="candidates" type="checkbox" class="focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300 rounded">
					    </div>
					    <div class="ml-3 text-sm">
					      <label for="candidates" class="font-medium text-gray-700">Neumáticos 2º eje</label>
					      <p id="candidates-description" class="text-gray-500">Comprobar buen estado y presiones.</p>
					    </div>
					  </div>
					  <div class="relative flex items-start">
					    <div class="flex items-center h-5">
					      <input id="offers" aria-describedby="offers-description" name="offers" type="checkbox" class="focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300 rounded">
					    </div>
					    <div class="ml-3 text-sm">
					      <label for="offers" class="font-medium text-gray-700">Neumáticos 3º eje</label>
					      <p id="offers-description" class="text-gray-500">Comprobar buen estado y presiones.</p>
					    </div>
					  </div>
					  <div class="relative flex items-start">
					    <div class="flex items-center h-5">
					      <input id="candidates" aria-describedby="candidates-description" name="candidates" type="checkbox" class="focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300 rounded">
					    </div>
					    <div class="ml-3 text-sm">
					      <label for="offers" class="font-medium text-gray-700">Extintor</label>
					      <p id="offers-description" class="text-gray-500">Comprobar estado visual y fecha de última revisión.</p>
					    </div>
					  </div>
					  <div class="relative flex items-start">
					    <div class="flex items-center h-5">
					      <input id="candidates" aria-describedby="candidates-description" name="candidates" type="checkbox" class="focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300 rounded">
					    </div>
					    <div class="ml-3 text-sm">
					      <label for="offers" class="font-medium text-gray-700">Limpieza interior</label>
					      <p id="offers-description" class="text-gray-500">Comprobar cabina interior.</p>
					    </div>
					  </div>
					  <div class="relative flex items-start">
					    <div class="flex items-center h-5">
					      <input id="candidates" aria-describedby="candidates-description" name="candidates" type="checkbox" class="focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300 rounded">
					    </div>
					    <div class="ml-3 text-sm">
					      <label for="offers" class="font-medium text-gray-700">Limpieza exterior</label>
					      <p id="offers-description" class="text-gray-500">Comprobar exteriores y caja vaciada.</p>
					    </div>
					  </div>
					</fieldset>
				</div>
				



			</div>
			<div class="space-y-2">
				<div>
					@if(isset($delivery) && $delivery->front_picture)
					<img class="rounded shadow" src="{{ $delivery->front_picture->getLink() }}">
					<p class="uppercase text-xs font-medium text-center text-gray-500">Delantera</p>
					@else
					<div class="rounded shadow border relative">
						<p class="inset-0 mt-32 tracking-wider -rotate-45 font-light absolute uppercase text-4xl text-center text-gray-500" style="margin-left: 7rem;">Delantera</p>
						<svg xmlns="http://www.w3.org/2000/svg" class="text-gray-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
						<path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
						</svg>
					</div>
					@endif
				</div>
				<div>
					@if(isset($delivery) && $delivery->back_picture)
					<img class="rounded shadow" src="{{ $delivery->back_picture->getLink() }}">
					<p class="uppercase text-xs font-medium text-center text-gray-500">Trasera</p>
					@else
					<div class="rounded shadow border relative">
						<p class="inset-0 mt-32 tracking-wider -rotate-45 font-light absolute uppercase text-4xl text-center text-gray-500" style="margin-left: 7rem;">Trasera</p>
						<svg xmlns="http://www.w3.org/2000/svg" class="text-gray-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
						<path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
						</svg>
					</div>
					@endif
				</div>
				<div>
					@if(isset($delivery) && $delivery->right_picture)
					<img class="rounded shadow" src="{{ $delivery->right_picture->getLink() }}">
					<p class="uppercase text-xs font-medium text-center text-gray-500">Derecha</p>
					@else
					<div class="rounded shadow border relative">
						<p class="inset-0 mt-32 tracking-wider -rotate-45 font-light absolute uppercase text-4xl text-center text-gray-500" style="margin-left: 7rem;">Derecha</p>
						<svg xmlns="http://www.w3.org/2000/svg" class="text-gray-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
						<path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
						</svg>
					</div>
					@endif
				</div>
				<div>
					@if(isset($delivery) && $delivery->left_picture)
					<img class="rounded shadow" src="{{ $delivery->left_picture->getLink() }}">
					<p class="uppercase text-xs font-medium text-center text-gray-500">Izquierda</p>
					@else
					<div class="rounded shadow border relative">
						<p class="inset-0 mt-32 tracking-wider -rotate-45 font-light absolute uppercase text-4xl text-center text-gray-500" style="margin-left: 7rem;">Izquierda</p>
						<svg xmlns="http://www.w3.org/2000/svg" class="text-gray-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
						<path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
						</svg>
					</div>
					@endif
				</div>
			</div>
		</div>
	@endcomponent

@endsection