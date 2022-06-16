@extends('layouts.pdf')

@section('content')
<div class="p-4">
  <div class="grid grid-cols-2">
      <div class="">
        <img class="h-20" src="https://www.wasterent.es/img/wasterent_logo.png">
      </div>
      <div class=" text-right">
          <h1 class="text-3xl">Albarán de {{ $delivery->type == 'delivery'  ? 'entrega':'devolución' }}</h1>
          <p class="mt-4">12/07/2022</p>
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
          @if($delivery->check_front_tires)
            <i class="fas fa-check-circle text-xl mr-2"></i>
          @else
            <i class="fas fa-times text-xl ml-1 mr-2"></i>
          @endif
          Neumáticos delanteros
        </li>
        <li>
          @if($delivery->check_tires_2_axis)
            <i class="fas fa-check-circle text-xl mr-2"></i>
          @else
            <i class="fas fa-times text-xl ml-1 mr-2"></i>
          @endif
          Neumáticos 2º eje
        </li>
        <li>
          @if($delivery->check_tires_3_axis)
            <i class="fas fa-check-circle text-xl mr-2"></i>
          @else
            <i class="fas fa-times text-xl ml-1 mr-2"></i>
          @endif
          Neumáticos 3º eje
        </li>
        <li>
          @if($delivery->check_extinguisher)
            <i class="fas fa-check-circle text-xl mr-2"></i>
          @else
            <i class="fas fa-times text-xl ml-1 mr-2"></i>
          @endif
          Extintor
        </li>
        <li>
          @if($delivery->check_clean_cabin)
            <i class="fas fa-check-circle text-xl mr-2"></i>
          @else
            <i class="fas fa-times text-xl ml-1 mr-2"></i>
          @endif
          Limpieza interior
        </li>
        <li>
          @if($delivery->check_clean_exterior)
            <i class="fas fa-check-circle text-xl mr-2"></i>
          @else
            <i class="fas fa-times text-xl ml-1 mr-2"></i>
          @endif
          Limpieza exterior
        </li>
      </ul>

      <p class="font-bold text-lg mt-6">Observaciones</p>
      <div class="border rounded p-2 mr-4 bg-gray-200 text-sm">
        {!! $delivery->comments !!}
      </div>

      <div class="grid grid-cols-2 gap-3 mr-4 mt-4">
        <div class="h-28 border border-dashed rounded border-gray-900">
            <p class="text-center text-sm">{{ auth()->user()->fleet->name }}</p>
        </div>
        <div class="h-28 border border-dashed rounded border-gray-900">
            <p class="text-center text-sm">{{ $delivery->customer->name }}</p>
        </div>
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

@push('js')
<script type="text/javascript">
  window.print();
</script>
@endpush
