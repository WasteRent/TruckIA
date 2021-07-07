@extends('layouts.fleet')

@section('title', 'Orden de Reparación en Garage (Correctivo)')

@section('content')

@component('components.card')
  {!! Form::model($repair_order, [
			'route' => ['fleet.test-repair-orders.update', $repair_order],
			'method' => 'PUT',
			'class' => 'w-full'
		]) !!}	
	
	@include('fleet.test_repair_orders.form', $vehicle)

  {{-- En esta sección solo se modifica los datos de un OR creado en un taller externo y que no dispone de fecha de salida --}}
  <div class="container">

        <h2>DESCRIPCIÓN</h2>

        <div class="mt-5 flex">
          <div class="w-full md:w-4/12 px-3 mb-6 md:mb-0">
              {!! Form::text('garage_id', $repair_order->garage->name, ['class' => 'form-input', 'disabled']) !!}
          </div>
          <div class="w-full md:w-4/12 px-3 mb-6 md:mb-0">
              {!! Form::text('workshop_date', $repair_order->workshop_date, ['class' => 'form-input datepicker', 'disabled']) !!}
          </div>
          <div class="w-full md:w-4/12 px-3 mb-6 md:mb-0">
              {!! Form::text('identificator', $repair_order->identificator, ['class' => 'form-input', 'placeholder' => '(Nº de pedido / O.R.)']) !!}
          </div>
        </div>

        <div class="mt-5 flex w-full">
          <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
            {!! Form::select('operation_family',['chassis' => 'Chasis', 'equipment' => 'Equipo', 'both' => 'Ambas', 'unknow' => 'Desconocido'] ,$repair_order->operation_family, ['class' => 'form-select', 'disabled']) !!}
          </div>
          <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
            {!! Form::select('operation_subfamily',['hidraulic' => 'Hidráulica', 'mechanic' => 'Mecánica', 'electrical' => 'Eléctrica', 'pneumatics' => 'Neumática', 'unknow' => 'Desconocido', 'others' => 'Otros'] ,$repair_order->operation_subfamily, ['class' => 'form-select', 'disabled']) !!}
          </div>
          <div class="w-full md:w-4/12 px-3 mb-6 md:mb-0">
            {!! Form::label('sinister','¿Se trata de un siniestro?:') !!}
            {!! Form::select('sinister', ['1' => 'SI', '0' => 'NO'], $repair_order->sinister, ['disabled']) !!}
          </div>
          <div class="w-full md:w-4/12 px-3 mb-6 md:mb-0">
            {!! Form::label('missuse','¿Intervención por malos usos / golpes?:') !!}
            {!! Form::select('misuse', ['1' => 'SI', '0' => 'NO'], $repair_order->misuse, ['disabled']) !!}
          </div>
        </div>
        <div class="mt-5 flex w-full">
          <div class="w-full px-3 mb-6 md:mb-0">
            {!! Form::textarea('description', $repair_order->description, ['class' => 'form-input', 'disabled']) !!}
          </div>
        </div>
        
        <h2>¿YA HA SALIDO DE TALLER?</h2>
        <div class="w-full">
          <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
              {!! Form::text('workshop_exit_date', $repair_order->workshop_exit_date, ['class' => 'form-input datepicker']) !!}
          </div>
        </div>

        <button class="btn-indigo float-right mb-2">
          Guardar
        </button>
  </div>
		{!! Form::close() !!}

@endcomponent
@endsection