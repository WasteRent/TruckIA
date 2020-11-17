<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full px-3 mb-6 md:mb-0">
    <label class="form-label form-required">
      Descripción
    </label>
    {!! Form::text('description', null, ['class' => 'form-input']) !!}
  </div>
</div>

<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
    <label class="form-label form-required">
      Marca
    </label>
    {!! Form::text('manufacturer', null, ['class' => 'form-input']) !!}
  </div>

  <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
    <label class="form-label form-required">  
      Referencia
    </label>
    {!! Form::text('reference', null, ['class' => 'form-input']) !!}
  </div>

  <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
    <label class="form-label form-required">
      Precio Unitario
    </label>
    {!! Form::number('unit_price', null, ['class' => 'form-input', 'step' => 'any']) !!}
  </div>
</div>


<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
      <label class="form-label">
        Marca
      </label>
        {!! Form::select('vehicle_manufacturer_id', $manufacturers->pluck('name', 'id'), null, ['placeholder' => '', 'class' => 'form-select', 'onchange' => "ajaxSelect('vehicle_manufacturer_id', 'vehicle_model_id', '/api/manufacturer/{id}/models')"]) !!}
  </div>
  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
      <label class="form-label">
        Modelo
      </label>
        {!! Form::select('vehicle_model_id', $models->pluck('name', 'id'), null, ['class' => 'form-select', 'onchange' => "ajaxSelect('vehicle_model_id', 'vehicle_maintenance_plan_id', '/api/models/{id}/plans')"]) !!}
  </div>
  <div class="w-full md:w-2/4 px-3 mb-6 md:mb-0">
      <label class="form-label">
        Gama
      </label>
        {!! Form::select('vehicle_maintenance_plan_id', $plans->pluck('name', 'id'), null, ['class' => 'form-select']) !!} 
  </div>  
</div>