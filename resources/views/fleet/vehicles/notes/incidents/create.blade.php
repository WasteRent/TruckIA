{!! Form::open([
    'route' => ['fleet.vehicles.notes.incidents.store', $vehicle],
    'method' => 'POST',
    'class' => 'w-full'
  ]) !!}  
  
  <div class="flex flex-wrap -mx-3 mb-6">
    <div class="w-full px-3 mb-6 md:mb-0">
      <label class="form-label form-required">
        Descripción
      </label>
      {!! Form::textarea('incidence', null, ['class' => 'form-input', 'rows' => 3]) !!}
    </div>
  </div>
  
  <div class="flex justify-end">
    <button class="btn-indigo">Guardar</button>
  </div>
  
  {!! Form::close() !!}