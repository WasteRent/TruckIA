@extends('layouts.pdf')

@section('content')
<div class="p-4">
  <div class="grid grid-cols-2">
      <div class="">
        @if(Auth::user()->fleet->id == 1)
          <img class="h-12" src="https://www.wasterent.es/img/wasterent_logo.png">
        @else
          <img class="h-12" src="{{ Auth::user()->getLogo() }}">
        @endif
      </div>
      <div class=" text-right">
          <h1 class="text-3xl">Albarán de {{ $delivery->type == 'delivery'  ? 'entrega':'devolución' }}</h1>
          <p class="mt-2">{{ Carbon\Carbon::parse($delivery->date)->format('d/m/Y') }}</p>
      </div>
  </div>

  <table class="table-auto mt-4">
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
        <td class="border px-4 py-2">{{ $delivery->chassis_hours }}</td>
        <td class="border px-4 py-2">{{ $delivery->equipment_hours }}</td>
        <td class="border px-4 py-2">{{ $delivery->customer->name }}</td>
      </tr>
    </tbody>
  </table>

  <div class="grid grid-cols-3 mt-6">
    <div class="col-span-2">
      {!! Form::model($delivery, []) !!}  
        <ul class="text-gray-800 text-sm space-y-2">
          <li class="flex items-center mr-1">
            {!! Form::radio('check_security', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
            {!! Form::radio('check_security', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
            {!! Form::radio('check_security', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
            {!! Form::radio('check_security', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
            Seguridades
          </li>
          <li class="flex items-center mr-1">
            {!! Form::radio('check_training', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
            {!! Form::radio('check_training', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
            {!! Form::radio('check_training', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
            {!! Form::radio('check_training', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
            Formación
          </li>
          <li class="flex items-center mr-1">
            {!! Form::radio('check_gps', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
            {!! Form::radio('check_gps', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
            {!! Form::radio('check_gps', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
            {!! Form::radio('check_gps', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
            GPS
          </li>
          <li class="flex items-center mr-1">
            {!! Form::radio('check_front_tires', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
            {!! Form::radio('check_front_tires', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
            {!! Form::radio('check_front_tires', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
            {!! Form::radio('check_front_tires', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
            Neumáticos delanteros
          </li>
          <li class="flex items-center mr-1">
            {!! Form::radio('check_tires_2_axis', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
            {!! Form::radio('check_tires_2_axis', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
            {!! Form::radio('check_tires_2_axis', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
            {!! Form::radio('check_tires_2_axis', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
            Neumáticos 2º eje
          </li>
          <li class="flex items-center mr-1">
            {!! Form::radio('check_tires_3_axis', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
            {!! Form::radio('check_tires_3_axis', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
            {!! Form::radio('check_tires_3_axis', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
            {!! Form::radio('check_tires_3_axis', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
            Neumáticos 3º eje
          </li>
          <li class="flex items-center mr-1">
            {!! Form::radio('check_extinguisher', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
            {!! Form::radio('check_extinguisher', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
            {!! Form::radio('check_extinguisher', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
            {!! Form::radio('check_extinguisher', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
            Extintor
          </li>
          <li class="flex items-center mr-1">
            {!! Form::radio('check_clean_cabin', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
            {!! Form::radio('check_clean_cabin', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
            {!! Form::radio('check_clean_cabin', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
            {!! Form::radio('check_clean_cabin', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
            Limpieza interior
          </li>
          <li class="flex items-center mr-1">
            {!! Form::radio('check_clean_exterior', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
            {!! Form::radio('check_clean_exterior', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
            {!! Form::radio('check_clean_exterior', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
            {!! Form::radio('check_clean_exterior', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
            Limpieza exterior
          </li>
          <li class="flex items-center mr-1">
            {!! Form::radio('check_full_cycle', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
            {!! Form::radio('check_full_cycle', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
            {!! Form::radio('check_full_cycle', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
            {!! Form::radio('check_full_cycle', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
            Prueba de equipo ciclo completo
          </li>
          <li class="flex items-center mr-1">
            {!! Form::radio('check_dump_cycle', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
            {!! Form::radio('check_dump_cycle', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
            {!! Form::radio('check_dump_cycle', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
            {!! Form::radio('check_dump_cycle', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
            Ciclo de descarga
          </li>
          <li class="flex items-center mr-1">
            {!! Form::radio('check_lights', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
            {!! Form::radio('check_lights', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
            {!! Form::radio('check_lights', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
            {!! Form::radio('check_lights', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
            Luces
          </li>
          <li class="flex items-center mr-1">
            {!! Form::radio('check_itv', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
            {!! Form::radio('check_itv', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
            {!! Form::radio('check_itv', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
            {!! Form::radio('check_itv', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
            ITV
          </li>
          <li class="flex items-center mr-1">
            {!! Form::radio('check_tacograph', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
            {!! Form::radio('check_tacograph', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
            {!! Form::radio('check_tacograph', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
            {!! Form::radio('check_tacograph', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
            Tacógrafo
          </li>
          <li class="flex items-center mr-1">
            {!! Form::radio('check_preventive_chassis', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
            {!! Form::radio('check_preventive_chassis', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
            {!! Form::radio('check_preventive_chassis', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
            {!! Form::radio('check_preventive_chassis', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
            Preventivo chasis
          </li>
          <li class="flex items-center mr-1">
            {!! Form::radio('check_preventive_equipment', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
            {!! Form::radio('check_preventive_equipment', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
            {!! Form::radio('check_preventive_equipment', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
            {!! Form::radio('check_preventive_equipment', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
            Preventivo equipo
          </li>
          <li class="flex items-center mr-1">
            {!! Form::radio('check_security_triangles', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
            {!! Form::radio('check_security_triangles', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
            {!! Form::radio('check_security_triangles', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
            {!! Form::radio('check_security_triangles', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
            Triángulos de seguridad
          </li>
          <li class="flex items-center mr-1">
            {!! Form::radio('check_reflective_vest', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
            {!! Form::radio('check_reflective_vest', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
            {!! Form::radio('check_reflective_vest', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
            {!! Form::radio('check_reflective_vest', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
            Chaleco reflectante
          </li>
          <li class="flex items-center mr-1">
            {!! Form::radio('check_documents', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
            {!! Form::radio('check_documents', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
            {!! Form::radio('check_documents', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
            {!! Form::radio('check_documents', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
            Documentación del vehículo
          </li>
          <li class="flex items-center mr-1">
            {!! Form::radio('check_fluid_levels', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
            {!! Form::radio('check_fluid_levels', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
            {!! Form::radio('check_fluid_levels', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
            {!! Form::radio('check_fluid_levels', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
            Niveles de fluidos
          </li>
          <li class="flex items-center mr-1">
            {!! Form::radio('check_rubber_status', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
            {!! Form::radio('check_rubber_status', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
            {!! Form::radio('check_rubber_status', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
            {!! Form::radio('check_rubber_status', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
            Estado goma culera
          </li>
        </ul>
      </form>
      <div class="grid grid-cols-2 gap-3 mr-4 mt-4">
        <div class="min-h-20 border border-dashed rounded border-gray-900">
            <p class="text-center text-sm">{{ auth()->user()->fleet->name }}</p>
            @if($delivery->signature)
            <img class="mb-2 h-32" src="{{ $delivery->signature }}">
          @endif
        </div>
        <div class="min-h-20 border border-dashed rounded border-gray-900">
            <p class="text-center text-sm">{{ $delivery->customer->name }}</p>
            @if($delivery->signature_team)
            <img class="mb-2 h-32" src="{{ $delivery->signature_team }}">
          @endif
            
        </div>
      </div>

      <p class="font-bold text-lg mt-6">Observaciones</p>
      <div class="border rounded p-2 mr-4 bg-gray-200 text-sm">
        {!! $delivery->comments !!}
      </div>
      



    </div>
    <div class="space-y-8">
      <img class="w-32 rounded shadow" src="{{ optional($delivery->front_picture)->getLink() }}">
      <img class="w-32 rounded shadow" src="{{ optional($delivery->back_picture)->getLink() }}">
      <img class="w-32 rounded shadow" src="{{ optional($delivery->right_picture)->getLink() }}">
      <img class="w-32 rounded shadow" src="{{ optional($delivery->left_picture)->getLink() }}">
    </div>
  </div>

  
</div>
@endsection
