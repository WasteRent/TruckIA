@extends('layouts.pdf')

@section('content')
<div class="p-4">
  <div class="grid grid-cols-2">
      <div class="">
          <img class="h-12" src="{{ Auth::user()->getLogo() }}">
      </div>
      <div class=" text-right">
          <h1 class="text-3xl">{{'Checklist '.$vehicle_checklist->checklist->name.' vehiculo #' . $vehicle_checklist->vehicle->plate}}</h1>
          <p class="mt-2">{{ Carbon\Carbon::parse($vehicle_checklist->date)->format('d/m/Y') }}</p>
      </div>
  </div>


  <div class="grid grid-cols-3 mt-6">
    <div class="col-span-3">
      {!! Form::model($vehicle_checklist, []) !!}  
        
		@include('fleet.vehicles.checklist.form')
      </form>

      <div class="space-y-8">
        <div class="grid grid-cols-1 gap-x-4 ">
            @include('shared.grid', [
                'grid_x' => explode('x', $vehicle_checklist->grid)[0],
                'grid_y' => explode('x', $vehicle_checklist->grid)[1],
                'select_positions' => $vehicle_checklist->positions,
            ])
        </div>
      </div>

      <p class="font-bold text-lg mt-6">Observaciones</p>
      <div class="border rounded p-2 mr-4 bg-gray-200 text-sm">
        {!! $vehicle_checklist->notes !!}
      </div>

      <div class="grid grid-cols-2 gap-3 mr-4 mt-4">
        <div class="min-h-20 border border-dashed rounded border-gray-900">
            <p class="text-center text-sm">Firma</p>
            @if($vehicle_checklist->signature)
              <img class="mb-2 h-32" src="{{ $vehicle_checklist->signature }}">
            @endif
        </div>
      </div>


    </div>
  </div>

  
</div>
@endsection
