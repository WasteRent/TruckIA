{!! Form::open([
    'route' => ['fleet.containers.checklists.store', $container],
    'method' => 'POST',
    'class' => 'w-full'
  ]) !!}  
  
  <div class="flex flex-wrap -mx-3 mb-6">
    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
      <label class="form-label form-required">
        {{ __('Tipo') }}
      </label>
      <select name="checklist_id" class="form-input" required>
        <option value="">{{ __('Seleccionar checklist') }}</option>
        <option value="9">Preventivo</option>
        <option value="10">Correctivo</option>
      </select>
    </div>
    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
      <label class="form-label form-required">
        {{ __('Fecha') }}
      </label>
      {!! Form::date('date', now()->format('Y-m-d'), ['class' => 'form-input datepicker']) !!}
    </div>
  </div>
  
  <div class="flex justify-end">
    <button class="btn-indigo">{{ __('Guardar') }}</button>
  </div>
  
  {!! Form::close() !!}

