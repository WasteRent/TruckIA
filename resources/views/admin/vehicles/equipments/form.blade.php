<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
    <label class="form-label">
      Marca Equipo
    </label>
    <div class="relative">
      {!! Form::select('maker_id', $manufacturers->pluck('name', 'id')->prepend('',''), null, ['class' => 'form-input', 'onchange' => "ajaxSelect('maker_id', 'model_id', '/api/manufacturer/{id}/models')"]) !!}
      <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
      </div>
    </div>
  </div>
  <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
    <label class="form-label">
      Modelo Equipo
    </label>
    <div class="relative">
      {!! Form::select('model_id', $models->pluck('name', 'id')->prepend('',''), null, ['class' => 'block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500']) !!}
      <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
      </div>
    </div>
  </div>
  <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
    <label class="form-label" >
      Versión
    </label>
    {!! Form::text('version', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
    <label class="form-label" >
      Placa
    </label>
    {!! Form::text('plate', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
    <label class="form-label" >
      Garantía
    </label>
    {!! Form::date('warranty_date', null, ['class' => 'form-input']) !!}
  </div>
</div>

<fieldset>
  <legend>Bomba</legend>
  <div class="flex flex-wrap -mx-3 mb-6">
    <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
      <label class="form-label" >
        Número de serie
      </label>
      {!! Form::text('bomb_serial_number', null, ['class' => 'form-input']) !!}
    </div>
    <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
      <label class="form-label" >
        Marca
      </label>
      {!! Form::text('bomb_maker', null, ['class' => 'form-input']) !!}
    </div>
    <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
      <label class="form-label" >
        Modelo
      </label>
      {!! Form::text('bomb_model', null, ['class' => 'form-input']) !!}
    </div>
  </div>
</fieldset>
<br>