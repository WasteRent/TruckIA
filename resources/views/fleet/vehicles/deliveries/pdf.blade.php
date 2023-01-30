@extends('layouts.pdf')

@section('content')
<div class="p-4">
  <div class="grid grid-cols-2">
      <div class="">
        @if(Auth::user()->fleet->id == 1)
          <img class="h-20" src="https://www.wasterent.es/img/wasterent_logo.png">
        @else
          <img class="h-20" src="{{ Auth::user()->getLogo() }}">
        @endif
      </div>
      <div class=" text-right">
          <h1 class="text-3xl">Albarán de {{ $delivery->type == 'delivery'  ? 'entrega':'devolución' }}</h1>
          <p class="mt-4">{{ Carbon\Carbon::parse($delivery->date)->format('d/m/Y') }}</p>
      </div>
  </div>

  <table class="table-auto mt-8">
    <thead>
      <tr class="bg-gray-200">
        <th class="px-4 py-2 bg-gray-200">Matrícula</th>
        <th class="px-4 py-2 bg-gray-200">Chasis</th>
        <th class="px-4 py-2 bg-gray-200">Equipo</th>
        <th class="px-4 py-2 bg-gray-200">Contrato</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="border px-4 py-2">{{ $delivery->vehicle->plate }}</td>
        <td class="border px-4 py-2">{{ $delivery->vehicle->chassis }}</td>
        <td class="border px-4 py-2">{{ $delivery->vehicle->equipment }}</td>
        <td class="border px-4 py-2">{{ $delivery->contract_type }}</td>
      </tr>
    </tbody>
  </table>

  <table class="table-auto mt-2">
    <thead>
      <tr class="bg-gray-200">
        <th class="px-4 py-2 bg-gray-200">Combustible</th>
        <th class="px-4 py-2 bg-gray-200">Kms</th>
        <th class="px-4 py-2 bg-gray-200">Horas motor</th>
        <th class="px-4 py-2 bg-gray-200">Horas equipo</th>
        <th class="px-4 py-2 bg-gray-200">Cliente</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="border px-4 py-2">{{ $delivery->fuel_level }}</td>
        <td class="border px-4 py-2">{{ $delivery->kms }}</td>
        <td class="border px-4 py-2">{{ $delivery->hours }}</td>
        <td class="border px-4 py-2">{{ $delivery->hours }}</td>
        <td class="border px-4 py-2">{{ $delivery->customer->name }}</td>
      </tr>
    </tbody>
  </table>

  <div class="grid grid-cols-3 mt-6">
    <div class="col-span-2">
      <ul class="text-gray-800 space-y-2">
        <li>
          @if($delivery->check_security)
            <span class="border border-gray-700 p-1 mr-2"><i class="fas fa-check"></i></span>
          @else
            <span class="border border-gray-700 p-1 mr-2" style="padding-right: 0.4rem;"><i style="padding-left: 0.2rem;" class="fas fa-times"></i></span>
          @endif
          Seguridades
        </li>
        <li>
          @if($delivery->check_training)
            <span class="border border-gray-700 p-1 mr-2"><i class="fas fa-check"></i></span>
          @else
            <span class="border border-gray-700 p-1 mr-2" style="padding-right: 0.4rem;"><i style="padding-left: 0.2rem;" class="fas fa-times"></i></span>
          @endif
          Formación
        </li>
        <li>
          @if($delivery->check_gps)
            <span class="border border-gray-700 p-1 mr-2"><i class="fas fa-check"></i></span>
          @else
            <span class="border border-gray-700 p-1 mr-2" style="padding-right: 0.4rem;"><i style="padding-left: 0.2rem;" class="fas fa-times"></i></span>
          @endif
          GPS
        </li>
        <li>
          @if($delivery->check_front_tires)
            <span class="border border-gray-700 p-1 mr-2"><i class="fas fa-check"></i></span>
          @else
            <span class="border border-gray-700 p-1 mr-2" style="padding-right: 0.4rem;"><i style="padding-left: 0.2rem;" class="fas fa-times"></i></span>
          @endif
          Neumáticos delanteros
        </li>
        <li>
          @if($delivery->check_tires_2_axis)
            <span class="border border-gray-700 p-1 mr-2"><i class="fas fa-check"></i></span>
          @else
            <span class="border border-gray-700 p-1 mr-2" style="padding-right: 0.4rem;"><i style="padding-left: 0.2rem;" class="fas fa-times"></i></span>
          @endif
          Neumáticos 2º eje
        </li>
        <li>
          @if($delivery->check_tires_3_axis)
            <span class="border border-gray-700 p-1 mr-2"><i class="fas fa-check"></i></span>
          @else
            <span class="border border-gray-700 p-1 mr-2" style="padding-right: 0.4rem;"><i style="padding-left: 0.2rem;" class="fas fa-times"></i></span>
          @endif
          Neumáticos 3º eje
        </li>
        <li>
          @if($delivery->check_extinguisher)
            <span class="border border-gray-700 p-1 mr-2"><i class="fas fa-check"></i></span>
          @else
            <span class="border border-gray-700 p-1 mr-2" style="padding-right: 0.4rem;"><i style="padding-left: 0.2rem;" class="fas fa-times"></i></span>
          @endif
          Extintor
        </li>
        <li>
          @if($delivery->check_clean_cabin)
            <span class="border border-gray-700 p-1 mr-2"><i class="fas fa-check"></i></span>
          @else
            <span class="border border-gray-700 p-1 mr-2" style="padding-right: 0.4rem;"><i style="padding-left: 0.2rem;" class="fas fa-times"></i></span>
          @endif
          Limpieza interior
        </li>
        <li>
          @if($delivery->check_clean_exterior)
            <span class="border border-gray-700 p-1 mr-2"><i class="fas fa-check"></i></span>
          @else
            <span class="border border-gray-700 p-1 mr-2" style="padding-right: 0.4rem;"><i style="padding-left: 0.2rem;" class="fas fa-times"></i></span>
          @endif
          Limpieza exterior
        </li>
        <li>
          @if($delivery->check_full_cycle)
            <span class="border border-gray-700 p-1 mr-2"><i class="fas fa-check"></i></span>
          @else
            <span class="border border-gray-700 p-1 mr-2" style="padding-right: 0.4rem;"><i style="padding-left: 0.2rem;" class="fas fa-times"></i></span>
          @endif
          Prueba de equipo ciclo completo
        </li>
        <li>
          @if($delivery->check_dump_cycle)
            <span class="border border-gray-700 p-1 mr-2"><i class="fas fa-check"></i></span>
          @else
            <span class="border border-gray-700 p-1 mr-2" style="padding-right: 0.4rem;"><i style="padding-left: 0.2rem;" class="fas fa-times"></i></span>
          @endif
          Ciclo de descarga
        </li>
        <li>
          @if($delivery->check_lights)
            <span class="border border-gray-700 p-1 mr-2"><i class="fas fa-check"></i></span>
          @else
            <span class="border border-gray-700 p-1 mr-2" style="padding-right: 0.4rem;"><i style="padding-left: 0.2rem;" class="fas fa-times"></i></span>
          @endif
          Luces
        </li>
        <li>
          @if($delivery->check_itv)
            <span class="border border-gray-700 p-1 mr-2"><i class="fas fa-check"></i></span>
          @else
            <span class="border border-gray-700 p-1 mr-2" style="padding-right: 0.4rem;"><i style="padding-left: 0.2rem;" class="fas fa-times"></i></span>
          @endif
          ITV
        </li>
        <li>
          @if($delivery->check_tacograph)
            <span class="border border-gray-700 p-1 mr-2"><i class="fas fa-check"></i></span>
          @else
            <span class="border border-gray-700 p-1 mr-2" style="padding-right: 0.4rem;"><i style="padding-left: 0.2rem;" class="fas fa-times"></i></span>
          @endif
          Tacógrafo
        </li>
        <li>
          @if($delivery->check_preventive_chassis)
            <span class="border border-gray-700 p-1 mr-2"><i class="fas fa-check"></i></span>
          @else
            <span class="border border-gray-700 p-1 mr-2" style="padding-right: 0.4rem;"><i style="padding-left: 0.2rem;" class="fas fa-times"></i></span>
          @endif
          Preventivo chasis
        </li>
        <li>
          @if($delivery->check_preventive_equipment)
            <span class="border border-gray-700 p-1 mr-2"><i class="fas fa-check"></i></span>
          @else
            <span class="border border-gray-700 p-1 mr-2" style="padding-right: 0.4rem;"><i style="padding-left: 0.2rem;" class="fas fa-times"></i></span>
          @endif
          Preventivo equipo
        </li>
        <li>
          @if($delivery->check_security_triangles)
            <span class="border border-gray-700 p-1 mr-2"><i class="fas fa-check"></i></span>
          @else
            <span class="border border-gray-700 p-1 mr-2" style="padding-right: 0.4rem;"><i style="padding-left: 0.2rem;" class="fas fa-times"></i></span>
          @endif
          Triángulos de seguridad
        </li>
        <li>
          @if($delivery->check_reflective_vest)
            <span class="border border-gray-700 p-1 mr-2"><i class="fas fa-check"></i></span>
          @else
            <span class="border border-gray-700 p-1 mr-2" style="padding-right: 0.4rem;"><i style="padding-left: 0.2rem;" class="fas fa-times"></i></span>
          @endif
          Chaleco reflectante
        </li>
        <li>
          @if($delivery->check_documents)
            <span class="border border-gray-700 p-1 mr-2"><i class="fas fa-check"></i></span>
          @else
            <span class="border border-gray-700 p-1 mr-2" style="padding-right: 0.4rem;"><i style="padding-left: 0.2rem;" class="fas fa-times"></i></span>
          @endif
          Documentación del vehículo
        </li>
        <li>
          @if($delivery->check_fluid_levels)
            <span class="border border-gray-700 p-1 mr-2"><i class="fas fa-check"></i></span>
          @else
            <span class="border border-gray-700 p-1 mr-2" style="padding-right: 0.4rem;"><i style="padding-left: 0.2rem;" class="fas fa-times"></i></span>
          @endif
          Niveles de fluidos
        </li>
        <li>
          @if($delivery->check_rubber_status)
            <span class="border border-gray-700 p-1 mr-2"><i class="fas fa-check"></i></span>
          @else
            <span class="border border-gray-700 p-1 mr-2" style="padding-right: 0.4rem;"><i style="padding-left: 0.2rem;" class="fas fa-times"></i></span>
          @endif
          Estado goma culera
        </li>
      </ul>


      <div class="grid grid-cols-2 gap-3 mr-4 mt-4">
        <div class="h-28 border border-dashed rounded border-gray-900">
            <p class="text-center text-sm">{{ auth()->user()->fleet->name }}</p>
        </div>
        <div class="h-28 border border-dashed rounded border-gray-900">
            <p class="text-center text-sm">{{ $delivery->customer->name }}</p>
        </div>
      </div>

      <p class="font-bold text-lg mt-6">Observaciones</p>
      <div class="border rounded p-2 mr-4 bg-gray-200 text-sm">
        {!! $delivery->comments !!}
      </div>
      



    </div>
    <div class="space-y-8">
      <img class="rounded shadow" src="{{ optional($delivery->front_picture)->getLink() }}">
      <img class="rounded shadow" src="{{ optional($delivery->back_picture)->getLink() }}">
      <img class="rounded shadow" src="{{ optional($delivery->right_picture)->getLink() }}">
      <img class="rounded shadow" src="{{ optional($delivery->left_picture)->getLink() }}">
    </div>
  </div>

  
</div>
@endsection
