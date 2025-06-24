<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full px-3 mb-6 md:mb-0">
    <label class="form-label form-required">
      Descripción
    </label>
    {!! Form::text('description', null, ['class' => 'form-input']) !!}
  </div>
</div>

<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
    <label class="form-label form-required">
      Marca
    </label>
    {!! Form::text('manufacturer', null, ['class' => 'form-input']) !!}
  </div>

  <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
    <label class="form-label form-required">  
      Referencia
    </label>
    {!! Form::text('reference', null, ['class' => 'form-input']) !!}
  </div>

  <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
    <label class="form-label form-required">
      Precio Unitario
    </label>
    {!! Form::number('unit_price', null, ['class' => 'form-input', 'step' => 'any']) !!}
  </div>

  <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
    <label class="form-label form-required">
      Stock
    </label>
    {!! Form::number('stock', null, ['class' => 'form-input', 'step' => 'any']) !!}
  </div>

  <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
    <label class="form-label form-required">
      Stock de seguridad  
    </label>
    {!! Form::number('safety_stock', null, ['class' => 'form-input', 'step' => 'any']) !!}
  </div>
</div>
