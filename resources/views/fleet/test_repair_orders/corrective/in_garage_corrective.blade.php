@extends('layouts.fleet')

@section('title', 'Crear Orden de Reparación')

@section('content')

@component('components.card')

  {!! Form::open([
    'route' => ['fleet.garages.store'],
    'method' => 'POST',
    'class' => 'w-full'
  ]) !!}	
	@include('fleet.test_repair_orders.form')
  {!! Form::close() !!}

  {{-- En esta sección solo se modifica los datos de un OR creado en un taller externo y que no dispone de fecha de salida --}}
  <div class="container">
    <form onsubmit="return confirmAction()" class="mr-4" method="POST" action="{{ route('fleet.test-repair-orders.update') }}">
        @csrf
        @method('PUT')

        <h2>DESCRIPCIÓN</h2>

        <div class="mt-5 flex">
          <div class="w-full md:w-4/12 px-3 mb-6 md:mb-0">
              {!! Form::text('fleet', 'URBAN TRUCKS', ['class' => 'form-input']) !!}
          </div>
          <div class="w-full md:w-4/12 px-3 mb-6 md:mb-0">
              {!! Form::text('entry_date', '(Fecha de entrada)', ['class' => 'form-input']) !!}
          </div>
          <div class="w-full md:w-4/12 px-3 mb-6 md:mb-0">
              {!! Form::text('exit_date', '(Fecha de salida)', ['class' => 'form-input']) !!}
          </div>
        </div>

        <div class="mt-5 flex w-full">
          <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
            {!! Form::text('equipo', 'Equipo', ['class' => 'form-input']) !!}
          </div>
          <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
            {!! Form::text('tipo_de_equipo', 'Hidráulica', ['class' => 'form-input']) !!}
          </div>
          <div class="w-full md:w-4/12 px-3 mb-6 md:mb-0">
            {!! Form::label('Siniestro','¿Se trata de un siniestro?:') !!}
            SI {!! Form::radio('Siniestro', '1', '') !!}
            NO {!! Form::radio('Siniestro', '0', 'false') !!}
          </div>
          <div class="w-full md:w-4/12 px-3 mb-6 md:mb-0">
            {!! Form::label('Malos_Usos','¿Intervención por malos usos / golpes?:') !!}
            SI {!! Form::radio('Malos_Usos', '1', '') !!}
            NO {!! Form::radio('Malos_Usos', '0', 'false') !!}
          </div>
        </div>
        <div class="mt-5 flex w-full">
          <div class="w-full px-3 mb-6 md:mb-0">
            {!! Form::textarea('description', '(CAUSA) p.ej.: La prensa no tiene fuerza.', ['class' => 'form-input']) !!}
          </div>
        </div>
        
        <h2>¿YA HA SALIDO DE TALLER?</h2>
        <div class="w-full">
          <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
            {!! Form::text('date', '2021-01-01', ['class' => 'form-input datepicker']) !!}
          </div>
        </div>

        <button class="btn-indigo float-right mb-2">
          Guardar
        </button>
    </form>
  </div>

@endcomponent
@endsection