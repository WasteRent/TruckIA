@extends('layouts.fleet')

@section('title', __('Ordenes de reparación'))

@section('content')
<form method="POST" action="{{ route('fleet.fast-orders.store') }}">
	@csrf
	<input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
	@if($incident_id)
	<input type="hidden" name="incident_id" value="{{ $incident_id }}">
	@endif

	@component('components.card')
		@slot('title', __('Nueva orden'))

		@component('components.table')
			@slot('items', [
				'Vehículo' => "$vehicle->plate - $vehicle->chassis $vehicle->equipment",
				'Asignada a' => $user->name
			])
		@endcomponent

		<br>

		<div class="flex flex-wrap -mx-3 pb-6">
			<div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
			  <label class="form-label" >
			    {{ __('Mantenimiento') }}
			  </label>
			  {!! Form::select('type', ['preventive' => __('Preventivo'),'corrective' => __('Correctivo'),'pre-itv' => __('Pre-ITV'), 'weekly' => __('Semanal'), 'tires' => 'Neumáticos', 'bad_use' => 'Malos usos', 'support' => __('Asistencia')], 'corrective', ['class' => 'form-select']) !!}
			</div>
			<div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
			  <label class="form-label" >
			    {{ __('Fecha apertura') }}
			  </label>
			  {!! Form::text('created_at', date('Y-m-d'), ['class' => 'form-input datepicker', 'disabled' => auth()->user()->fleet->id == 30]) !!}
			  @if(auth()->user()->fleet->id == 30)
			  <input type="hidden" name="created_at" value="{{ date('Y-m-d') }}">
			  @endif
			</div>
			<div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
			  <label class="form-label" >
			    {{ __('Taller') }}
			  </label>
			  {!! Form::select('garage_id', App\Models\Garage::allowForUser()->pluck('name', 'id'), null, ['class' => 'form-select js-select-search']) !!}
			</div>
			<div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
			  <label class="form-label" >
			    {{ __('Mecánico') }}
			  </label>
			  @foreach(auth()->user()->fleet->getRelatedFleets() as $fleet)
			  	@php
			  		$users[] = $fleet->users()->where('job', 'mechanic')->orderBy('name')->get();
			  	@endphp
			  @endforeach
			  @if(auth()->user()->fleet->id != 30)
			  	{!! Form::select('assigned_user_id', collect($users)->flatten()->merge(auth()->user()->fleet->garages->pluck('users')->flatten())->pluck('name', 'id')->sortBy('name'), null, ['placeholder' => '', 'class' => 'form-select']) !!}
			  @else
			  	{!! Form::select('assigned_user_id', App\Models\Garage::allowForUser()->first()->users->pluck('name', 'id')->sortBy('name'), null, ['placeholder' => '', 'class' => 'form-select']) !!}
			  @endif
			</div>

		</div>
		<div class="flex flex-wrap -mx-3">
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
		<x-trix name="internal_notes">{{ $notes }}</x-trix>
	@endcomponent

	@component('components.card')
		@slot('title', __('Detalle'))

		<div id="fast-order-lines">
			@include('fleet.repair_orders.fast_orders.line_spare_part')
		</div>

		<div class="flex space-x-10 pt-1">
			<span class="text-blue-700 flex items-center cursor-pointer" id="add-work-time">
				<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
				  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
				</svg>
				<span>Añadir M.O.</span>
			</span>

			<span class="text-blue-700 flex items-center cursor-pointer" id="add-spare-part">
				<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
				  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
				</svg>
				<span>Añadir recambio</span>
			</span>

			<span class="text-blue-700 flex items-center cursor-pointer" id="add-displacement">
				<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
				  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
				</svg>
				<span>Añadir desplazamiento</span>
			</span>

			<span class="text-blue-700 flex items-center cursor-pointer" id="add-outsourced">
				<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
				  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
				</svg>
				<span>Añadir subcontrata</span>
			</span>
		</div>

	@endcomponent

	<div class="text-right pt-2">
		<button type="submit" class="btn-indigo">{{ __('Crear orden de reparación') }}</button>
	</div>

</form>
@endsection

@push('js')
<script type="text/javascript">
	$('#add-spare-part').click(function(e) {
		$('#fast-order-lines').append(`@include('fleet.repair_orders.fast_orders.line_spare_part')`);
	})
	$('#add-work-time').click(function(e) {
		$('#fast-order-lines').append(`@include('fleet.repair_orders.fast_orders.line_work_time')`);
	})
	$('#add-displacement').click(function(e) {
		$('#fast-order-lines').append(`@include('fleet.repair_orders.fast_orders.line_displacement')`);
	})
	$('#add-outsourced').click(function(e) {
		$('#fast-order-lines').append(`@include('fleet.repair_orders.fast_orders.line_outsourced')`);
	})

	$('#fast-order-lines').on('click', '.remove-fast-order-line', function() {
		$(this).parent('.form-line').remove()
	});
</script>
@endpush

