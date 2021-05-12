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
    <form class="mr-4" method="POST" action="{{ route('fleet.test-repair-orders.update') }}">
        @csrf
        @method('PUT')

        <h2>DESCRIPCIÓN</h2>

        <div class="mt-5 flex">
          <div class="w-full md:w-4/12 px-3">
              {!! Form::text('fleet', 'URBAN TRUCKS', ['class' => 'form-input']) !!}
          </div>
          <div class="w-full md:w-4/12 px-3 mb-6 md:mb-0">
              {!! Form::text('entry_date', '(Fecha de entrada)', ['class' => 'form-input']) !!}
          </div>
          <div class="w-full md:w-4/12 px-3 mb-6 md:mb-0">
              {!! Form::text('n_pedido', '(¿nº pedido / O.R.?)', ['class' => 'form-input']) !!}
          </div>
        </div>

        <div class="w-full px-3 mb-6 mt-5 ml-2">
            <dl>
              <dt>
                Mantenimientos a realizar:
              </dt>
              {{-- Listado de los Mantenimientos asignados a esta OR preventiva --}}
              <dd class="ml-5">Primeras 50h - HIAB X-HiPro 408</dd>
            </dl>
        </div>
        
        <H2 class="ml-4">¿HA SALIDO DEL TALLER?:</H2>
                <div class="w-full flex">
                    <div class="flex flex-wrap -mx-3 mb-1 mt-2 ml-2">
                        <div class="w-full md:w-6/12 px-3 mb-6 mt-1">
                            SI {!! Form::radio('Salio_De_Taller', '1') !!}<br>
                            NO {!! Form::radio('Salio_De_Taller', '0', 'false') !!}
                        </div>
                        <div class="w-full md:w-6/12 px-3 mb-6 md:mb-0">
                            {!! Form::text('date', '2021-01-01', ['class' => 'form-input datepicker']) !!}
                        </div>
                    </div>
                </div>

        <button class="btn-indigo float-right mb-2">
          Guardar
        </button>
    </form>
  </div>

@endcomponent
@endsection