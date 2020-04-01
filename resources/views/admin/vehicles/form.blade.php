<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
      <label class="form-label" >
        Flota
      </label>
      <div class="relative">
        {!! Form::select('fleet_id', $fleets->pluck('name', 'id')->prepend('',''), null, ['class' => 'form-input']) !!}
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
          <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
        </div>
      </div>
  </div>
  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
    <label class="form-label" >
      Matrícula
    </label>
    {!! Form::text('plate', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
    <label class="form-label" >
      Bastidor
    </label>
    {!! Form::text('vin', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
    <label class="form-label" >
      Kms
    </label>
    {!! Form::number('kms', null, ['class' => 'form-input']) !!}
  </div>
</div>


<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
    <label class="form-label">
      Marca Chasis
    </label>
    <div class="relative">
      {!! Form::select('chassis_maker_id', $manufacturers->pluck('name', 'id')->prepend('',''), null, ['class' => 'form-input', 'onchange' => "ajaxSelect('chassis_maker_id', 'chassis_model_id', '/api/manufacturer/{id}/models')"]) !!}
      <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
      </div>
    </div>
  </div>
  <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
    <label class="form-label">
      Modelo Chasis
    </label>
    <div class="relative">
      {!! Form::select('chassis_model_id', $models->pluck('name', 'id')->prepend('',''), null, ['class' => 'form-input']) !!}
      <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
      </div>
    </div>
  </div>
  <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
    <label class="form-label" >
      Garantía
    </label>
    {!! Form::date('warranty_chassis', null, ['class' => 'form-input']) !!}
  </div>
</div>


<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
    <label class="form-label">
      Tipo de vehículo
    </label>
    <div class="relative">
      {!! Form::select('vehicle_type', [
        '' => '',
        'Carga Trasera' => 'Carga Trasera',
        'Carga Lateral' => 'Carga Lateral',
        'Carga Superior' => 'Carga Superior'
      ], null, ['class' => 'form-input']) !!}
      <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
      </div>
    </div>
  </div>
  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
    <label class="form-label">
      Tipo de Cambio
    </label>
    <div class="relative">
      {!! Form::select('gearbox_type', [
        '' => '',
        'Automática' => 'Automática',
        'Autoamtizada' => 'Autoamtizada',
        'Manual' => 'Manual'
      ], null, ['class' => 'form-input']) !!}
      <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
      </div>
    </div>
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

<br>

<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
    <label class="form-label" >
      Fecha matriculación
    </label>
    {!! Form::date('registration_date', null, ['class' => 'form-input', 'step' => '0.01']) !!}
  </div>
  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
    <label class="form-label" >
      Fecha compra
    </label>
    {!! Form::date('purchase_date', null, ['class' => 'form-input', 'step' => '0.01']) !!}
  </div>
  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
    <label class="form-label" >
      Fecha itv
    </label>
    {!! Form::date('itv_date', null, ['class' => 'form-input', 'step' => '0.01']) !!}
  </div>
  <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
    <label class="form-label" >
      Fecha baja
    </label>
    {!! Form::date('discharged_at', null, ['class' => 'form-input', 'step' => '0.01']) !!}
  </div>
</div>

<br>

<fieldset>
  <legend>Dimensiones</legend>
  <div class="flex flex-wrap -mx-3 mb-6">
    <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
      <label class="form-label" >
        Distancia entre ejes
      </label>
      {!! Form::number('axes_distance', null, ['class' => 'form-input', 'step' => '0.01']) !!}
    </div>
    <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
      <label class="form-label" >
        Ancho
      </label>
      {!! Form::number('width', null, ['class' => 'form-input', 'step' => '0.01']) !!}
    </div>
    <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
      <label class="form-label" >
        Alto
      </label>
      {!! Form::number('height', null, ['class' => 'form-input', 'step' => '0.01']) !!}
    </div>
    <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
      <label class="form-label" >
        Longitud
      </label>
      {!! Form::number('length', null, ['class' => 'form-input', 'step' => '0.01']) !!}
    </div>
    <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
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
        Número de serie
      </label>
      {!! Form::text('powertakeoff_serial_number', null, ['class' => 'form-input']) !!}
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
  </div>
</fieldset>

<br>

<fieldset>
  <legend>Caja de cambios</legend>
  <div class="flex flex-wrap -mx-3 mb-6">
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
  </div>
</fieldset>

<br>