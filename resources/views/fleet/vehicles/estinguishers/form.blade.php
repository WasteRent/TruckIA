<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-5/12 px-3 mb-6 md:mb-0">
    <label class="form-label form-required">
      Nombre
    </label>
    {!! Form::text('name', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
    <label class="form-label">
      Código
    </label>
    {!! Form::text('code', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
    <label class="form-label">
      Fecha de expiración
    </label>
    {!! Form::text('expiration_date', null, ['class' => 'form-input datepicker']) !!}
  </div>
</div>

