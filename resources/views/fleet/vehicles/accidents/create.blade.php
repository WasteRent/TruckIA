{!! Form::open([
    'route' => ['fleet.vehicles.accident-reports.store', $vehicle],
    'method' => 'POST',
    'class' => 'w-full'
  ]) !!}  
  
  <div class="flex flex-wrap -mx-3 mb-6">
    <div class="w-full px-3 mb-6">
      <label class="form-label form-required">
        {{ __('Descripción') }}
      </label>
      <x-trix name="summary" />
    </div>
    <div class="sm:w-1/5 px-3 mb-6 md:mb-0">
      <label class="form-label form-required">
        {{ __('Fecha') }}
      </label>
      {!! Form::date('created_at', now()->format('Y-m-d'), ['class' => 'form-input datepicker']) !!}
    </div>
  </div>
  
  <div class="flex justify-end">
    <button class="btn-indigo">{{ __('Guardar') }}</button>
  </div>
  
  {!! Form::close() !!}