@extends('layouts.pdf')

@section('content')
<div class="text-xl">
  <span class="font-bold mr-4">OR #{{$repair_order->id}}</span> {{$repair_order->created_at->format('d/m/Y H:i')}}
</div>

<p class="text-lg mb-4">
  {{$repair_order->vehicle->plate }}
  {{$repair_order->vehicle->chassis }} &middot;
  @foreach($repair_order->vehicle->equipments as $equipment)
  {{$equipment->maker->name}} {{$equipment->model->name}}
  @endforeach
</p>

<form>
  Kms &nbsp;<input type="text" class="border mr-2" name="">&nbsp;
  H. Camión &nbsp;<input type="text" class="border mr-2" name="">&nbsp;
  H. Equipo &nbsp;<input type="text" class="border mr-2" name="">&nbsp;
</form>


@foreach($operations->groupBy('maintenance_plan_name') as $operations)
<br><br>
@if($operations->first()->maintenance_plan_name != null)
<h1 class="font-bold mt-4">{{$operations->first()->maintenance_plan_name}}</h1>
@else
<h1 class="font-bold mt-4">Otras Operaciones</h1>
@endif
<table class="table-auto">
  <thead>
    <tr>
      <th class="px-4 py-2"></th>
      <th class="px-4 py-2">Descripción</th>
      <th class="px-4 py-2">Tiempo (h)</th>
      <th class="px-4 py-2">Estado</th>
    </tr>
  </thead>
  <tbody>
      @foreach($operations as $i => $operation)
        <tr>
          <td class="border px-4 py-2">{{$i+1}}</td>
          <td class="border px-4 py-2">
            <strong>{{ $operation->operation_name }}</strong><br>
            <p class="mt-2">{{ $operation->operation_description }}</p>
            @if($operation->operationAttachment)
              <br> <img class="max-w-lg" src="{{ $operation->operationAttachment->getLink() }}">
            @endif
          </td>
          <td class="border px-4 py-2">{{ $operation->estimated_time_in_hours }}</td>
          <td class="border px-4 py-2">
            <i class="far fa-square fa-lg"></i>
          </td>
        </tr>
      @endforeach
  </tbody>
</table>
@endforeach

<p class="mt-6 text-red-600 text-sm italic">Toda la información relativa a mantenimientos contenida en la presente documentación es propiedad del fabricante del vehículo aquí tratado, y ha sido obtenida a través de autorización expresa del cliente propietario del vehículo. Queda terminantemente prohibida su reproducción, difusión, distribución, transformación de acuerdo al RDL 1/1996 del 12 de abril referido a la Ley de Propiedad Intelectual.</p>

@endsection
