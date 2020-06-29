<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
    <label class="form-label form-required">
      Tipo
    </label>
    {!! Form::select('type', [
      'work_hours' => 'Horas de Trabajo',
      'natural_hours' => 'Horas Naturales',
      'kms' => 'Kilómetros'
    ], null, ['class' => 'form-select']) !!}
  </div>
  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
    <label class="form-label form-required">
      Categoría
    </label>
    {!! Form::select('vehicle_category', [
      'chassis' => 'Chasis',
      'equipment' => 'Equipo'
    ], null, ['class' => 'form-select']) !!}
  </div>
  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
    <label class="form-label form-required">
      Valor Actual
    </label>
    {!! Form::number('current', null, ['class' => 'form-input', 'step' => '0.01']) !!}
  </div>
  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
    <label class="form-label form-required">
      Valor Máximo
    </label>
    {!! Form::number('max', null, ['class' => 'form-input']) !!}
  </div>
</div>
<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full px-3 mb-6 md:mb-0">
    <label class="form-label">
      Descripción
    </label>
    {!! Form::text('description', null, ['class' => 'form-input']) !!}
  </div>
</div>


<br>