<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
    <label class="form-label form-required">
      Foto del parte
    </label>
    {!! Form::file('file', null, ['class' => 'form-input']) !!}
  </div>
</div>

<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full px-3 mb-6 md:mb-0">
    <label class="form-label form-required">
      Breve descripción
    </label>
    {!! Form::textarea('summary', null, ['class' => 'form-input']) !!}
  </div>
</div>


