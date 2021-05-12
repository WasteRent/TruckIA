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
    
  @component('components.tabs', [
  'items' => [
    [
      'name' => 'Correctivo',
      'url' => '',
      'active' => true
    ],
    [
      'name' => 'Preventivo',
      'url' => route('fleet.test-repair-orders.preventive'),
      'active' => false
    ]
  ]
  ])
  @endcomponent

  <div class="container mt-8">
    {{-- Desplegamos botones que abran con JS el contenido de cada tipo de intervención --}}
    <div class="mt-5 flex">
      <div class="w-full md:w-1/2">
        <button onclick="return OnwTechnician()" class="btn-indigo"> Intervención Técnico Própio</button>
      </div>
      <div class="w-full md:w-1/2">
        <button onclick="return ExternalTechnician()" class="btn-indigo">Intervención Técnico Externo</button>
      </div>
    </div>

    <div id="OnwTechnician" class="mt-8" style="display: none">
      {{-- contenedor oculto con los datos de nuevo correctivo con datos de técnico própio --}}
      <hr>

      <form onsubmit="return confirmAction()" class="mr-4" method="POST" action="{{ route('fleet.test-repair-orders.create') }}">
        @csrf
        @method('PUT')

        <div class="flex flex-wrap -mx-3 mb-6 mt-2">
          <div class="w-full md:w-2/4">
            {!! Form::label('TiempoDesplazamiento','Tiempo de desplazamiento (minutos):',['class' => 'mr-3']) !!}
            {!! Form::number('desplazamiento_min', '35', ['class' => 'form-input md:w-1/6']) !!}
          </div>
          <div class="w-full md:w-2/4">
            <div class="form-group">
              {!! Form::label('Siniestro','¿Se trata de un siniestro?:',['class' => 'mr-3']) !!}
              SI {!! Form::radio('siniestro', '1', '', ['style' => 'margin-right: 0.5em']) !!}
              NO {!! Form::radio('siniestro', '0', 'false') !!}
            </div>
          </div>
        </div>

        <div class="flex flex-wrap -mx-3 mb-6">
          <div class="w-full md:w-2/4">
            {{-- lanza en JS un bloque volador donde introducir los datos de operación y desde ahí se genera la operación 
              --}}
            <button class="btn-indigo" id="insertoperation" type="button" onclick="return LanzarOperacion()">
              <i class="fas fa-plus mr-2"></i> AÑADIR OPERACIÓN
            </button>
          </div>
          <div class="w-full md:w-2/4">
            <div class="form-group">
              {!! Form::label('malos_Usos','¿Intervención por malos usos / golpes?:',['class' => 'mr-3']) !!}
              SI {!! Form::radio('malos_Usos', '1', '', ['style' => 'margin-right: 0.5em']) !!}
              NO {!! Form::radio('malos_Usos', '0', 'false') !!}
            </div>
          </div>
        </div>

        <div id="newOperation">
          {{-- Contenido listado de operaciones creadas en esta Incidencia. (forech de operations)  --}}
        </div>
        <button class="btn-indigo float-right mb-2">
          Guardar
        </button>
      </form>
    </div>

    <div id="ExternalTechnician" class="mt-8" style="display: none">
      {{-- contenedor oculto con los datos de nuevo correctivo con datos de técnico externo --}}
      <hr>

      <form onsubmit="return confirmAction()" class="mr-4" method="POST" action="{{ route('fleet.test-repair-orders.create') }}">
        @csrf
        @method('PUT')
      <div class="flex flex-wrap -mx-3 mb-6 mt-2">
        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
          <label class="form-label">
            Flota
          </label>
          {!! Form::text('fleet', 'URBAN TRUCKS', ['class' => 'form-input']) !!}
        </div>
        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
          <label class="form-label">
            ¿fecha de entrada?:
          </label>
          {!! Form::text('date', '2021-12-04', ['class' => 'form-input datepicker']) !!}
        </div>
        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
          <label class="form-label">
            ¿nº de pedido?:
          </label>
          {!! Form::number('n_pedido', '1', ['class' => 'form-input']) !!}
        </div>
      </div>

      <H2>DESCRIPCIÓN:</H2> 

      <div class="flex flex-wrap -mx-3 mb-6 mt-2 ml-2">
        <div class="w-full md:w-3/12 px-3 mb-6">
          {!! Form::select('equipo', ['Equipo' => 'Equipo', '-' => '-'], null, ['class' => 'form-select']) !!}
        </div>
        <div class="w-full md:w-3/12 px-3 mb-6">
          {!! Form::select('tipo_de_equipo', ['Hidráulica' => 'Hidráulica', '-' => '-'], null, ['class' => 'form-select']) !!}
        </div>
        <div class="w-full md:w-12/12 px-3 mb-2 mt-2">
          {!! Form::textarea('descripcion',  '(CAUSA) p.ej.: La prensa no tiene fuerza.', ['class' => 'appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500']) !!}
        </div>
      </div>

      <div class="flex flex-wrap -mx-3 mb-6 ml-6">
        <div class="form-group w-full">
          {!! Form::label('Siniestro','¿Se trata de un siniestro?:',['class' => 'mr-3']) !!}
          SI {!! Form::radio('Siniestro', '1', '',['style' => 'margin-right: 1em']) !!}
          NO {!! Form::radio('Siniestro', '0', 'false') !!}
        </div>
        <div class="form-group w-full">
          {!! Form::label('Malos_Usos','¿Intervención por malos usos / golpes?:',['class' => 'mr-3']) !!}
          SI {!! Form::radio('Malos_Usos', '1', '',['style' => 'margin-right: 1em']) !!}
          NO {!! Form::radio('Malos_Usos', '0', 'false') !!}
        </div>
      </div>

      <H2>¿YA HA SALIDO DEL TALLER?:</H2>
      
      <div class="flex flex-wrap -mx-3 mb-6 mt-2 ml-2">
        <div class="w-full md:w-6/12 px-3 mb-6 mt-1">
          SI {!! Form::radio('Salio_De_Taller', '1') !!}<br>
          NO {!! Form::radio('Salio_De_Taller', '0', 'false') !!}
        </div>
        <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
          {!! Form::text('date', '2021-01-01', ['class' => 'form-input datepicker']) !!}
        </div>
      </div>
        <button class="btn-indigo float-right mb-2">
          Guardar
        </button>
      </form>

    </div>

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

