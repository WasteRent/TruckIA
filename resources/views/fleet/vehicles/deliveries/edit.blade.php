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
							__('Ubicación') => $vehicle->location?->name,
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
	<input type="hidden" name="signature" value="{{ old('signature') }}">
	@endif

	@if(!$delivery->signature_team)
	<input type="hidden" name="signatureTeam" value="{{ old('signatureTeam') }}">
	@endif
	
	@component('components.card')
		<div class="sm:grid grid-cols-12">
			<div class="col-span-9 mr-4">
				<div class="mb-8 sm:grid xl:grid-cols-6 gap-1">
					<div class="mb-2 sm:mb-0">
					  <label class="text-base font-medium text-gray-900">Tipo</label>
					  <fieldset class="mt-4 border-0 px-0">
					    <div class="space-y-4 flex items-center space-y-0">
					      <div class="flex items-center mr-2">
					        {!! Form::radio('type', 'delivery', null, ['class' => 'focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!}	
					        <label class="ml-1 block text-sm font-medium text-gray-700"> Entrega </label>
					      </div>
					      <div class="flex items-center">
					        {!! Form::radio('type', 'return', null, ['class' => 'focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!}	
					        <label class="ml-1 block text-sm font-medium text-gray-700"> Dev. </label>
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
	  	  	  			<label class="text-base font-medium text-gray-900">Horas Chasis</label>
	  	  	  			{!! Form::number('chassis_hours', null, ['step' => 'any', 'class' => 'mt-1.5 form-input']) !!}
	  	  	  	  	</div>
  	  	  	  		<div class="">
  	  	  	  			<label class="text-base font-medium text-gray-900">Horas Equipo</label>
  	  	  	  			{!! Form::number('equipment_hours', null, ['step' => 'any', 'class' => 'mt-1.5 form-input']) !!}
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
							    {!! Form::radio('check_front_tire_right', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
							    {!! Form::radio('check_front_tire_right', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
							    {!! Form::radio('check_front_tire_right', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
							    {!! Form::radio('check_front_tire_right', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
							</div>
							<div class="ml-3 text-sm">
							  <label class="font-semibold text-gray-700">Neumático delantero derecho</label>
							</div>
						</div>
						<div class="relative flex items-start">
							<div class="flex items-center h-5 text-sm">
							    {!! Form::radio('check_front_tire_left', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
							    {!! Form::radio('check_front_tire_left', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
							    {!! Form::radio('check_front_tire_left', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
							    {!! Form::radio('check_front_tire_left', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
							</div>
							<div class="ml-3 text-sm">
							  <label class="font-semibold text-gray-700">Neumático delantero izquierdo</label>
							</div>
						</div>
					    <div class="relative flex items-start">
					      <div class="flex items-center h-5 text-sm">
					  	    {!! Form::radio('check_tire_2_axis_right', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
					  	    {!! Form::radio('check_tire_2_axis_right', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
					  	    {!! Form::radio('check_tire_2_axis_right', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
					  	    {!! Form::radio('check_tire_2_axis_right', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
					      </div>
					      <div class="ml-3 text-sm">
					        <label class="font-semibold text-gray-700">Neumático 2º eje derecho</label>
					      </div>
					    </div>
					  <div class="relative flex items-start">
					    <div class="flex items-center h-5 text-sm">
						    {!! Form::radio('check_tire_2_axis_left', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
						    {!! Form::radio('check_tire_2_axis_left', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
						    {!! Form::radio('check_tire_2_axis_left', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
						    {!! Form::radio('check_tire_2_axis_left', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
					    </div>
					    <div class="ml-3 text-sm">
					      <label class="font-semibold text-gray-700">Neumático 2º eje izquierdo</label>
					    </div>
					  </div>
					  <div class="relative flex items-start">
					    <div class="flex items-center h-5 text-sm">
					    	{!! Form::radio('check_tire_3_axis_right', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
					    	{!! Form::radio('check_tire_3_axis_right', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
					    	{!! Form::radio('check_tire_3_axis_right', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
					    	{!! Form::radio('check_tire_3_axis_right', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
					    </div>
					    <div class="ml-3 text-sm">
					      <label class="font-semibold text-gray-700">Neumático 3º eje derecho</label>
					    </div>
					  </div>
					  <div class="relative flex items-start">
					    <div class="flex items-center h-5 text-sm">
					      {!! Form::radio('check_tire_3_axis_left', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
					      {!! Form::radio('check_tire_3_axis_left', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
					      {!! Form::radio('check_tire_3_axis_left', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
					      {!! Form::radio('check_tire_3_axis_left', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
					    </div>
					    <div class="ml-3 text-sm">
					      <label class="font-semibold text-gray-700">Neumático 3º eje izquierdo</label>
					    </div>
					  </div>
					  <div class="relative flex items-start">
					    <div class="flex items-center h-5 text-sm">
					      {!! Form::radio('check_front_axle_mud_flaps', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
					      {!! Form::radio('check_front_axle_mud_flaps', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
					      {!! Form::radio('check_front_axle_mud_flaps', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
					      {!! Form::radio('check_front_axle_mud_flaps', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
					    </div>
					    <div class="ml-3 text-sm">
					      <label class="font-semibold text-gray-700">Faldillas eje delantero</label>
					    </div>
					  </div>
					  <div class="relative flex items-start">
					    <div class="flex items-center h-5 text-sm">
					      {!! Form::radio('check_2_axle_mud_flaps', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
					      {!! Form::radio('check_2_axle_mud_flaps', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
					      {!! Form::radio('check_2_axle_mud_flaps', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
					      {!! Form::radio('check_2_axle_mud_flaps', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
					    </div>
					    <div class="ml-3 text-sm">
					      <label class="font-semibold text-gray-700">Faldillas 2º eje</label>
					    </div>
					  </div>
					  <div class="relative flex items-start">
					    <div class="flex items-center h-5 text-sm">

					      {!! Form::radio('check_3_axle_mud_flaps', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
					      {!! Form::radio('check_3_axle_mud_flaps', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
					      {!! Form::radio('check_3_axle_mud_flaps', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
					      {!! Form::radio('check_3_axle_mud_flaps', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
					    </div>
					    <div class="ml-3 text-sm">
					      <label class="font-semibold text-gray-700">Faldillas 3º eje</label>
					    </div>
					  </div>

					  <div class="relative flex items-start">
					    <div class="flex items-center h-5 text-sm">
					      {!! Form::radio('check_fire_extinguishers', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
					      {!! Form::radio('check_fire_extinguishers', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
					      {!! Form::radio('check_fire_extinguishers', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
					      {!! Form::radio('check_fire_extinguishers', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
					    </div>
					    <div class="ml-3 text-sm">
					      <label class="font-semibold text-gray-700">Extintores</label>
					    </div>
					  </div>
					  <div class="relative flex items-start">
					    <div class="flex items-center h-5 text-sm">
					      {!! Form::radio('check_battery_cap', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
					      {!! Form::radio('check_battery_cap', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
					      {!! Form::radio('check_battery_cap', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
					      {!! Form::radio('check_battery_cap', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
					    </div>
					    <div class="ml-3 text-sm">
					      <label class="font-semibold text-gray-700">Tapa baterias </label>
					    </div>
					  </div>
					  <div class="relative flex items-start">
					    <div class="flex items-center h-5 text-sm">
					      {!! Form::radio('check_windows_glass', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
					      {!! Form::radio('check_windows_glass', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
					      {!! Form::radio('check_windows_glass', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
					      {!! Form::radio('check_windows_glass', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
					    </div>
					    <div class="ml-3 text-sm">
					      <label class="font-semibold text-gray-700">Luna y cristales</label>
					    </div>
					  </div>
					  <div class="relative flex items-start">
					    <div class="flex items-center h-5 text-sm">

					      {!! Form::radio('check_fuel_adblue_cap', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
					      {!! Form::radio('check_fuel_adblue_cap', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
					      {!! Form::radio('check_fuel_adblue_cap', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
					      {!! Form::radio('check_fuel_adblue_cap', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
					    </div>
					    <div class="ml-3 text-sm">
					      <label class="font-semibold text-gray-700">Tapón gasoil / adblue</label>
					    </div>
					  </div>
					  <div class="relative flex items-start">
					    <div class="flex items-center h-5 text-sm">

					      {!! Form::radio('check_rotating_work_lights', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
					      {!! Form::radio('check_rotating_work_lights', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
					      {!! Form::radio('check_rotating_work_lights', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
					      {!! Form::radio('check_rotating_work_lights', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
					    </div>
					    <div class="ml-3 text-sm">
					      <label class="font-semibold text-gray-700">Rotativos-Faros de trabajo</label>
					    </div>
					  </div>
					  <div class="relative flex items-start">
					    <div class="flex items-center h-5 text-sm">
					      {!! Form::radio('check_headlights_pilots_lamps', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
					      {!! Form::radio('check_headlights_pilots_lamps', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
					      {!! Form::radio('check_headlights_pilots_lamps', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
					      {!! Form::radio('check_headlights_pilots_lamps', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
					    </div>
					    <div class="ml-3 text-sm">
					      <label class="font-semibold text-gray-700">Faros-Pilotos y tulipas</label>
					    </div>
					  </div>
					  <div class="relative flex items-start">
					    <div class="flex items-center h-5 text-sm">
					      {!! Form::radio('check_right_mirror', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
					      {!! Form::radio('check_right_mirror', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
					      {!! Form::radio('check_right_mirror', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
					      {!! Form::radio('check_right_mirror', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
					    </div>
					    <div class="ml-3 text-sm">
					      <label class="font-semibold text-gray-700">Retrovisor derecho</label>
					    </div>
					  </div>
					  <div class="relative flex items-start">
					    <div class="flex items-center h-5 text-sm">
					      {!! Form::radio('check_left_mirror', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
					      {!! Form::radio('check_left_mirror', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
					      {!! Form::radio('check_left_mirror', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
					      {!! Form::radio('check_left_mirror', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
					    </div>
					    <div class="ml-3 text-sm">
					      <label class="font-semibold text-gray-700">Retrovisor izquierdo</label>
					    </div>
					  </div>
					  <div class="relative flex items-start">
					    <div class="flex items-center h-5 text-sm">
					      {!! Form::radio('check_interior_cleaning', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
					      {!! Form::radio('check_interior_cleaning', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
					      {!! Form::radio('check_interior_cleaning', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
					      {!! Form::radio('check_interior_cleaning', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
					    </div>
					    <div class="ml-3 text-sm">
					      <label class="font-semibold text-gray-700">Limpieza interior</label>
					    </div>
					  </div>
					  <div class="relative flex items-start">
					    <div class="flex items-center h-5 text-sm">
					      {!! Form::radio('check_exterior_cleaning', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
					      {!! Form::radio('check_exterior_cleaning', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
					      {!! Form::radio('check_exterior_cleaning', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
					      {!! Form::radio('check_exterior_cleaning', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
					    </div>
					    <div class="ml-3 text-sm">
					      <label class="font-semibold text-gray-700">Limpieza exterior</label>
					    </div>
					  </div>
					  <div class="relative flex items-start">
					    <div class="flex items-center h-5 text-sm">
					    	{!! Form::radio('check_vest_triangle_light', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
					    	{!! Form::radio('check_vest_triangle_light', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
					    	{!! Form::radio('check_vest_triangle_light', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
					    	{!! Form::radio('check_vest_triangle_light', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
					    </div>
					    <div class="ml-3 text-sm">
					      <label class="font-semibold text-gray-700">Chaleco y triángulo (luz)</label>
					    </div>
					  </div>
					  <div class="relative flex items-start">
					    <div class="flex items-center h-5 text-sm">

					      {!! Form::radio('check_documentation', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
					      {!! Form::radio('check_documentation', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
					      {!! Form::radio('check_documentation', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
					      {!! Form::radio('check_documentation', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
					    </div>
					    <div class="ml-3 text-sm">
					      <label class="font-semibold text-gray-700">Documentación </label>
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
			<div class="col-span-3 space-y-2">
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

	@if ($delivery->signature === null || $delivery->signature_team === null)
	<div class="w-full flex flex-row justify-center items-center gap-5">
        @include('sign', [
			'saveRoute' => route('fleet.vehicles.deliveries.update', [$vehicle, $delivery]),
            'redirectRoute' => route('fleet.vehicles.deliveries.pdf', $delivery),
			'delivery'=> $delivery,
		])
	</div>
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