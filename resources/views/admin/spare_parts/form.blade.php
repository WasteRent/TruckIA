<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-3/12 px-3 mb-6 md:mb-0">
    <label class="form-label">
      Referencia
    </label>
    {!! Form::text('reference', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
    <label class="form-label">
      Precio
    </label>
    {!! Form::number('price', null, ['class' => 'form-input', 'step' => '0.01']) !!}
  </div>
  <div class="w-full md:w-7/12 px-3 mb-6 md:mb-0">
    <label class="form-label">
      Descripción
    </label>
    {!! Form::text('description', null, ['class' => 'form-input']) !!}
  </div>
</div>