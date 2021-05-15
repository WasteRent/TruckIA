@extends('layouts.fleet')

@section('title', 'Cita Preventivo (Técnico)')

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

        <div class="mt-5 flex">
          <div class="w-full md:w-6/12 px-3">
            ASIGNADO A TÉCNICO: {!! Form::text('técnico', 'Pablo', ['class' => 'form-input']) !!}
          </div>
          <div class="w-full md:w-6/12 px-3 mb-6 md:mb-0">
            FECHA DE REALIZACIÓN: {!! Form::text('date', '(Fecha)', ['class' => 'form-input']) !!}
          </div>
        </div>

        <div class="w-full px-3 mb-6 mt-5 ml-2">
            <label class="form-label">
                OPERACIONES A REALIZAR:
            </label>
            {{-- Listado de los Mantenimientos asignados a esta OR preventiva --}}
            <div class="ml-3 w-full">
                <ol>
                    <li>Primeras 50h - HIAB X-HiPro 408</li>
                </ol>
            </div>
        </div>

        <div class="container border-2 border-secondary">
          <div class="flex flex-wrap mx-1 mb-6 mt-2">
              <div class="w-full md:w-1/4">
                  Tiempo de desplazamiento (minutos): 
              </div>
              <div class="w-full md:w-1/4">
              {!! Form::number('desplazamiento_min', '35', ['class' => 'form-input md:w-1/4']) !!}
              </div>
              <div class="w-full md:w-2/4 ">
                  <div class="form-group float-right">
                  {!! Form::label('Siniestro','¿Se trata de un siniestro?:',['class' => 'mr-3']) !!}
                  SI {!! Form::radio('siniestro', '1', '', ['style' => 'margin-right: 0.5em']) !!}
                  NO {!! Form::radio('siniestro', '0', 'false') !!}
                  </div>
              </div>
                  <div class="w-full">
                      <div class="form-group float-right">
                      {!! Form::label('Siniestro','¿Intervención por malos usos / golpes?:',['class' => 'mr-3']) !!}
                      SI {!! Form::radio('siniestro', '1', '', ['style' => 'margin-right: 0.5em']) !!}
                      NO {!! Form::radio('siniestro', '0', 'false') !!}
                      </div>
                  </div>
          </div>
          
          {{-- Aquí se saca con un foreach un listado de las operaciones asignadas a este OR (orden descendente)--}}
          <div class="flex flex-wrap mx-1 mb-6 mt-2">
  
              <div class="w-full md:w-1/12">3</div>
  
              <div class="w-full md:w-11/12 border-2 border-secondary">
  
                  <div class="flex flex-wrap">
                      <div class="w-full md:w-3/12">
                          {!! Form::select('chasis', ['Chasis' => 'Chasis', '-' => '-'], null, ['class' => 'form-select']) !!}
                      </div>
                      <div class="w-full md:w-3/12 ml-1">
                          {!! Form::select('Mecánica', ['Mecánica' => 'Mecánica', '-' => '-'], null, ['class' => 'form-select']) !!}
                      </div>
                      <div class="w-full md:w-4/12 ml-1">
                      {!! Form::number('desplazamiento_min', '100', ['class' => 'form-input md:w-1/4']) !!} (min)
                      </div>
                      <div class="w-full md:w-1/12 float-right">
                        <button type="button" class="mr-2">
                          <i class="fas fa-check"></i>
                        </button>
                        <button type="button">
                          <i class="fas fa-trash"></i>
                        </button>
                      </div>
                  </div>
  
                  <div class="flex flex-wrap mt-1">
                      <div class="w-full">
                          {!! Form::textarea('datos', 'Cambiar bomba de agua.', ['class' => 'form-input', 'rows' => 2]) !!}
                      </div>
                  </div>
  
                  {{-- Ahora salen listados los recambios asignados (orden descendente)--}}
                  <div class="container">
                      <div class="flex flex-wrap mb-1">
                          <div class="w-full md:w-1/12">
                          2
                          </div>
                          <div class="w-full md:w-4/12 -mx-6">
                              {!! Form::text('nombre', 'Bomba de agua', ['class' => 'form-input']) !!}
                          </div>
                          <div class="w-full md:w-2/12 ml-1">
                              {!! Form::text('codigo', '087568-587', ['class' => 'form-input']) !!}
                          </div>
                          <div class="w-full md:w-2/12 ml-1">
                          {!! Form::text('estado', 'Nuevo pedido', ['class' => 'form-input']) !!}
                          </div>
                          <div class="w-full md:w-2/12 ml-1">
                              {!! Form::text('coste', '278,25 €', ['class' => 'form-input']) !!}
                          </div>
                          <div class="w-full md:w-1/12 float-right ml-1">
                            <button type="button" class="mr-2">
                              <i class="fas fa-check"></i>
                            </button>
                            <button type="button">
                              <i class="fas fa-trash"></i>
                            </button>
                          </div>
                      </div>
                      <div class="flex flex-wrap mb-1">
                          <div class="w-full md:w-1/12">
                          1
                          </div>
                          <div class="w-full md:w-4/12 -mx-6">
                              {!! Form::text('nombre', 'Tornillo', ['class' => 'form-input']) !!}
                          </div>
                          <div class="w-full md:w-2/12 ml-1">
                              {!! Form::text('codigo', null, ['class' => 'form-input']) !!}
                          </div>
                          <div class="w-full md:w-2/12 ml-1">
                          {!! Form::text('estado', 'Stock', ['class' => 'form-input']) !!}
                          </div>
                          <div class="w-full md:w-2/12 ml-1">
                              {!! Form::text('coste', '7,23 €', ['class' => 'form-input']) !!}
                          </div>
                          <div class="w-full md:w-1/12 float-right ml-1">
                            <button type="button" class="mr-2">
                              <i class="fas fa-edit"></i>
                            </button>
                            <button type="button">
                              <i class="fas fa-trash"></i>
                            </button>
                          </div>
                      </div>
                  </div>
  
              </div>
              
          </div>
          <div class="flex flex-wrap mx-1 mb-6 mt-2">
  
              <div class="w-full md:w-1/12">2</div>
  
              <div class="w-full md:w-11/12 border-2 border-secondary">
  
                  <div class="flex flex-wrap">
                      <div class="w-full md:w-3/12">
                          {!! Form::select('Equipo', ['Equipo' => 'Equipo', '-' => '-'], null, ['class' => 'form-select']) !!}
                      </div>
                      <div class="w-full md:w-3/12 ml-1">
                          {!! Form::select('Eléctrica', ['Eléctrica' => 'Eléctrica', '-' => '-'], null, ['class' => 'form-select']) !!}
                      </div>
                      <div class="w-full md:w-4/12 ml-1">
                      {!! Form::number('desplazamiento_min', '30', ['class' => 'form-input md:w-1/4']) !!} (min)
                      </div>
                      <div class="w-full md:w-1/12 float-right">
                        <button type="button" class="mr-2">
                          <i class="fas fa-edit"></i>
                        </button>
                        <button type="button">
                          <i class="fas fa-trash"></i>
                        </button>
                      </div>                      
                  </div>
  
                  <div class="flex flex-wrap mt-1">
                      <div class="w-full">
                          {!! Form::textarea('datos', 'Cambiar inductivo de final de carrera de la placa eyectora y reparar el cableado dañado.', ['class' => 'form-input', 'rows' => 2]) !!}
                      </div>
                  </div>
  
                  {{-- Ahora salen listados los recambios asignados (orden descendente)--}}
                  <div class="container">
                      <div class="flex flex-wrap mb-1">
                          <div class="w-full md:w-1/12">
                          1
                          </div>
                          <div class="w-full md:w-4/12 -mx-6">
                              {!! Form::text('nombre', 'Inductivo', ['class' => 'form-input']) !!}
                          </div>
                          <div class="w-full md:w-2/12 ml-1">
                              {!! Form::text('codigo', null, ['class' => 'form-input']) !!}
                          </div>
                          <div class="w-full md:w-2/12 ml-1">
                          {!! Form::text('estado', 'Stock', ['class' => 'form-input']) !!}
                          </div>
                          <div class="w-full md:w-2/12 ml-1">
                              {!! Form::text('coste', '12,05 €', ['class' => 'form-input']) !!}
                          </div>
                          <div class="w-full md:w-1/12 float-right ml-1">
                            <button type="button" class="mr-2">
                              <i class="fas fa-edit"></i>
                            </button>
                            <button type="button">
                              <i class="fas fa-trash"></i>
                            </button>
                          </div>
                      </div>
                  </div>
  
              </div>
              
          </div>
          <div class="flex flex-wrap mx-1 mb-6 mt-2">
  
              <div class="w-full md:w-1/12">1</div>
  
              <div class="w-full md:w-11/12 border-2 border-secondary">
  
                  <div class="flex flex-wrap">
                      <div class="w-full md:w-3/12">
                          {!! Form::select('Equipo', ['Equipo' => 'Equipo', '-' => '-'], null, ['class' => 'form-select']) !!}
                      </div>
                      <div class="w-full md:w-3/12 ml-1">
                          {!! Form::select('Hidráulica', ['Hidráulica' => 'Hidráulica', '-' => '-'], null, ['class' => 'form-select']) !!}
                      </div>
                      <div class="w-full md:w-4/12 ml-1">
                      {!! Form::number('desplazamiento_min', '15', ['class' => 'form-input md:w-1/4']) !!} (min)
                      </div>
                      <div class="w-full md:w-1/12 float-right">
                        <button type="button" class="mr-2">
                          <i class="fas fa-edit"></i>
                        </button>
                        <button type="button">
                          <i class="fas fa-trash"></i>
                        </button>
                      </div>
                  </div>
  
                  <div class="flex flex-wrap mt-1">
                      <div class="w-full">
                          {!! Form::textarea('datos', 'Reapretar líquidos del cilíndro de prensa.', ['class' => 'form-input', 'rows' => 2]) !!}
                      </div>
                  </div>
  
                  {{-- Ahora salen listados los recambios asignados (orden descendente)--}}
                  <div class="container">
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