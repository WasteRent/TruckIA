<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-8/12 px-3 mb-6 md:mb-0">
    <label class="form-label">
      Nombre
    </label>
    {!! Form::text('name', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
      <label class="form-label">
        Marca
      </label>
        {!! Form::select('manufacturer_id', $manufacturers->pluck('name', 'id'), null, ['class' => 'form-select', 'onchange' => "ajaxSelect('manufacturer_id', 'model_id', '/api/manufacturer/{id}/models')"]) !!}
  </div>
  <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
      <label class="form-label">
        Modelo
      </label>
        {!! Form::select('model_id', $models->pluck('name', 'id'), null, ['class' => 'form-select']) !!}
        
  </div>
</div>

<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
      <label class="form-label">
        Tipo de frecuencia 1
      </label>
        {!! Form::select('frequency_type_1', [
          'Horas' => 'Horas',
          'Horas CAN' => 'Horas CAN',
          'Kms' => 'Kms'
        ], null, ['class' => 'form-select']) !!}
        
  </div>
  <div class="w-full md:w-1/4 px-3">
    <label class="form-label">
      Frecuencia
    </label>
    {!! Form::text('frequency_1', null, ['class' => 'form-input']) !!}
  </div>
</div>

<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
      <label class="form-label">
        Tipo de frecuencia 2
      </label>
        {!! Form::select('frequency_type_2', [
          '' => '',
          'Horas' => 'Horas',
          'Horas CAN' => 'Horas CAN',
          'Kms' => 'Kms'
        ], null, ['class' => 'form-select']) !!}
        
  </div>
  <div class="w-full md:w-1/4 px-3">
    <label class="form-label">
      Frecuencia
    </label>
    {!! Form::text('frequency_2', null, ['class' => 'form-input']) !!}
  </div>
</div>


<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
      <label class="form-label">
        Tipo de frecuencia 3
      </label>
        {!! Form::select('frequency_type_3', [
          '' => '',
          'Horas' => 'Horas',
          'Horas CAN' => 'Horas CAN',
          'Kms' => 'Kms'
        ], null, ['class' => 'form-select']) !!}
   
  </div>
  <div class="w-full md:w-1/4 px-3">
    <label class="form-label">
      Frecuencia
    </label>
    {!! Form::text('frequency_3', null, ['class' => 'form-input']) !!}
  </div>
</div>


