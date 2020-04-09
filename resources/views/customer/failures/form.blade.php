<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-2/3 px-3 mb-6 md:mb-0">
      <label class="form-label" >
        Avería
      </label>
        {!! Form::select('failure_type_id', $types->pluck('name', 'id'), null, ['placeholder' => '', 'class' => 'form-select']) !!}
  </div>

  <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
    <label class="form-label">
      Teléfono de Contacto
    </label>
    {!! Form::text('phone', null, ['class' => 'form-input']) !!}
  </div>
  
</div>

<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full px-3 mb-6 md:mb-0">
    <label class="form-label">
      Observaciones
    </label>
    {!! Form::textarea('observations', null, ['class' => 'form-input']) !!}
  </div>
</div>


