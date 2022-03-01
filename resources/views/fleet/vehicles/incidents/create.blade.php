{!! Form::open([
    'route' => ['fleet.vehicles.incidents.store', $vehicle],
    'method' => 'POST',
    'class' => 'w-full'
  ]) !!}  
  
  <div class="flex flex-wrap -mx-3 mb-6">
    <div class="w-full px-3 mb-6 md:mb-0">
      <label class="form-label form-required">
        Incidencia
      </label>
      <x-trix name="incidence" />
    </div>
    <div class="w-1/6 px-3 mb-6 md:mb-0">
      <label class="form-label form-required">
        Fecha
      </label>
      {!! Form::text('created_at', now()->format('d/m/Y'), ['class' => 'form-input datepicker']) !!}
    </div>
  </div>
  
  <div class="flex justify-end">
    <button class="btn-indigo">Guardar</button>
  </div>
  
  {!! Form::close() !!}