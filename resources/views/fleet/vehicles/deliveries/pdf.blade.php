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

  <div class="mt-6" style="overflow: hidden;">
    <div style="width: 65%; float: left;">
      {!! Form::model($delivery, []) !!}  
        @if($delivery->created_at > \App\Models\VehicleDeliveryNote::CONCEPTS_UPDATE_2025_10_21)
          @include('components.pdf-delivery-vehicle-concepts')
        @else
          @include('components.pdf-delivery-vehicle-concepts_old')
        @endif
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
    <div class="space-y-8" style="width: 30%; float: right;">
      <img class="w-32 rounded shadow" src="{{ optional($delivery->front_picture)->getLink() }}">
      <img class="w-32 rounded shadow" src="{{ optional($delivery->back_picture)->getLink() }}">
      <img class="w-32 rounded shadow" src="{{ optional($delivery->right_picture)->getLink() }}">
      <img class="w-32 rounded shadow" src="{{ optional($delivery->left_picture)->getLink() }}">
    </div>
  </div>

  
</div>
@endsection
