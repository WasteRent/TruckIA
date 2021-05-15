@extends('layouts.fleet')

@section('title', 'Crear Orden de Reparación Preventivo')

@section('content')

@component('components.card')
  {!! Form::open([
    'route' => ['fleet.garages.store'],
    'method' => 'POST',
    'class' => 'w-full'
  ]) !!}	
		@include('fleet.test_repair_orders.form')
	{!! Form::close() !!}
    
  @component('components.tabs', [
  'items' => [
    [
      'name' => 'Correctivo',
      'url' => route('fleet.test-repair-orders.corrective'),
      'active' => false
    ],
    [
      'name' => 'Preventivo',
      'url' => '',
      'active' => true
    ]
  ]
  ])
  @endcomponent

    @component('components.card')
        @slot('title', 'Mantenimientos Chasis')
        
		<display-more>
			<template v-slot:head>
                <div class="w-full flex">
                    <div class="w-full md:w-11/12">
                        <label class="block tracking-wide text-gray-600 text-xs font-medium text-right">
                            T1 - 800h - Iveco Trakker (Cursosr13 EU6-D)
                        </label>
                        <div class="bg-gray-200 rounded-full">
                            <div role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" class="progress-bar-step3 text-xs leading-none text-center text-white rounded-full" style="width: {{ 75 > 100 ? 100 : 75 }}%">
                                611 h 
                            </div>
                        </div>
                    </div>
                    <div class="w-full md:w-1/12">
                        <div style="float: right">
                        {!! Form::checkbox('mantenimiento', 'id', 'checked') !!}
                        </div>
                    </div>
                </div>
                <div class="w-full flex">
                    <div class="w-full md:w-11/12">
                        <label class="block tracking-wide text-gray-600 text-xs font-medium text-right">
                            EO - 1000h - Iveco Trakker (Cursosr13 EU6-D)
                        </label>
                        <div class="bg-gray-200 rounded-full">
                            <div role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" class="progress-bar-step2 text-xs leading-none text-center text-white rounded-full" style="width: {{ 60 > 100 ? 100 : 60 }}%">
                                611 h 
                            </div>
                        </div>
                    </div>
                    <div class="w-full md:w-1/12">
                        <div style="float: right">
                        {!! Form::checkbox('mantenimiento', 'id') !!}
                        </div>
                    </div>
                </div>
                <div class="w-full flex">
                    <div class="w-full md:w-11/12">
                        <label class="block tracking-wide text-gray-600 text-xs font-medium text-right">
                            M3 - 3000h - Iveco Trakker (Cursosr13 EU6-D)
                        </label>
                        <div class="bg-gray-200 rounded-full">
                            <div role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" class="progress-bar-step1 text-xs leading-none text-center text-white rounded-full" style="width: {{ 10 > 100 ? 100 : 10 }}%">
                                611 h 
                            </div>
                        </div>
                    </div>
                    <div class="w-full md:w-1/12">
                        <div style="float: right">
                        {!! Form::checkbox('mantenimiento', 'id', 'checked') !!}
                        </div>
                    </div>
                </div>
			</template>
            
			<template v-slot:body>
                <div class="w-full flex">
                    <div class="w-full md:w-11/12">
                    <label class="block tracking-wide text-gray-600 text-xs font-medium text-right">
                        T1 - 800h - Iveco Trakker (Cursosr13 EU6-D)
                    </label>
                    <div class="bg-gray-200 rounded-full">
                        <div role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" class="progress-bar-step1 text-xs leading-none text-center text-white rounded-full" style="width: {{ 10 > 100 ? 100 : 10 }}%">
                            611 h 
                        </div>
                    </div>
                </div>
                <div class="w-full md:w-1/12">
                    <div style="float: right">
                    {!! Form::checkbox('mantenimiento', 'id') !!}
                    </div>
                </div>
            </div>
			</template>
		</display-more>
        
    @endcomponent

    @component('components.card')
        @slot('title', 'Mantenimientos Equipos')
		<display-more>
			<template v-slot:head>
                <div class="w-full flex">
                    <div class="w-full md:w-11/12">
                        <label class="block tracking-wide text-gray-600 text-xs font-medium text-right">
                            Primeras 50h - HIAB X-HIPRO 408
                        </label>
                        <div class="bg-gray-200 rounded-full">
                            <div role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" class="bg-red-500 text-xs leading-none text-center text-white rounded-full" style="width: {{ 100 > 100 ? 100 : 100 }}%">
                                    50 h 
                            </div>
                        </div>
                    </div>
                    <div class="w-full md:w-1/12">
                        <div style="float: right">
                        {!! Form::checkbox('mantenimiento', 'id') !!}
                        </div>
                    </div>
                </div>

                <div class="w-full flex">
                    <div class="w-full md:w-11/12">
                        <label class="block tracking-wide text-gray-600 text-xs font-medium text-right">
                            1000h - HIAB X-HIPRO 408
                        </label>
                        <div class="bg-gray-200 rounded-full">
                            <div role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" class="progress-bar-step1 text-xs leading-none text-center text-white rounded-full" style="width: {{ 50 > 100 ? 100 : 50 }}%">
                                    611 h 
                            </div>
                        </div>
                    </div>
                    <div class="w-full md:w-1/12">
                        <div style="float: right">
                        {!! Form::checkbox('mantenimiento', 'id') !!}
                        </div>
                    </div>
                </div>
            </template>
    
            <template v-slot:body>
            </template>
        </display-more>
        
    @endcomponent

    <div class="mt-8">
        {{-- Desplegamos botones que abran con JS el contenido de cada tipo de intervención --}}
        <div class="mt-5 flex">
        <div class="w-full md:w-1/2">
            <button onclick="return OnwTechnician()" class="btn-indigo"> Intervención Técnico Própio</button>
        </div>
        <div class="w-full md:w-1/2">
            <button onclick="return ExternalTechnician()" class="btn-indigo">Intervención Técnico Externo</button>
        </div>
        </div>

    </div>

    <div id="OnwTechnician" class="mt-8" style="display: none">
        {{-- contenedor oculto con los datos de nuevo preventivo con datos de técnico própio --}}
        <hr>

        <form class="mr-4" method="POST" action="{{ route('fleet.test-repair-orders.create') }}">
            @csrf
            @method('PUT')

            <div class="flex container border-2">
                <div class="w-full md:w-4/12 px-3 m-2">
                    {!! Form::select('tecnico', ['SELECCIONAR TÉCNICO' => 'SELECCIONAR TÉCNICO', '-' => '-'], null, ['class' => 'form-select']) !!}
                </div>
                <div class="w-full md:w-2/12 px-3 m-2">
                    {!! Form::text('n_pedido', null, ['placeholder' => '¿nº pedido?', 'class' => 'form-input']) !!}
                </div>
                <div class="w-full md:w-3/12 px-3 m-2">
                    <button class="btn-indigo float-right">
                        Guardar
                    </button>
                </div>
            </div>

        </form>
    </div>

    <div id="ExternalTechnician" class="mt-8" style="display: none">
        {{-- contenedor oculto con los datos de nuevo preventivo con datos de técnico externo --}}
        <hr>

        <form class="mr-4" method="POST" action="{{ route('fleet.test-repair-orders.create') }}">
            @csrf
            @method('PUT')

            <div class="container border-2">
                <div class="w-full flex">
                    <div class="w-full md:w-4/12 px-3 m-2">
                        {!! Form::select('tecnico', ['SELECCIONAR TALLER' => 'SELECCIONAR TALLER', '-' => '-'], null, ['class' => 'form-select']) !!}
                    </div>
                    <div class="w-full md:w-2/12 px-3 m-2">
                        {!! Form::text('n_pedido', null, ['placeholder' => '¿nº pedido?', 'class' => 'form-input']) !!}
                    </div>
                </div>

                <H2 class="ml-4">¿TIENE CITA O HA ENTRADO EN TALLER?:</H2>
                <div class="w-full flex">
                    <div class="flex flex-wrap -mx-3 mb-1 mt-2 ml-2">
                        <div class="w-full md:w-6/12 px-3 mb-6 mt-1">
                            SI {!! Form::radio('Tiene_Cita', '1') !!}<br>
                            NO {!! Form::radio('Tiene_Cita', '0', 'false') !!}
                        </div>
                        <div class="w-full md:w-6/12 px-3 mb-6 md:mb-0">
                            {!! Form::text('date', null, ['placeholder' => '2021-01-01', 'class' => 'form-input datepicker']) !!}
                        </div>
                    </div>
                </div>

                <H2 class="ml-4">¿HA SALIDO DEL TALLER?:</H2>
                <div class="w-full flex">
                    <div class="flex flex-wrap -mx-3 mb-1 mt-2 ml-2">
                        <div class="w-full md:w-6/12 px-3 mb-6 mt-1">
                            SI {!! Form::radio('Salio_De_Taller', '1') !!}<br>
                            NO {!! Form::radio('Salio_De_Taller', '0', 'false') !!}
                        </div>
                        <div class="w-full md:w-6/12 px-3 mb-6 md:mb-0">
                            {!! Form::text('date', null, ['placeholder' => '2021-01-01', 'class' => 'form-input datepicker']) !!}
                        </div>
                    </div>
                </div>
                
                <button class="btn-indigo float-right m-2">
                    Guardar
                </button>
            </div>
        </form>

    </div>
  
@endcomponent
@endsection

<script>
    function OnwTechnician() {
      var x = document.getElementById("OnwTechnician");
      var y = document.getElementById("ExternalTechnician");
      if (x.style.display === "none") {
          x.style.display = "block";
      } else {
          x.style.display = "none";
      }
      if (y.style.display === "block") {
          y.style.display = "none";
      }
  }
  
  function ExternalTechnician() {
      var x = document.getElementById("ExternalTechnician");
      var y = document.getElementById("OnwTechnician");
      if (x.style.display === "none") {
          x.style.display = "block";
      } else {
          x.style.display = "none";
      }
      if (y.style.display === "block") {
          y.style.display = "none";
      }
  }
  </script>