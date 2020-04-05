<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
    <label class="form-label form-required">
      Matrícula
    </label>
    {!! Form::text('plate', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
    <label class="form-label" >
      Kms
    </label>
    {!! Form::number('kms', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
    <label class="form-label" >
      Horas de trabajo
    </label>
    {!! Form::number('work_hours', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
    <label class="form-label" >
      Horas CAN
    </label>
    {!! Form::number('can_hours', null, ['class' => 'form-input']) !!}
  </div>
</div>


<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
    <label class="form-label" >
      Bastidor
    </label>
    {!! Form::text('vin', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
    <label class="form-label">
      Marca Chasis
    </label>
      {!! Form::select('chassis_maker_id', $manufacturers->pluck('name', 'id')->prepend('',''), null, ['class' => 'form-select', 'onchange' => "ajaxSelect('chassis_maker_id', 'chassis_model_id', '/api/manufacturer/{id}/models')"]) !!}
  </div>
  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
    <label class="form-label">
      Modelo Chasis
    </label>
      {!! Form::select('chassis_model_id', $models->pluck('name', 'id')->prepend('',''), null, ['class' => 'form-select']) !!}
  </div>
</div>


<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
    <label class="form-label">
      Tipo de vehículo
    </label>
      {!! Form::select('vehicle_type', [
        '' => '',
        'Carga Trasera' => 'Carga Trasera',
        'Carga Lateral' => 'Carga Lateral',
        'Carga Superior' => 'Carga Superior'
      ], null, ['class' => 'form-select']) !!}
  </div>
  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
    <label class="form-label" >
      Cilindrada 
    </label>
    {!! Form::number('cc3', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
    <label class="form-label" >
      KW
    </label>
    {!! Form::number('power_kw', null, ['class' => 'form-input']) !!}
  </div>
</div>

<fieldset>
  <legend>Fechas</legend>  
  <div class="flex flex-wrap -mx-3 mb-6">
    <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
      <label class="form-label" >
        Fecha Garantía
      </label>
      {!! Form::text('warranty_date', null, ['class' => 'form-input datepicker']) !!}
    </div>
    <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
      <label class="form-label" >
        Fecha 1º matriculación
      </label>
      {!! Form::text('registration_date', null, ['class' => 'form-input datepicker']) !!}
    </div>
    <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
      <label class="form-label" >
        Fecha compra
      </label>
      {!! Form::text('purchase_date', null, ['class' => 'form-input datepicker']) !!}
    </div>
    <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
      <label class="form-label" >
        Fecha itv
      </label>
      {!! Form::text('itv_date', null, ['class' => 'form-input datepicker']) !!}
    </div>
    <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
      <label class="form-label" >
        Fecha baja
      </label>
      {!! Form::text('discharged_at', null, ['class' => 'form-input datepicker']) !!}
    </div>
  </div>
</fieldset>

<br>

<fieldset>
  <legend>Dimensiones</legend>
  <div class="flex flex-wrap -mx-3 mb-6">
    <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
      <label class="form-label" >
        Nº Ejes
      </label>
      {!! Form::number('number_of_axes', null, ['class' => 'form-input', 'step' => '0.01']) !!}
    </div>
    <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
      <label class="form-label" >
        Dist. ejes 1-2
      </label>
      {!! Form::number('axe_1_2_distance', null, ['class' => 'form-input', 'step' => '0.01']) !!}
    </div>
    <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
      <label class="form-label" >
        Dist. ejes 3-4
      </label>
      {!! Form::number('axe_3_4_distance', null, ['class' => 'form-input', 'step' => '0.01']) !!}
    </div>
    <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
      <label class="form-label" >
        Ancho
      </label>
      {!! Form::number('width', null, ['class' => 'form-input', 'step' => '0.01']) !!}
    </div>
    <div class="w-full md:w-2/12 px-3 mb-6">
      <label class="form-label" >
        Alto
      </label>
      {!! Form::number('height', null, ['class' => 'form-input', 'step' => '0.01']) !!}
    </div>
    <div class="w-full md:w-2/12 px-3">
      <label class="form-label" >
        Longitud
      </label>
      {!! Form::number('length', null, ['class' => 'form-input', 'step' => '0.01']) !!}
    </div>
    <div class="w-full md:w-2/12 px-3">
      <label class="form-label" >
        Tara (kg)
      </label>
      {!! Form::number('tare_kg', null, ['class' => 'form-input', 'step' => '0.01']) !!}
    </div>
    <div class="w-full md:w-2/12 px-3">
      <label class="form-label" >
        MMA (kg)
      </label>
      {!! Form::number('mma_kg', null, ['class' => 'form-input', 'step' => '0.01']) !!}
    </div>
  </div>
</fieldset>

<br>

<fieldset>
  <legend>Toma de Fuerza</legend>
  <div class="flex flex-wrap -mx-3 mb-6">
    <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
      <label class="form-label" >
        Tipo
      </label>
      {!! Form::select('powertakeoff_type', [
        '' => '',
        'Volante Motor' => 'Volante Motor',
        'Cambio Plato' => 'Cambio Plato',
        'Cambio Piñon' => 'Cambio Piñon'
      ], null, ['class' => 'form-select']) !!}
    </div>
    <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
      <label class="form-label" >
        Marca
      </label>
      {!! Form::text('powertakeoff_maker', null, ['class' => 'form-input']) !!}
    </div>
    <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
      <label class="form-label" >
        Modelo
      </label>
      {!! Form::text('powertakeoff_model', null, ['class' => 'form-input']) !!}
    </div>
    <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
      <label class="form-label" >
        Número de serie
      </label>
      {!! Form::text('powertakeoff_serial_number', null, ['class' => 'form-input']) !!}
    </div>
  </div>
</fieldset>

<br>

<fieldset>
  <legend>Caja de cambios</legend>
  <div class="flex flex-wrap -mx-3 mb-6">
    <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
      <label class="form-label">
        Tipo
      </label>
        {!! Form::select('gearbox_type', [
          '' => '',
          'Automática' => 'Automática',
          'Autoamtizada' => 'Autoamtizada',
          'Manual' => 'Manual'
        ], null, ['class' => 'form-select']) !!}
    </div>
    <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
      <label class="form-label" >
        Marca
      </label>
      {!! Form::text('gearbox_maker', null, ['class' => 'form-input']) !!}
    </div>
    <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
      <label class="form-label" >
        Modelo
      </label>
      {!! Form::text('gearbox_model', null, ['class' => 'form-input']) !!}
    </div>
    <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
      <label class="form-label" >
        Número de serie
      </label>
      {!! Form::text('gearbox_serial_number', null, ['class' => 'form-input']) !!}
    </div>
  </div>
</fieldset>

<br>