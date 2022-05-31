@extends('layouts.fleet')

@section('title', __('Ordenes de reparación'))

@section('content')
<form method="POST" action="{{ route('fleet.fast-orders.store') }}">
	@csrf
	<input type="hidden" name="garage_id" value="{{ $garage->id }}">
	<input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">

	@component('components.card')
		@slot('title', __('Nueva orden'))

		@component('components.table')
			@slot('items', [
				'Vehículo' => "$vehicle->plate - $vehicle->chassis $vehicle->equipment",
				'Taller' => $garage->name,
				'Asignada a' => $user->name
			])
		@endcomponent

		<br>

		<div class="flex flex-wrap -mx-3">
			<div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
			  <label class="form-label" >
			    {{ __('Mantenimiento') }}
			  </label>
			  {!! Form::select('type', ['preventive' => __('Preventivo'),'corrective' => __('Correctivo'),'pre-itv' => __('Pre-ITV'), 'weekly' => __('Semanal')], 'corrective', ['class' => 'form-select']) !!}
			</div>
		  <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
		    <label class="form-label" >
		      {{ __('Kms') }}
		    </label>
		    {!! Form::number('kms', $vehicle->kms, ['class' => 'form-input']) !!}
		  </div>
		  <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
		    <label class="form-label" >
		      {{ __('Horas chasis') }}
		    </label>
		    {!! Form::number('work_hours_chassis', $vehicle->chassis_can_work_hours ?? $vehicle->chassis_gps_work_hours, ['class' => 'form-input', 'step' => 'any']) !!}
		  </div>
		  <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
		    <label class="form-label" >
		      {{ __('Horas equipo') }}
		    </label>
		    {!! Form::number('work_hours_equipment', $vehicle->equipment_work_hours, ['class' => 'form-input', 'step' => 'any']) !!}
		  </div>
		</div>
		<br>
		<x-trix name="internal_notes"></x-trix>
	@endcomponent

	@component('components.card')
		@slot('title', __('Detalle'))

		<div id="fast-order-lines">
			<div>@include('fleet.repair_orders.fast_orders.detail_form_line')</div>
			<div id="first_line">@include('fleet.repair_orders.fast_orders.detail_form_line2')</div>
		</div>
		<div class="flex justify-center pt-1">
			<button class="text-blue-700 flex items-center" id="add-form-line">
				<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
				  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
				</svg>
				<span>Añadir nueva línea</span>
			</button>
		</div>
		
	@endcomponent

	<div class="text-right pt-2">
		<button type="submit" class="btn-indigo">{{ __('Crear orden de reparación') }}</button>
	</div>

</form>
@endsection

@push('js')
<script type="text/javascript">
	$('#add-form-line').click(function(e) {
		e.preventDefault()
		var form_line = $('#first_line').clone();
		$('#fast-order-lines').append(form_line);
	})
</script>
@endpush

