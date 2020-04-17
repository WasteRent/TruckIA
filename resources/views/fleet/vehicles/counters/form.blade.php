<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
    <label class="form-label form-required">
      Tipo
    </label>
    {!! Form::select('type', ['hours' => 'hours', 'kms' => 'kms'], null, ['class' => 'form-select']) !!}
  </div>
  <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
    <label class="form-label form-required">
      Actual
    </label>
    {!! Form::number('current', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
    <label class="form-label form-required">
      Máximo
    </label>
    {!! Form::number('max', null, ['class' => 'form-input']) !!}
  </div>
</div>

<br>