var no = 0;
function LanzarOperacion(){
  no++;
  var contenido = "<div class='w-full md:w-1/12'>"+no+"</div><div class='w-full md:w-11/12 border-2 border-secondary'><div class='flex flex-wrap'><div class='w-full md:w-3/12'><select name='chasis' id='chasis' class='form-select'><option value='Chasis'>Chasis</option><option value='Equipo'>Equipo</option><option value='Hidráulica'>Hidráulica</option></select></div><div class='w-full md:w-3/12 ml-1'><select name='Mecánica' id='Mecánica' class='form-select'><option value='Mecanica'>Mecánica</option><option value='-'>-</option></select></div><div class='w-full md:w-4/12 ml-1'><input type='number' id='desplazamiento_min' name='desplazamiento_min' class='form-input md:w-1/4'> (min)</div><div class='w-full md:w-1/12 float-right'><button type='button' class='mr-2'><i class='fas fa-check'></i></button><button type='button' id='"+no+"' onclick='return removeOperation(this.id)'><i class='fas fa-trash'></i></button></div></div><div class='flex flex-wrap mt-1'><div class='w-full'><textarea name='datos' id='datos' rows='2' class='form-input'></textarea></div></div><button class='btn-indigo' id='"+no+"' type='button' onclick='return LanzarRecambio(this.id)'><i class='fas fa-plus mr-2'></i> AÑADIR RECAMBIO</button><div id='recambios"+no+"' class='container'></div>";
  var div = document.createElement("div");
  div.setAttribute("class", "flex flex-wrap mx-1 mb-6 mt-2");
  div.setAttribute("id", "operation"+no);
  div.innerHTML = contenido;
  const $contenedor = document.getElementById("newOperation");
  $contenedor.prepend(div);
}

var nr = 0;
function LanzarRecambio(id){
  nr++;
  var contenido = "<div class='w-full md:w-4/12'><input type='text' id='nombre' name='nombre' class='form-input'></div><div class='w-full md:w-2/12 ml-1'><input type='text' id='codigo' name='codigo' class='form-input'></div><div class='w-full md:w-2/12 ml-1'><input type='text' id='estado' name='estado' class='form-input'></div><div class='w-full md:w-2/12 ml-1'><input type='text' id='coste' name='coste' class='form-input'></div><div class='md:w-1/12'><button type='button' id='"+nr+"' onclick='return removeRecambio(this.id)'><i class='fas fa-trash ml-3'></i></button></div>";
  var div = document.createElement("div");
  div.setAttribute("class", "flex flex-wrap mx-1 mb-6 mt-2");
  div.setAttribute("id", "recambio"+nr);
  div.innerHTML = contenido;
  const $contenedor = document.getElementById("recambios"+id);
  $contenedor.prepend(div);
}

function removeRecambio(id){
  const container = document.getElementById("recambio"+id).remove();
}
function removeOperation(id){
  const container = document.getElementById("operation"+id).remove();
}
</script>