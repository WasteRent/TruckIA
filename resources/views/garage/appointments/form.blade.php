<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
    <label class="form-label">
      Fecha/Hora
    </label>
    {!! Form::datetimeLocal('date_time', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-3/4 px-3 mb-6 md:mb-0">
    <label class="form-label">
      Vehículo
    </label>
    @php
      $vehicle_id = request()->vehicle_id ?? $appointment->vehicle_id;
      $repair_order_id = request()->repair_order_id ?? $appointment->repair_order_id;
    @endphp
    <input class="form-input" type="text" value="{{ 
      App\Models\Vehicle::findOrFail($vehicle_id)->fullname 
    }}" disabled>
    <input type="hidden" name="vehicle_id" value="{{ $vehicle_id }}">
    <input type="hidden" name="repair_order_id" value="{{ $repair_order_id }}">
  </div>
</div>

<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full px-3 mb-6 md:mb-0">
    <label class="form-label">
      Nota
    </label>
    {!! Form::textarea('notes', null, ['class' => 'form-input']) !!}
  </div>
</div>
