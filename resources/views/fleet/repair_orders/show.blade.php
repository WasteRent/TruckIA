@extends('layouts.fleet')

@include('fleet.repair_orders.tabs', ['active_summary' => true])

@section('content')

	@component('components.card')
		@slot('title', __('Orden de reparación'))
		@if(!$repair_order->isFinished())
			@slot('corner')
				<div class="flex">
                    <a class="btn-outline-gray mr-4" href="{{ route('fleet.repair-orders.checklists.index', $repair_order ) }}" target="_blank">
                        <i class="fas fa-check-square mr-2"></i> {{ __('Checklist') }}
                    </a>
					<form onsubmit="return confirmAction()" class="mr-4" method="POST" action="{{ route('fleet.repair-orders.finish', $repair_order) }}">
						@csrf
						@method('PUT')
						<button class="btn-outline-gray">
							{{ __('Cerrar') }}
						</button>
					</form>
					<form onsubmit="return confirmDelete()" method="POST" action="{{ route('fleet.repair-orders.destroy', $repair_order) }}">
						@csrf
						@method('DELETE')
						<button class="btn-outline-red">
							{{ __('Eliminar') }}
						</button>
					</form>
				</div>
			@endslot
		@else
			@slot('corner')
                <a class="btn-outline-gray mr-4" href="{{ route('fleet.repair-orders.checklists.index', $repair_order ) }}" target="_blank">
                    <i class="fas fa-check-square mr-2"></i> {{ __('Checklist') }}
                </a>
				<a class="btn-outline-gray" href="{{ route('fleet.repair-orders.invoice.show',$repair_order ) }}" target="_blank">
					<i class="fas fa-file-invoice-dollar mr-2"></i> {{ __('Factura') }}
				</a>
			@endslot
		@endif

		<div class="sm:flex">
			<div class="sm:w-1/2">
				@component('components.table')
					@slot('items', [
						__('Fecha') => $repair_order->created_at->format('d/m/Y H:i:s'),
						__('Vehículo') => "{$repair_order->vehicle->internal_id} {$repair_order->vehicle->plate} " . "&middot; " . $repair_order->vehicle->chassis .' '. $repair_order->vehicle->equipment,
						__('Creada por') => optional($repair_order->creator)->name,
						__('Asignada a') => $repair_order->getAssignedUsers()?->pluck('name')->join(', '),
						__('Autorizada por') => $repair_order->authorizer ? $repair_order->authorizer->name : '',
						__('Incidencia asociada') => $repair_order->related_incident_id ? "#{$repair_order->related_incident_id} - {$repair_order->relatedIncident->user->name}" : null,
						__('Estado') => __(optional($repair_order->state)->name),
						__('Taller vió por pri. vez') => optional($repair_order->seen_at)->diffForHumans(),
						__('Taller vió por ult. vez') => optional($repair_order->last_seen_at)->diffForHumans(),
						__('Observaciones') => $repair_order->remarks,
					])
				@endcomponent
			</div>
			<div class="sm:w-1/2 mt-4 sm:mt-0">

				{!! Form::model($repair_order, [
					'route' => ['fleet.repair-orders.state.update', $repair_order],
					'method' => 'PUT',
					'class' => 'w-full'
				]) !!}	
					<div class="flex items-center">
						<div class="mr-4">
							{!! Form::select('state_id', $states->pluck('name', 'id')->mapWithKeys(function($value, $key) {
								return [$key => __($value)];
							}), null, ['placeholder' => '', 'class' => 'form-select']) !!}
						</div>
						<div><button class="btn-outline-gray">{{ __('Cambiar estado') }}</button></div>
					</div>
				{!! Form::close() !!}

				<fieldset>
					<legend>{{ __('Estados') }}</legend>
					@foreach($repair_order->history as $history)
						<div class="flex my-1 px-2 py-1 rounded text-xs @if($loop->first) {{$history->state?->color}} @endif">
							<div class="w-1/2">
								<span class="">{{$history->state?->name}}</span>
							</div>
							<div class="w-1/2">
								{{ optional($history->user)->name }} &middot;
								{{$history->created_at->format('d/m/y H:i:s')}}
							</div>
						</div>
					@endforeach
				</fieldset>
			</div>
		</div>
	@endcomponent

	@component('components.card')
		@slot('title', __('Datos generales'))

		{!! Form::model($repair_order, [
			'route' => ['fleet.repair-orders.update', $repair_order],
			'method' => 'PUT',
			'class' => 'w-full'
		]) !!}	
			<div class="flex flex-wrap -mx-3 mb-6">
				<div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
				  <label class="form-label" >
				    {{ __('Mantenimiento') }}
				  </label>
				  {!! Form::select('type', ['preventive' => __('Preventivo'),'corrective' => __('Correctivo'),'pre-itv' => __('Pre-ITV'), 'weekly' => __('Semanal'), 'tires' => 'Neumáticos', 'bad_use' => 'Malos usos'], request()->query('type'), ['class' => 'form-select']) !!}
				</div>
				<div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
				<label class="form-label" >
				  {{ __('Fecha de apertura') }}
				</label>
				{!! Form::text('created_at', null, ['class' => 'form-input datepicker']) !!}
				</div>
				<div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
				<label class="form-label" >
				  {{ __('Fecha de cita') }}
				</label>
				{!! Form::text('appointment', null, ['class' => 'form-input datepicker']) !!}
				</div>
				<div class="w-full md:w-4/12 px-3 mb-6 md:mb-0">
				  <label class="form-label">
				    {{ __('Asignada a') }}
				  </label>
				  @if($repair_order->fleet)
				  	@foreach($repair_order->fleet->getRelatedFleets() as $fleet)
				  		@php
				  			$users[] = $fleet->users()->where('job', 'mechanic')->orderBy('name')->get()->merge($repair_order->garage->users);
				  		@endphp
				  	@endforeach

				    {!! Form::select('assigned_user_id[]',
				    	collect($users)->flatten()->merge($repair_order->garage->users)->pluck('name', 'id'), null, ['placeholder' => '', 'class' => 'multiselect', 'multiple' => true]) !!}
				   @endif
				</div>
			</div>
			<div class="flex flex-wrap -mx-3">
			  <div class="w-full md:w-3/12 px-3 mb-6 md:mb-0">
			    <label class="form-label" >
			      {{ __('Kms') }}
			    </label>
			    {!! Form::number('kms', null, ['class' => 'form-input']) !!}
			    @if(!$repair_order->isFinished())
			    <small>Diferencia respecto a los actuales del vehículo es: {{ $repair_order->kms - $repair_order->vehicle->kms }}.</small>
			    @endif
			  </div>
			  <div class="w-full md:w-3/12 px-3 mb-6 md:mb-0">
			    <label class="form-label" >
			      {{ __('Horas chasis') }}
			    </label>
			    {!! Form::number('work_hours_chassis', null, ['class' => 'form-input', 'step' => 'any']) !!}
			    @if(!$repair_order->isFinished())
			    <small>Diferencia respecto a los actuales del vehículo es: {{ $repair_order->work_hours_chassis - $repair_order->vehicle->chassis_can_work_hours }}.</small>
			    @endif
			  </div>
			  <div class="w-full md:w-3/12 px-3 mb-6 md:mb-0">
			    <label class="form-label" >
			      {{ __('Horas equipo') }}
			    </label>
			    {!! Form::number('work_hours_equipment', null, ['class' => 'form-input', 'step' => 'any']) !!}
			    @if(!$repair_order->isFinished())
			    <small>Diferencia respecto a los actuales del vehículo es: {{ $repair_order->work_hours_equipment - $repair_order->vehicle->equipment_work_hours }}.</small>
			    @endif
			  </div>
			</div>
			<div class="flex flex-wrap -mx-3">
			  <div class="w-full mt-6 px-3 md:mb-0">
			  	<label class="form-label" >
			  	  {{ __('Nota interna de OR') }} <button id="edit-or-notes" class="ml-1"><i class="fas fa-edit fa-lg"></i></button>
			  	</label>

			  	<section class="bg-gray-100 p-4 rounded" id="or-notes-content">
			  		{!! $repair_order->internal_notes !!}
			  	</section>

			  	<x-trix name="internal_notes" class="hidden or-notes-input">
			  	  @if(isset($repair_order)) {{ $repair_order->internal_notes }} @endif
			  	</x-trix>
			  </div>
			</div>
			<div class="flex justify-end mt-2">
				<button class="btn-indigo">{{ __('Actualizar') }}</button>
			</div>
		{!! Form::close() !!}
	@endcomponent

	@if($repair_order->type == 'pre-itv')
		@include('fleet.repair_orders.itv')
	@endif
	
	@component('components.card', ['is_table' => true])
		@slot('title', __('Operaciones realizadas'))

		@slot('corner')
			<create-custom-operation endpoint="{{ route('fleet.repair-orders.custom-operation.store', $repair_order) }}"></create-custom-operation>	
		@endslot
		
		@include('shared.repair_orders.operations', ['repair_order' => $repair_order])
	@endcomponent

	@component('components.card', ['is_table' => true])
		@slot('title', __('Recambios'))

		@slot('corner')
			<add-part-to-repair-order
				endpoint="{{ route('fleet.repair-orders.spare-parts.store', $repair_order) }}"
				repair-order-id="{{ $repair_order->id }}">
			</add-part-to-repair-order>
		@endslot

		@include('shared.repair_orders.parts', ['repair_order' => $repair_order])
	@endcomponent
@endsection


@push('head')
<link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
@endpush
@push('js')
<script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
<script type="text/javascript">
  new TomSelect('.multiselect', {
    maxOptions: 100
  })
</script>
@endpush


@push('js')
<script type="text/javascript">
	$("#edit-or-notes").click(function(e) {
		e.preventDefault()
		$("#edit-or-notes").hide()
		$("#or-notes-content").hide()
		$(".or-notes-input").show()
	})

	$('.autocomplete_price').change(function() {
	  var hourly_rate = Number({{ $repair_order->garage?->hourly_price }})
	  var price = ($(this).val() * hourly_rate).toFixed(2)
	  var element = $(this).closest('tr').find('input[name="amount"]')
	  element.val(price)
	  element.closest('.auto_submit').trigger('change')
	})

	$('.auto_submit').change(function() {
	  $.ajax({
	      url : $(this).attr('action'),
	      type: "PUT",
	      data: $(this).serialize()
	  });
	})
	$('.auto_submit').submit(function(e) {
	  e.preventDefault()
	  $.ajax({
	      url : $(this).attr('action'),
	      type: "PUT",
	      data: $(this).serialize()
	  });
	})
</script>
@endpush
