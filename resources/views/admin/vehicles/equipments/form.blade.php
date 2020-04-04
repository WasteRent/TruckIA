<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
    <label class="form-label">
      Marca Equipo
    </label>
      {!! Form::select('maker_id', $manufacturers->pluck('name', 'id')->prepend('',''), null, ['class' => 'form-select', 'onchange' => "ajaxSelect('maker_id', 'model_id', '/api/manufacturer/{id}/models')"]) !!}
  </div>
  <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
    <label class="form-label">
      Modelo Equipo
    </label>
      {!! Form::select('model_id', $models->pluck('name', 'id')->prepend('',''), null, ['class' => 'form-select']) !!}
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
    {!! Form::text('warranty_date', null, ['class' => 'form-input datepicker']) !!}
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