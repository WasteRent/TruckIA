<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full px-3 mb-6 md:mb-0">
    <label class="form-label form-required">
      Nombre
    </label>
    {!! Form::text('name', null, ['class' => 'form-input']) !!}
  </div>
</div>

<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
      <label class="form-label form-required">
        Marca
      </label>
        {!! Form::select('manufacturer_id', $manufacturers->pluck('name', 'id'), null, ['class' => 'form-select', 'onchange' => "ajaxSelect('manufacturer_id', 'model_id', '/api/manufacturer/{id}/models')"]) !!}
  </div>
  <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
      <label class="form-label form-required">
        Modelo
      </label>
        {!! Form::select('model_id', $models->pluck('name', 'id'), null, ['class' => 'form-select']) !!} 
  </div>
</div>

<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
      <label class="form-label">
        Kms
      </label>
      {!! Form::number('kms', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
      <label class="form-label">
        Horas naturales
      </label>
      {!! Form::number('natural_hours', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
      <label class="form-label">
        Horas de Trabajo
      </label>
      {!! Form::number('work_hours', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
      <label class="form-label">
        Horas CAN
      </label>
      {!! Form::number('can_hours', null, ['class' => 'form-input']) !!}
  </div>
</div>
