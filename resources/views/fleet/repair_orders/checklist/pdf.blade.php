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
          <h1 class="text-3xl">{{'Checklist '.$repair_order_checklist->checklist->name.' de orden de reparación #' . $repair_order_checklist->repairOrder->id}}</h1>
          <p class="mt-2">{{ Carbon\Carbon::parse($repair_order_checklist->date)->format('d/m/Y') }}</p>
      </div>
  </div>


  <div class="grid grid-cols-3 mt-6">
    <div class="col-span-2">
      {!! Form::model($repair_order_checklist, []) !!}  
        
		@include('fleet.repair_orders.checklist.form')
      </form>
      <div class="grid grid-cols-2 gap-3 mr-4 mt-4">
        <div class="min-h-20 border border-dashed rounded border-gray-900">
            <p class="text-center text-sm">{{ auth()->user()->fleet->name }}</p>
        </div>
        <div class="min-h-20 border border-dashed rounded border-gray-900">
            <p class="text-center text-sm">Firma</p>
            @if($repair_order_checklist->signature)
              <img class="mb-2 h-32" src="{{ $repair_order_checklist->signature }}">
            @endif
        </div>
      </div>

      <p class="font-bold text-lg mt-6">Observaciones</p>
      <div class="border rounded p-2 mr-4 bg-gray-200 text-sm">
        {!! $repair_order_checklist->notes !!}
      </div>
      



    </div>
    <div class="space-y-8">
      <img class="w-32 rounded shadow" src="{{ optional($repair_order_checklist->front_picture)->getLink() }}">
      <img class="w-32 rounded shadow" src="{{ optional($repair_order_checklist->back_picture)->getLink() }}">
      <img class="w-32 rounded shadow" src="{{ optional($repair_order_checklist->right_picture)->getLink() }}">
      <img class="w-32 rounded shadow" src="{{ optional($repair_order_checklist->left_picture)->getLink() }}">
    </div>
  </div>

  
</div>
@endsection
