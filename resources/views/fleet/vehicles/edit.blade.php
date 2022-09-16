@extends('layouts.fleet')

@section('title', $vehicle->plate .' '. $vehicle->chassis)

@section('content')

	@include('fleet.vehicles.edit_tabs', ['active_form' => true])

	@include('fleet.vehicles.tracking')

	@component('components.card')
		@slot('title', __('Editar Vehículo'))

		@slot('corner')
			<a href="{{ route('fleet.vehicles.show', $vehicle) }}" class="btn-outline-gray">{{ __('Vista previa') }}</a>
		@endslot

		@push('js')
		<script type="text/javascript">
		  $('select[name="state_id"').change(function() {
		    if ($(this).val() == 8) {
		      $('.modal').modal();
		    }
		  })
		</script>
		@endpush
		<div class="modal">
		  <form action="{{ route('fleet.vehicle-state.update', $vehicle) }}" method="POST">
		  	  @csrf
		  	  <input type="hidden" name="state_id" value="8">
		      <h3 class="text-lg mb-4">Entrada a taller</h3>
		      <div class="w-1/2 mb-4">
		        <label class="form-label" >
		          {{ __('Fecha entrada a taller') }}
		        </label>
		        {!! Form::text('date', today(), ['class' => 'form-input datepicker']) !!}
		      </div>
		      <div class="mb-4">
		        <textarea name="notes" class="form-input" placeholder="Observaciones"></textarea>
		      </div>
		      <div class="flex justify-end">
		        <button class="btn-indigo">Guardar</button>
		      </div>
		  </form>
		</div>

		{!! Form::model($vehicle, [
			'route' => ['fleet.vehicles.update', $vehicle],
			'method' => 'PUT',
			'class' => 'w-full'
		]) !!}	

		@include('fleet.vehicles.form')

		<div class="flex justify-end">
			<button class="btn-indigo">{{ __('Guardar') }}</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection