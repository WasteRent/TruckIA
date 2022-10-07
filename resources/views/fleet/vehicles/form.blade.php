<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
    <label class="form-label form-required">
      {{ __('Matrícula') }}
    </label>
    {!! Form::text('plate', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-3/12 px-3 mb-6 md:mb-0">
    <label class="form-label form-required">
      {{ __('Marca chasis') }}
    </label>
      {!! Form::select('chassis_maker_id', $manufacturers->pluck('name', 'id')->prepend('',''), null, ['class' => 'form-select', 'onchange' => "ajaxSelect('chassis_maker_id', 'chassis_model_id', '/api/manufacturer/{id}/models')"]) !!}
  </div>
  <div class="w-full md:w-3/12 px-3 mb-6 md:mb-0">
    <label class="form-label form-required">
      {{ __('Modelo chasis') }}
    </label>
      {!! Form::select('chassis_model_id', $models->pluck('name', 'id')->prepend('',''), null, ['class' => 'form-select', 'onchange' => "ajaxSelect('chassis_model_id', 'chassis_version_id', '/api/models/{id}/versions')"]) !!}
  </div>
  <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
    <label class="form-label">
      {{ __('Den. comercial') }}
    </label>
      {!! Form::select('chassis_version_id', $versions->pluck('name', 'id')->prepend('',''), null, ['class' => 'form-select']) !!}
  </div>
  <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
    <div class="flex">
      <label class="form-label">
        {{ __('Estado') }}
      </label>
      <div class="tooltip">
        <i class="fas fa-info-circle fa-xs"></i>
        <span class="tooltiptext">
          @if(isset($vehicle))
            <ul>
              @foreach($vehicle->stateHistory()->get() as $history)
                <li><strong>{{ __(optional($history->state)->name) }}</strong>  {{ optional($history->user)->name }} {{ $history->created_at->format('d/m/Y H:i') }}</li>
              @endforeach
            </ul>
          @endif
        </span>
      </div>
    </div>
    {!! Form::select('state_id', $states->pluck('name', 'id')->prepend('','')->mapWithKeys(function($value, $key) {
      return [$key => __($value)];
    }), null, ['class' => 'form-select']) !!}
  </div>
</div>

<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-3/12 px-3 mb-6 md:mb-0">
    <label class="form-label" >
      {{ __('Bastidor') }}
    </label>
    {!! Form::text('vin', null, ['class' => 'form-input']) !!}
  </div> 
  <div class="w-full md:w-3/12 px-3 mb-6 md:mb-0">
    <label class="form-label">
      {{ __('Tipo de vehículo') }}
    </label>
    {!! Form::select('vehicle_type_id', $types->pluck('name', 'id'), null, ['class' => 'form-select', 'placeholder' => '']) !!}
  </div>
  <div class="w-full md:w-3/12 px-3 mb-6 md:mb-0">
    <label class="form-label">
      {{ __('Combustible') }}
    </label>
      {!! Form::select('fuel', [
        '' => '',
        'Diesel' => 'Diesel',
        'Petrol' => 'Gasolina',
        'Gas' => 'Gas',
        'Electric' => 'Eléctrico'
      ], null, ['class' => 'form-select']) !!}
  </div>
  <div class="w-full md:w-3/12 px-3 mb-6 md:mb-0">
    <label class="form-label">
      {{ __('Normativa Euro') }}
    </label>
      {!! Form::select('euro', [
        '' => '',
        'EuroVI' => 'EuroVI',
        'EuroV' => 'EuroV',
        'EuroIV' => 'EuroIV',
        'EuroIII' => 'EuroIII',
        'EuroII' => 'EuroII'
      ], null, ['class' => 'form-select']) !!}
  </div>
  <div class="w-full md:w-3/12 px-3 mb-6 md:mb-0 md:mt-6">
    <label class="form-label" >
      {{ __('Cilindrada') }}
    </label>
    {!! Form::number('cc3', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-3/12 px-3 mb-6 md:mb-0 md:mt-6">
    <label class="form-label" >
      KW
    </label>
    {!! Form::number('power_kw', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0 md:mt-6">
    <label class="form-label" >
      {{ __('Tacógrafo') }}
    </label>
      {!! Form::select('tachograph', [
        '' => '',
        '1' => 'Si',
        '0' => 'No'
      ], null, ['class' => 'form-select']) !!}
  </div>
  <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0 md:mt-6">
    <label class="form-label" >
      {{ __('Tacógrafo exento') }}
    </label>
      {!! Form::select('tachograph_exempt', [
        '0' => 'No',
        '1' => 'Si'
      ], null, ['class' => 'form-select']) !!}
  </div>
  <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0 md:mt-6">
    <label class="form-label" >
      {{ __('ITV exento') }}
    </label>
      {!! Form::select('itv_exempt', [
        '0' => 'No',
        '1' => 'Si'
      ], null, ['class' => 'form-select']) !!}
  </div>
  @if(in_array(Auth::id(), [920,929,637,872]))
  <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0 md:mt-6">
    <label class="form-label" >
      {{ __('Flota') }}
    </label>
      {!! Form::select('fleet_id', App\Models\Fleet::all()->pluck('name', 'id'), null, ['class' => 'form-select']) !!}
  </div>
  @endif
  <div class="w-full md:w-1/12 px-3 mb-6 md:mb-0 md:mt-6">
    <label class="form-label" >
      {{ __('Webfleet') }}
    </label>
    {!! Form::text('webfleet_id', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0 md:mt-6">
    <label class="form-label" >
      {{ __('QR ID') }}
    </label>
    {!! Form::text('qrid', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0 md:mt-6">
    <label class="form-label" >
      {{ __('Ubicación') }}
    </label>
    
    {!! Form::select('location', [
      '' => null,
      'EXIM' => 'EXIM',
      'CAMPA' => 'CAMPA',
      'NAVE NUEVA' => 'NAVE NUEVA',
      'URBAN TRUCKS' => 'URBAN TRUCKS',
      'WASTERENT' => 'WASTERENT',
      'TALLER EXTERNO' => 'TALLER EXTERNO',
      'CLIENTE' => 'CLIENTE',
    ], null, ['class' => 'form-select']) !!}
  </div>
  <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0 md:mt-6">
    <label class="form-label" >
      {{ __('Propietario') }}
    </label>
    
    {!! Form::select('owner', [
      '' => null,
      'Exim' => 'Exim',
      'Wasterent' => 'Wasterent',
      'Sivu' => 'Sivu',
      'Otro' => 'Otro'
    ], null, ['class' => 'form-select']) !!}
  </div>
  <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0 md:mt-6">
    <label class="form-label" >
      {{ __('Mecánico asignado') }}
    </label>
    
    {!! Form::select('mechanic_user_id', auth()->user()->fleet->users()->where('job', 'mechanic')->pluck('name', 'id'), null, ['placeholder' => '', 'class' => 'form-select']) !!}
  </div>
  <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0 md:mt-6">
    <div class="flex"> 
      <label class="form-label" >
        {{ __('Vehículo de servicio') }}
      </label>
      <div class="tooltip">
        <i class="fas fa-info-circle fa-xs"></i>
        <span class="tooltiptext">
          Vehículos de uso interno
        </span>
      </div>
    </div>
    
    {!! Form::select('is_service_vehicle', ['0' => 'No', 1 => 'Si'], null, ['placeholder' => '', 'class' => 'form-select']) !!}
  </div>

  
</div>

<fieldset>
  <legend>{{ __('Fechas') }}</legend>  
  <div class="flex flex-wrap -mx-3 mb-6">
    <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
      <label class="form-label" >
        {{ __('Fecha de fabricación') }}
      </label>
      {!! Form::text('manufacturing_date', null, ['class' => 'form-input datepicker']) !!}
    </div>
    <div class="w-full md:w-1/5 px-3 mb-6">
      <label class="form-label" >
        {{ __('Fecha de fin de garantía') }}
      </label>
      {!! Form::text('warranty_date', null, ['class' => 'form-input datepicker']) !!}
    </div>
    <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
      <label class="form-label" >
        {{ __('Fecha 1º matriculación') }}
      </label>
      {!! Form::text('registration_date', null, ['class' => 'form-input datepicker']) !!}
    </div>
    <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
      <label class="form-label" >
        {{ __('Fecha última itv') }}
      </label>
      {!! Form::text('last_itv_date', null, ['class' => 'form-input datepicker']) !!}
    </div>
    <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
      <label class="form-label" >
        {{ __('Fecha próxima itv') }}
      </label>
      {!! Form::text('itv_date', null, ['class' => 'form-input datepicker']) !!}
    </div>
    <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
      <label class="form-label" >
        {{ __('Fecha compra') }}
      </label>
      {!! Form::text('purchase_date', null, ['class' => 'form-input datepicker']) !!}
    </div>
    <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
      <label class="form-label" >
        {{ __('Fecha baja') }}
      </label>
      {!! Form::text('discharged_date', null, ['class' => 'form-input datepicker']) !!}
    </div>   
    <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
      <label class="form-label" >
        {{ __('Inicio de alquiler') }}
      </label>
      {!! Form::text('renting_start_date', null, ['class' => 'form-input datepicker']) !!}
    </div> 
    <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
      <label class="form-label" >
        {{ __('Fin de alquiler') }}
      </label>
      {!! Form::text('renting_end_date', null, ['class' => 'form-input datepicker']) !!}
    </div> 
    <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
      <label class="form-label" >
        {{ __('Revisión tacógrafo') }}
      </label>
      {!! Form::text('tachograph_date', null, ['class' => 'form-input datepicker']) !!}
    </div>    
  </div>
</fieldset>

<br>

<fieldset>
  <legend>{{ __('Dimensiones') }}</legend>
  <div class="flex flex-wrap -mx-3 mb-6">
    <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
      <label class="form-label" >
        {{ __('Nº ejes') }}
      </label>
      {!! Form::number('number_of_axes', null, ['class' => 'form-input', 'step' => '1']) !!}
    </div>
    <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
      <label class="form-label" >
        {{ __('Distancia ejes 1-2 (mm)') }}
      </label>
      {!! Form::number('axe_1_2_distance', null, ['class' => 'form-input', 'step' => '0.01']) !!}
    </div>
    <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
      <label class="form-label" >
        {{ __('Distancia ejes 2-3 (mm)') }}
      </label>
      {!! Form::number('axe_2_3_distance', null, ['class' => 'form-input', 'step' => '0.01']) !!}
    </div>
    <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
      <label class="form-label" >
        {{ __('Ancho (mm)') }}
      </label>
      {!! Form::number('width', null, ['class' => 'form-input', 'step' => '0.01']) !!}
    </div>
    <div class="w-full md:w-2/12 px-3 mb-6">
      <label class="form-label" >
        {{ __('Alto (mm)') }}
      </label>
      {!! Form::number('height', null, ['class' => 'form-input', 'step' => '0.01']) !!}
    </div>
    <div class="w-full md:w-2/12 px-3">
      <label class="form-label" >
        {{ __('Longitud (mm)') }}
      </label>
      {!! Form::number('length', null, ['class' => 'form-input', 'step' => '0.01']) !!}
    </div>
    <div class="w-full md:w-2/12 px-3">
      <label class="form-label" >
        {{ __('Tara (kg)') }}
      </label>
      {!! Form::number('tare_kg', null, ['class' => 'form-input', 'step' => '1']) !!}
    </div>
    <div class="w-full md:w-2/12 px-3">
      <label class="form-label" >
        MMA (kg)
      </label>
      {!! Form::number('mma_kg', null, ['class' => 'form-input', 'step' => '1']) !!}
    </div>
  </div>
</fieldset>

<br>

<fieldset>
  <legend>{{ __('Toma de Fuerza') }}</legend>
  <div class="flex flex-wrap -mx-3 mb-6">
    <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
      <label class="form-label" >
         {{ __('Tipo') }}
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
        {{ __('Marca') }}
      </label>
      {!! Form::text('powertakeoff_maker', null, ['class' => 'form-input']) !!}
    </div>
    <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
      <label class="form-label" >
        {{ __('Modelo') }}
      </label>
      {!! Form::text('powertakeoff_model', null, ['class' => 'form-input']) !!}
    </div>
    <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
      <label class="form-label" >
        {{ __('Número de serie') }}
      </label>
      {!! Form::text('powertakeoff_serial_number', null, ['class' => 'form-input']) !!}
    </div>
  </div>
</fieldset>

<br>

<fieldset>
  <legend>{{ __('Caja de cambios') }}</legend>
  <div class="flex flex-wrap -mx-3 mb-6">
    <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
      <label class="form-label">
        {{ __('Tipo') }}
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
        {{ __('Marca') }}
      </label>
      {!! Form::text('gearbox_maker', null, ['class' => 'form-input']) !!}
    </div>
    <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
      <label class="form-label" >
        {{ __('Modelo') }}
      </label>
      {!! Form::text('gearbox_model', null, ['class' => 'form-input']) !!}
    </div>
    <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
      <label class="form-label" >
        {{ __('Número de serie') }}
      </label>
      {!! Form::text('gearbox_serial_number', null, ['class' => 'form-input']) !!}
    </div>
  </div>
</fieldset>

<br>