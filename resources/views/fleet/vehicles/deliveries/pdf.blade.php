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
            {!! Form::radio('check_front_tire_right', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
            {!! Form::radio('check_front_tire_right', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
            {!! Form::radio('check_front_tire_right', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
            {!! Form::radio('check_front_tire_right', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
            Neumático delantero derecho
          </li>
          <li class="flex items-center mr-1">
            {!! Form::radio('check_front_tire_left', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
            {!! Form::radio('check_front_tire_left', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
            {!! Form::radio('check_front_tire_left', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
            {!! Form::radio('check_front_tire_left', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
            Neumático delantero izquierdo
          </li>
          <li class="flex items-center mr-1">
            {!! Form::radio('check_tire_2_axis_right', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
            {!! Form::radio('check_tire_2_axis_right', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
            {!! Form::radio('check_tire_2_axis_right', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
            {!! Form::radio('check_tire_2_axis_right', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
            Neumático 2º eje derecho
          </li>
          <li class="flex items-center mr-1">
            {!! Form::radio('check_tire_2_axis_left', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
            {!! Form::radio('check_tire_2_axis_left', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
            {!! Form::radio('check_tire_2_axis_left', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
            {!! Form::radio('check_tire_2_axis_left', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
            Neumático 2º eje izquierdo
          </li>
          <li class="flex items-center mr-1">
            {!! Form::radio('check_tire_3_axis_right', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
            {!! Form::radio('check_tire_3_axis_right', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
            {!! Form::radio('check_tire_3_axis_right', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
            {!! Form::radio('check_tire_3_axis_right', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
            Neumático 3º eje derecho
          </li>
          <li class="flex items-center mr-1">
            {!! Form::radio('check_tire_3_axis_left', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
            {!! Form::radio('check_tire_3_axis_left', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
            {!! Form::radio('check_tire_3_axis_left', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
            {!! Form::radio('check_tire_3_axis_left', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
            Neumático 3º eje izquierdo
          </li>
          <li class="flex items-center mr-1">
            {!! Form::radio('check_front_axle_mud_flaps', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
            {!! Form::radio('check_front_axle_mud_flaps', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
            {!! Form::radio('check_front_axle_mud_flaps', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
            {!! Form::radio('check_front_axle_mud_flaps', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
            Faldillas eje delantero
          </li>
          <li class="flex items-center mr-1">
            {!! Form::radio('check_2_axle_mud_flaps', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
            {!! Form::radio('check_2_axle_mud_flaps', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
            {!! Form::radio('check_2_axle_mud_flaps', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
            {!! Form::radio('check_2_axle_mud_flaps', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
            Faldillas 2º eje
          </li>
          <li class="flex items-center mr-1">
            {!! Form::radio('check_3_axle_mud_flaps', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
            {!! Form::radio('check_3_axle_mud_flaps', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
            {!! Form::radio('check_3_axle_mud_flaps', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
            {!! Form::radio('check_3_axle_mud_flaps', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
            Faldillas 3º eje
          </li>
          <li class="flex items-center mr-1">
            {!! Form::radio('check_fire_extinguishers', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
            {!! Form::radio('check_fire_extinguishers', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
            {!! Form::radio('check_fire_extinguishers', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
            {!! Form::radio('check_fire_extinguishers', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
            Extintores
          </li>
          <li class="flex items-center mr-1">
            {!! Form::radio('check_battery_cap', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
            {!! Form::radio('check_battery_cap', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
            {!! Form::radio('check_battery_cap', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
            {!! Form::radio('check_battery_cap', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
            Tapa baterias
          </li>
          <li class="flex items-center mr-1">
            {!! Form::radio('check_windows_glass', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
            {!! Form::radio('check_windows_glass', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
            {!! Form::radio('check_windows_glass', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
            {!! Form::radio('check_windows_glass', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
            Luna y cristales
          </li>
          <li class="flex items-center mr-1">
            {!! Form::radio('check_fuel_adblue_cap', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
            {!! Form::radio('check_fuel_adblue_cap', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
            {!! Form::radio('check_fuel_adblue_cap', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
            {!! Form::radio('check_fuel_adblue_cap', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
            Tapón gasoil / adblue
          </li>
          <li class="flex items-center mr-1">
            {!! Form::radio('check_rotating_work_lights', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
            {!! Form::radio('check_rotating_work_lights', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
            {!! Form::radio('check_rotating_work_lights', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
            {!! Form::radio('check_rotating_work_lights', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
            Rotativos-Faros de trabajo
          </li>
          <li class="flex items-center mr-1">
            {!! Form::radio('check_headlights_pilots_lamps', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
            {!! Form::radio('check_headlights_pilots_lamps', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
            {!! Form::radio('check_headlights_pilots_lamps', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
            {!! Form::radio('check_headlights_pilots_lamps', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
            Faros-Pilotos y tulipas
          </li>
          <li class="flex items-center mr-1">
            {!! Form::radio('check_right_mirror', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
            {!! Form::radio('check_right_mirror', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
            {!! Form::radio('check_right_mirror', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
            {!! Form::radio('check_right_mirror', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
            Retrovisor derecho
          </li>
          <li class="flex items-center mr-1">
            {!! Form::radio('check_left_mirror', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
            {!! Form::radio('check_left_mirror', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
            {!! Form::radio('check_left_mirror', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
            {!! Form::radio('check_left_mirror', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
            Retrovisor izquierdo
          </li>
          <li class="flex items-center mr-1">
            {!! Form::radio('check_interior_cleaning', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
            {!! Form::radio('check_interior_cleaning', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
            {!! Form::radio('check_interior_cleaning', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
            {!! Form::radio('check_interior_cleaning', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
            Limpieza interior
          </li>
          <li class="flex items-center mr-1">
            {!! Form::radio('check_exterior_cleaning', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
            {!! Form::radio('check_exterior_cleaning', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
            {!! Form::radio('check_exterior_cleaning', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
            {!! Form::radio('check_exterior_cleaning', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
            Limpieza exterior
          </li>
          <li class="flex items-center mr-1">
            {!! Form::radio('check_vest_triangle_light', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
            {!! Form::radio('check_vest_triangle_light', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
            {!! Form::radio('check_vest_triangle_light', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
            {!! Form::radio('check_vest_triangle_light', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
            Chaleco y triángulo (luz)
          </li>
          <li class="flex items-center mr-1">
            {!! Form::radio('check_documentation', 'Bien', null, ['class' => 'mr-1 focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300']) !!} Bien
            {!! Form::radio('check_documentation', 'Reg', null, ['class' => 'mr-1 ml-4 focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300']) !!} Reg
            {!! Form::radio('check_documentation', 'Mal', null, ['class' => 'mr-1 ml-4 focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300']) !!} Mal
            {!! Form::radio('check_documentation', 'N/A', null, ['class' => 'mr-1 ml-4 focus:ring-gray-500 h-4 w-4 text-gray-600 border-gray-300']) !!} N/A
            Documentación
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
