	@extends('layouts.fleet')

@section('title', 'Nuevo albarán de entrega')

@section('content')
	
	<div class="sticky top-0 hidden" id="delivery-autosave-alert">
		<div class="w-64 rounded-full bg-blue-50 p-0.5 border text-xs bg-slate-50/90 backdrop-blur-sm">
		  <div class="flex">
		    <div class="flex-shrink-0">
		      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
		        <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
		      </svg>
		    </div>
		    <div class="ml-3 flex-1 md:flex md:justify-between">
		      <p class="text-blue-700">Albarán actualizado...</p>
		    </div>
		  </div>
		</div>
	</div>

	
	<div class="flex justify-between">
		<a class="text-blue-800" href="{{ route('fleet.vehicles.customers.index', $vehicle) }}">
			<i class="fas fa-angle-double-left"></i> 
			Volver
		</a>

		<a target="_blank" class="text-red-800" href="{{ route('fleet.vehicles.deliveries.pdf', $delivery) }}">
			<i class="fas fa-print mr-1"></i> Imprimir
		</a>
	</div>


	<br>

	<div class="md:grid grid-cols-2 gap-4">
		<div class="flex">
			@component('components.card')
				@slot('title', __('Datos del vehículo'))
				@slot('corner')
					<a class="btn-outline-gray" href="{{ route('fleet.vehicles.show', $vehicle) }}">Ver</a>
				@endslot
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
				@slot('corner')
					<a class="btn-outline-gray" href="{{ route('fleet.customers.edit', $delivery->customer) }}">Ver</a>
				@endslot
				<div class="">
					@component('components.table')
						@slot('items', [
							__('Nombre') => $delivery->customer->name,
							__('Empresa') => optional($delivery->customer->enterprise)->name,
						])
					@endcomponent
				</div>
			@endcomponent
		</div>
	</div>
	
	{!! Form::model($delivery, [
		'route' => ['fleet.vehicles.deliveries.update', $vehicle, $delivery],
		'method' => 'PUT',
		'files' => true,
		'class' => 'w-full auto_submit'
	]) !!}  

	@if(!$delivery->signature)
	<input type="hidden" name="signature">
	@endif
	
	@component('components.card')
		<div class="sm:grid grid-cols-3">
			<div class="col-span-2 mr-4">
				<div class="mb-8 sm:grid xl:grid-cols-6 gap-2">
					<div class="col-span-2 mb-2 sm:mb-0">
					  <label class="text-base font-medium text-gray-900">Tipo</label>
					  <fieldset class="mt-4 border-0 px-0">
					    <div class="space-y-4 flex items-center space-y-0">
					      <div class="flex items-center mr-2">
					        {!! Form::radio('type', 'delivery', null, ['class' => 'focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!}	
					        <label class="ml-3 block text-sm font-medium text-gray-700"> Entrega </label>
					      </div>
					      <div class="flex items-center">
					        {!! Form::radio('type', 'return', null, ['class' => 'focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!}	
					        <label class="ml-3 block text-sm font-medium text-gray-700"> Devolución </label>
					      </div>
					    </div>
					  </fieldset>
				  	</div>		  			
				  	<div class="">
		  				<label class="text-base font-medium text-gray-900">Contrato</label>
		  				{!! Form::select('contract_type', ['' => '',  'Alquiler' => 'Alquiler', 'Prestamo' => 'Prestamo', 'Venta' => 'Venta'], null, ['class' => 'mt-1.5 form-select']) !!}
		  		  	</div>
			  		<div class="">
			  			<label class="text-base font-medium text-gray-900">Fecha</label>
			  			{!! Form::text('date', $delivery->date ?? now()->format('Y-m-d'), ['class' => 'mt-1.5 form-input datepicker']) !!}
			  	  	</div>
		  	  		<div class="">
		  	  			<label class="text-base font-medium text-gray-900">Kms</label>
		  	  			{!! Form::number('kms', null, ['step' => 'any', 'class' => 'mt-1.5 form-input']) !!}
		  	  	  	</div>
	  	  	  		<div class="">
	  	  	  			<label class="text-base font-medium text-gray-900">Horas</label>
	  	  	  			{!! Form::number('hours', null, ['step' => 'any', 'class' => 'mt-1.5 form-input']) !!}
	  	  	  	  	</div>
				</div>

				
				<div class="mb-8">
				  <label class="text-base font-medium text-gray-900">Nivel de combustible</label>
				  <fieldset class="mt-4 border-0 px-0">
				    <div class="space-y-4 flex items-center space-y-0 sm:space-x-10">
				      <div class="flex items-center">
				        {!! Form::radio('fuel_level', 'empty', null, ['class' => 'ml-3 sm:ml-0 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!}	
				        <label class="ml-1 block text-sm font-medium text-gray-700"> Vacío </label>
				      </div>
				      <div class="flex items-center">
				        {!! Form::radio('fuel_level', '1/4', null, ['class' => 'ml-3 sm:ml-0 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!}	
				        <label class="ml-1 block text-sm font-medium text-gray-700"> 1/4 </label>
				      </div>

				      <div class="flex items-center">
				        {!! Form::radio('fuel_level', '1/2', null, ['class' => 'ml-3 sm:ml-0 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!}	
				        <label class="ml-1 block text-sm font-medium text-gray-700"> 1/2 </label>
				      </div>

				      <div class="flex items-center">
				        {!! Form::radio('fuel_level', '3/4', null, ['class' => 'ml-3 sm:ml-0 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!}	
				        <label class="ml-1 block text-sm font-medium text-gray-700"> 3/4 </label>
				      </div>

				      <div class="flex items-center">
				        {!! Form::radio('fuel_level', 'full', null, ['class' => 'ml-3 sm:ml-0 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!}	
				        <label class="ml-1 block text-sm font-medium text-gray-700"> Full </label>
				      </div>
				    </div>
				  </fieldset>
				</div>


				<div class="mb-8">
					<label class="text-base font-medium text-gray-900">Estado</label>
					<fieldset class="space-y-5 mt-4 border-0 px-0">
						<div class="relative flex items-start">
							<div class="flex items-center h-5 text-sm">
							    {!! Form::radio('check_security', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
							    {!! Form::radio('check_security', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
							    {!! Form::radio('check_security', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
							    {!! Form::radio('check_security', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
							</div>
							<div class="ml-3 text-sm">
							  <label class="font-semibold text-gray-700">Seguridades</label>
							</div>
						</div>
						<div class="relative flex items-start">
							<div class="flex items-center h-5 text-sm">
							    {!! Form::radio('check_training', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
							    {!! Form::radio('check_training', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
							    {!! Form::radio('check_training', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
							    {!! Form::radio('check_training', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
							</div>
							<div class="ml-3 text-sm">
							  <label class="font-semibold text-gray-700">Formación</label>
							</div>
						</div>
					    <div class="relative flex items-start">
					      <div class="flex items-center h-5 text-sm">
					  	    {!! Form::radio('check_gps', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
					  	    {!! Form::radio('check_gps', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
					  	    {!! Form::radio('check_gps', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
					  	    {!! Form::radio('check_gps', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
					      </div>
					      <div class="ml-3 text-sm">
					        <label class="font-semibold text-gray-700">GPS</label>
					      </div>
					    </div>
					  <div class="relative flex items-start">
					    <div class="flex items-center h-5 text-sm">
						    {!! Form::radio('check_front_tires', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
						    {!! Form::radio('check_front_tires', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
						    {!! Form::radio('check_front_tires', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
						    {!! Form::radio('check_front_tires', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
					    </div>
					    <div class="ml-3 text-sm">
					      <label class="font-semibold text-gray-700">Neumáticos delanteros</label>
					      <p class="text-gray-500">Comprobar buen estado y presiones.</p>
					    </div>
					  </div>
					  <div class="relative flex items-start">
					    <div class="flex items-center h-5 text-sm">
					    	{!! Form::radio('check_tires_2_axis', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
					    	{!! Form::radio('check_tires_2_axis', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
					    	{!! Form::radio('check_tires_2_axis', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
					    	{!! Form::radio('check_tires_2_axis', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
					    </div>
					    <div class="ml-3 text-sm">
					      <label class="font-semibold text-gray-700">Neumáticos 2º eje</label>
					      <p class="text-gray-500">Comprobar buen estado y presiones.</p>
					    </div>
					  </div>
					  <div class="relative flex items-start">
					    <div class="flex items-center h-5 text-sm">
					      {!! Form::radio('check_tires_3_axis', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
					      {!! Form::radio('check_tires_3_axis', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
					      {!! Form::radio('check_tires_3_axis', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
					      {!! Form::radio('check_tires_3_axis', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
					    </div>
					    <div class="ml-3 text-sm">
					      <label class="font-semibold text-gray-700">Neumáticos 3º eje</label>
					      <p class="text-gray-500">Comprobar buen estado y presiones.</p>
					    </div>
					  </div>
					  <div class="relative flex items-start">
					    <div class="flex items-center h-5 text-sm">
					      {!! Form::radio('check_extinguisher', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
					      {!! Form::radio('check_extinguisher', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
					      {!! Form::radio('check_extinguisher', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
					      {!! Form::radio('check_extinguisher', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
					    </div>
					    <div class="ml-3 text-sm">
					      <label class="font-semibold text-gray-700">Extintor</label>
					      <p class="text-gray-500">Comprobar estado visual y fecha de última revisión.</p>
					    </div>
					  </div>
					  <div class="relative flex items-start">
					    <div class="flex items-center h-5 text-sm">
					      {!! Form::radio('check_clean_cabin', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
					      {!! Form::radio('check_clean_cabin', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
					      {!! Form::radio('check_clean_cabin', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
					      {!! Form::radio('check_clean_cabin', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
					    </div>
					    <div class="ml-3 text-sm">
					      <label class="font-semibold text-gray-700">Limpieza interior</label>
					      <p class="text-gray-500">Comprobar cabina interior.</p>
					    </div>
					  </div>
					  <div class="relative flex items-start">
					    <div class="flex items-center h-5 text-sm">

					      {!! Form::radio('check_clean_exterior', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
					      {!! Form::radio('check_clean_exterior', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
					      {!! Form::radio('check_clean_exterior', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
					      {!! Form::radio('check_clean_exterior', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
					    </div>
					    <div class="ml-3 text-sm">
					      <label class="font-semibold text-gray-700">Limpieza exterior</label>
					      <p class="text-gray-500">Comprobar exteriores y caja vaciada.</p>
					    </div>
					  </div>

					  <div class="relative flex items-start">
					    <div class="flex items-center h-5 text-sm">
					      {!! Form::radio('check_full_cycle', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
					      {!! Form::radio('check_full_cycle', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
					      {!! Form::radio('check_full_cycle', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
					      {!! Form::radio('check_full_cycle', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
					    </div>
					    <div class="ml-3 text-sm">
					      <label class="font-semibold text-gray-700">Prueba de equipo ciclo completo</label>
					    </div>
					  </div>
					  <div class="relative flex items-start">
					    <div class="flex items-center h-5 text-sm">
					      {!! Form::radio('check_dump_cycle', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
					      {!! Form::radio('check_dump_cycle', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
					      {!! Form::radio('check_dump_cycle', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
					      {!! Form::radio('check_dump_cycle', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
					    </div>
					    <div class="ml-3 text-sm">
					      <label class="font-semibold text-gray-700">Ciclo de descarga</label>
					    </div>
					  </div>
					  <div class="relative flex items-start">
					    <div class="flex items-center h-5 text-sm">
					      {!! Form::radio('check_lights', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
					      {!! Form::radio('check_lights', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
					      {!! Form::radio('check_lights', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
					      {!! Form::radio('check_lights', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
					    </div>
					    <div class="ml-3 text-sm">
					      <label class="font-semibold text-gray-700">Luces</label>
					    </div>
					  </div>
					  <div class="relative flex items-start">
					    <div class="flex items-center h-5 text-sm">

					      {!! Form::radio('check_itv', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
					      {!! Form::radio('check_itv', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
					      {!! Form::radio('check_itv', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
					      {!! Form::radio('check_itv', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
					    </div>
					    <div class="ml-3 text-sm">
					      <label class="font-semibold text-gray-700">ITV</label>
					    </div>
					  </div>
					  <div class="relative flex items-start">
					    <div class="flex items-center h-5 text-sm">

					      {!! Form::radio('check_tacograph', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
					      {!! Form::radio('check_tacograph', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
					      {!! Form::radio('check_tacograph', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
					      {!! Form::radio('check_tacograph', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
					    </div>
					    <div class="ml-3 text-sm">
					      <label class="font-semibold text-gray-700">Tacógrafo</label>
					    </div>
					  </div>
					  <div class="relative flex items-start">
					    <div class="flex items-center h-5 text-sm">
					      {!! Form::radio('check_preventive_chassis', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
					      {!! Form::radio('check_preventive_chassis', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
					      {!! Form::radio('check_preventive_chassis', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
					      {!! Form::radio('check_preventive_chassis', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
					    </div>
					    <div class="ml-3 text-sm">
					      <label class="font-semibold text-gray-700">Preventivo chasis</label>
					    </div>
					  </div>
					  <div class="relative flex items-start">
					    <div class="flex items-center h-5 text-sm">
					      {!! Form::radio('check_preventive_equipment', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
					      {!! Form::radio('check_preventive_equipment', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
					      {!! Form::radio('check_preventive_equipment', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
					      {!! Form::radio('check_preventive_equipment', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
					    </div>
					    <div class="ml-3 text-sm">
					      <label class="font-semibold text-gray-700">Preventivo equipo</label>
					    </div>
					  </div>
					  <div class="relative flex items-start">
					    <div class="flex items-center h-5 text-sm">
					      {!! Form::radio('check_security_triangles', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
					      {!! Form::radio('check_security_triangles', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
					      {!! Form::radio('check_security_triangles', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
					      {!! Form::radio('check_security_triangles', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
					    </div>
					    <div class="ml-3 text-sm">
					      <label class="font-semibold text-gray-700">Triángulos de Seguridad</label>
					    </div>
					  </div>
					  <div class="relative flex items-start">
					    <div class="flex items-center h-5 text-sm">
					      {!! Form::radio('check_reflective_vest', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
					      {!! Form::radio('check_reflective_vest', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
					      {!! Form::radio('check_reflective_vest', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
					      {!! Form::radio('check_reflective_vest', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
					    </div>
					    <div class="ml-3 text-sm">
					      <label class="font-semibold text-gray-700">Chaleco reflectante</label>
					    </div>
					  </div>
					  <div class="relative flex items-start">
					    <div class="flex items-center h-5 text-sm">
					      {!! Form::radio('check_documents', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
					      {!! Form::radio('check_documents', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
					      {!! Form::radio('check_documents', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
					      {!! Form::radio('check_documents', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
					    </div>
					    <div class="ml-3 text-sm">
					      <label class="font-semibold text-gray-700">Documentación del vehículo</label>
					    </div>
					  </div>
					  <div class="relative flex items-start">
					    <div class="flex items-center h-5 text-sm">
					    	{!! Form::radio('check_fluid_levels', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
					    	{!! Form::radio('check_fluid_levels', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
					    	{!! Form::radio('check_fluid_levels', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
					    	{!! Form::radio('check_fluid_levels', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
					    </div>
					    <div class="ml-3 text-sm">
					      <label class="font-semibold text-gray-700">Niveles de fluidos</label>
					    </div>
					  </div>
					  <div class="relative flex items-start">
					    <div class="flex items-center h-5 text-sm">

					      {!! Form::radio('check_rubber_status', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
					      {!! Form::radio('check_rubber_status', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
					      {!! Form::radio('check_rubber_status', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
					      {!! Form::radio('check_rubber_status', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
					    </div>
					    <div class="ml-3 text-sm">
					      <label class="font-semibold text-gray-700">Estado goma culera</label>
					    </div>
					  </div>

					</fieldset>
				</div>

				<div>
					<label class="text-base font-medium text-gray-900">Observaciones</label>
					<x-trix class="mb-8" name="comments">
						{{ $delivery->comments }}
					</x-trix>
				</div>
			</div>
			<div class="space-y-2">
				<div>
					@if(isset($delivery) && $delivery->front_picture)
					<a target="_blank" href="{{ $delivery->front_picture->getLink() }}">
						<img loading="lazy" class="rounded shadow" src="{{ $delivery->front_picture->getLink() }}">
						<p class="uppercase text-xs font-medium text-center text-gray-500">Delantera</p>	
					</a>
					<div style="margin-top: -1rem;" class="delivery-delete-file cursor-pointer text-right text-xs text-red-600" data-picture-position="front_picture" data-url="{{ route('fleet.deliveries.files.destroy', [$delivery, $delivery->front_picture]) }}"><i class="fas fa-trash-alt mr-1"></i>Borrar</div>
					@else
					<label class="cursor-pointer">
						<div class="rounded shadow border relative">
							<p class="inset-0 mt-32 tracking-wider -rotate-45 font-light absolute uppercase text-4xl text-center text-gray-500" style="margin-left: 7rem;">
								Delantera
								<span class="hidden spinner"><i class="fas fa-spinner fa-spin fa-2x"></i></span>
							</p>
							<svg xmlns="http://www.w3.org/2000/svg" class="text-gray-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
							<path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
							</svg>
						</div>
					    <input type="file" class="hidden" name="front_picture_id" accept="image/*"/>
					</label>
					@endif
				</div>
				<div>
					@if(isset($delivery) && $delivery->back_picture)
					<a target="_blank" href="{{ $delivery->back_picture->getLink() }}">
						<img loading="lazy" class="rounded shadow" src="{{ $delivery->back_picture->getLink() }}">
						<p class="uppercase text-xs font-medium text-center text-gray-500">Trasera</p>
					</a>
					<div style="margin-top: -1rem;" class="delivery-delete-file cursor-pointer text-right text-xs text-red-600" data-picture-position="back_picture" data-url="{{ route('fleet.deliveries.files.destroy', [$delivery, $delivery->back_picture]) }}"><i class="fas fa-trash-alt mr-1"></i>Borrar</div>
					@else
					<label class="cursor-pointer">
						<div class="rounded shadow border relative">
							<p class="inset-0 mt-32 tracking-wider -rotate-45 font-light absolute uppercase text-4xl text-center text-gray-500" style="margin-left: 7rem;">
								Trasera
								<span class="hidden spinner"><i class="fas fa-spinner fa-spin fa-2x"></i></span>
							</p>
							<svg xmlns="http://www.w3.org/2000/svg" class="text-gray-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
							<path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
							</svg>
						</div>
					    <input type="file" class="hidden" name="back_picture_id" accept="image/*"/>
					</label>
					@endif
				</div>
				<div>
					@if(isset($delivery) && $delivery->right_picture)
					<a target="_blank" href="{{ $delivery->right_picture->getLink() }}">
						<img loading="lazy" class="rounded shadow" src="{{ $delivery->right_picture->getLink() }}">
						<p class="uppercase text-xs font-medium text-center text-gray-500">Derecha</p>
					</a>
					<div style="margin-top: -1rem;" class="delivery-delete-file cursor-pointer text-right text-xs text-red-600" data-picture-position="right_picture" data-url="{{ route('fleet.deliveries.files.destroy', [$delivery, $delivery->right_picture]) }}"><i class="fas fa-trash-alt mr-1"></i>Borrar</div>
					@else
					<label class="cursor-pointer">
						<div class="rounded shadow border relative">
							<p class="inset-0 mt-32 tracking-wider -rotate-45 font-light absolute uppercase text-4xl text-center text-gray-500" style="margin-left: 7rem;">
								Derecha
								<span class="hidden spinner"><i class="fas fa-spinner fa-spin fa-2x"></i></span>
							</p>
							<svg xmlns="http://www.w3.org/2000/svg" class="text-gray-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
							<path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
							</svg>
						</div>
					    <input type="file" class="hidden" name="right_picture_id" accept="image/*"/>
					</label>
					@endif
				</div>
				<div>
					@if(isset($delivery) && $delivery->left_picture)
					<a target="_blank" href="{{ $delivery->left_picture->getLink() }}">
						<img loading="lazy" class="rounded shadow" src="{{ $delivery->left_picture->getLink() }}">
						<p class="uppercase text-xs font-medium text-center text-gray-500">Izquierda</p>
					</a>
					<div style="margin-top: -1rem;" class="delivery-delete-file cursor-pointer text-right text-xs text-red-600" data-picture-position="left_picture" data-url="{{ route('fleet.deliveries.files.destroy', [$delivery, $delivery->left_picture]) }}"><i class="fas fa-trash-alt mr-1"></i>Borrar</div>
					@else
					<label class="cursor-pointer">
						<div class="rounded shadow border relative">
							<p class="inset-0 mt-32 tracking-wider -rotate-45 font-light absolute uppercase text-4xl text-center text-gray-500" style="margin-left: 7rem;">
								Izquierda
								<span class="hidden spinner"><i class="fas fa-spinner fa-spin fa-2x"></i></span>
							</p>
							<svg xmlns="http://www.w3.org/2000/svg" class="text-gray-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
							<path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
							</svg>
						</div>
					    <input type="file" class="hidden" name="left_picture_id" accept="image/*"/>
					</label>
					@endif
				</div>
			</div>
		</div>
	@endcomponent

	{!! Form::close() !!}

	@component('components.card')
		@slot('title', __('Fotos extra'))
		<div>
			<form method="POST" action="{{ route('fleet.deliveries.files.store', $delivery) }}" enctype="multipart/form-data">
				@csrf
				<input type="file" name="file">
				<button class="btn-indigo">Subir</button>
			</form>
			<div class="grid grid-cols-2 sm:grid-cols-6 gap-4 mt-4">
			@foreach($delivery->files as $file)
				<a target="_blank" href="{{ $file->getLink() }}">
					<img loading="lazy" class="rounded shadow" src="{{ $file->getLink() }}">
				</a>				
			@endforeach
			</div>
		</div>
	@endcomponent

	@if(!$delivery->signature)
		@include('sign')
	@endif

@endsection

@push('js')
<script type="text/javascript">
	$('.delivery-delete-file').click(function() {
		if (confirm('Estás seguro de eliminar')) {
			$.ajax({
	            url : $(this).data('url'),
	            type: "DELETE",
	            data: {
	            	picture_position: $(this).data('picture-position'),
	            	_token: $('meta[name="csrf-token"]').attr('content')
	            },
	            complete: function(xhr, status) {
	            	location.reload();
	            }
	        });
        }
	})


	addEventListener("trix-change", function(event) {
		$("#delivery-autosave-alert").show();
		let data  = $('.auto_submit').serialize()
		data['_token'] = $('meta[name="csrf-token"]').attr('content')

		$.ajax({
            url : "{{ route('fleet.vehicles.deliveries.update', [$vehicle, $delivery]) }}",
            type: "PUT",
            data: data,
            complete: function(xhr, status) {
            	$("#delivery-autosave-alert").delay(1000).fadeOut('slow');
            }
        });
	})


	$('.auto_submit').change(function() {
		if ($('input[name$="picture_id"]').get(0) && $('input[name$="picture_id"]').get(0).files.length > 0) {
			$(this).find('.spinner').show()
		    $(this).submit()
		} else {
			$("#delivery-autosave-alert").show();
			$.ajax({
	            url : "{{ route('fleet.vehicles.deliveries.update', [$vehicle, $delivery]) }}",
	            type: "PUT",
	            data: $(this).serialize(),
	            complete: function(xhr, status) {
	            	$("#delivery-autosave-alert").delay(1000).fadeOut('slow');
	            }
	        });
		}
	})
</script>
@endpush