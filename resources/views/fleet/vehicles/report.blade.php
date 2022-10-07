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
          <h1 class="text-3xl">Reporte</h1>
          <p class="mt-4">{{ now()->format('d/m/Y') }}</p>
      </div>
  </div>

  <table class="table-auto mt-8">
    <thead>
      <tr class="bg-gray-200">
        <th class="px-4 py-2 bg-gray-200">Matrícula</th>
        <th class="px-4 py-2 bg-gray-200">Chasis</th>
        <th class="px-4 py-2 bg-gray-200">Equipo</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="border px-4 py-2">{{ $vehicle->plate }}</td>
        <td class="border px-4 py-2">{{ $vehicle->chassis }}</td>
        <td class="border px-4 py-2">{{ $vehicle->equipment }}</td>
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
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="border px-4 py-2">{{ $vehicle->fuel }}</td>
        <td class="border px-4 py-2">{{ $vehicle->kms }}</td>
        <td class="border px-4 py-2">{{ $vehicle->chassis_can_work_hours ?? $vehicle->chassis_gps_work_hours }}</td>
        <td class="border px-4 py-2">{{ $vehicle->equipment_work_hours }}</td>
      </tr>
    </tbody>
  </table>

  @foreach($orders as $order)

    <h1 class="mt-10 font-bold">#OR {{ $order->id }} {{ Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }}</h1>
    <ul>
      @foreach($order->operations->groupBy('maintenance_plan_name') as $operations)
      @if($operations->first()->maintenance_plan_name != null)
      <h2 class="font-medium my-2 underline">{{$operations->first()->maintenance_plan_name}}</h2>
      @else
      <h2 class="font-medium my-2 underline">Otras Operaciones</h2>
      @endif
      <table class="table-auto">
        <thead>
          <tr>
            <th class="px-4 py-2">#</th>
            <th class="px-4 py-2">Descripción</th>
          </tr>
        </thead>
        <tbody>
            @foreach($operations as $i => $operation)
              <tr>
                <td class="border px-4 py-2">{{$i+1}}</td>
                <td class="border px-4 py-2">{{ $operation->operation_name }}</td>
              </tr>
            @endforeach
        </tbody>
      </table>
      @endforeach
    </ul>
  @endforeach


  
</div>
@endsection

@push('js')
<script type="text/javascript">
  window.print();
</script>
@endpush
