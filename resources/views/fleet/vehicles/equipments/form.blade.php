<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-1/6 px-3 mb-6 md:mb-1">
    <label class="form-label">
      {{ __('Tipo') }}
    </label>
    {!! Form::select('type', [
      '' => '',
      'Barredora' => 'Barredora',
      'Caja abierta' => 'Caja abierta',
      'Caja abierta con volquete' => 'Caja abierta con volquete',
      'Carga lateral' => 'Carga lateral',
      'Carga trasera' => 'Carga trasera',
      'Compactador' => 'Compactador',
      'Equipo barredora camión' => 'Equipo barredora camión',
      'Equipo cisterna' => 'Equipo cisterna',
      'Equipo cisterna baldeo' => 'Equipo cisterna baldeo',
      'Gancho' => 'Gancho',
      'Grúa' => 'Grúa',
      'Lavacontenedores' => 'Lavacontenedores',
      'Lavacontenedores trasera' => 'Lavacontenedores trasera',
      'Multibasculante' => 'Multibasculante',
      'Portacontenedores' => 'Portacontenedores',
      'Recolector' => 'Recolector',
      'Satélite' => 'Satélite',
      'Elevador' => 'Elevador',
      'Volquete' => 'Volquete',
      'Tolva' => 'Tolva',
    ], null, ['class' => 'form-select']) !!}
  </div>
  <div class="w-full md:w-1/6 px-3 mb-6 md:mb-1">
    <label class="form-label form-required">
      {{ __('Marca equipo') }}
    </label>
      {!! Form::select('maker_id', $manufacturers->pluck('name', 'id')->prepend('',''), null, ['class' => 'form-select', 'onchange' => "ajaxSelect('maker_id', 'model_id', '/api/manufacturer/{id}/models')"]) !!}
  </div>
  <div class="w-full md:w-1/6 px-3 mb-6 md:mb-1">
    <label class="form-label form-required">
      {{ __('Modelo equipo') }}
    </label>
      {!! Form::select('model_id', $models->pluck('name', 'id')->prepend('',''), null, ['class' => 'form-select']) !!}
  </div>
  <div class="w-full md:w-1/6 px-3 mb-6 md:mb-1">
    <label class="form-label" >
      {{ __('Versión') }}
    </label>
    {!! Form::text('version', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-1/6 px-3 mb-6 md:mb-1">
    <label class="form-label" >
      {{ __('Número de equipo') }}
    </label>
    {!! Form::text('plate', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-1/6 px-3 mb-6 md:mb-1">
    <label class="form-label" >
      {{ __('Garantía') }}
    </label>
    {!! Form::text('warranty_date', null, ['class' => 'form-input datepicker']) !!}
  </div>
  <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
    <label class="form-label" >
      {{ __('Fecha fabricación equipo') }}
    </label>
    {!! Form::text('manufacturing_date', null, ['class' => 'form-input datepicker']) !!}
  </div>
</div>

<div class="sm:flex">
  <div class="sm:w-2/3">
    <fieldset class="mb-6">
      <legend>{{ __('Bomba') }}</legend>
      <div class="flex flex-wrap -mx-3 mb-6">
        <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
          <label class="form-label" >
            {{ __('Número de serie') }}
          </label>
          {!! Form::text('bomb_serial_number', null, ['class' => 'form-input']) !!}
        </div>
        <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
          <label class="form-label" >
            {{ __('Marca') }}
          </label>
          {!! Form::text('bomb_maker', null, ['class' => 'form-input']) !!}
        </div>
        <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
          <label class="form-label" >
            {{ __('Modelo') }}
          </label>
          {!! Form::text('bomb_model', null, ['class' => 'form-input']) !!}
        </div>
      </div>
    </fieldset>
  </div>
  <div class="sm:w-1/3">
    <div class="flex flex-wrap -mx-3 mb-6 ml-4">
      <div class="w-full px-3 mb-6 md:mb-0">
        <label class="form-label">
          {{ __('Foto') }}
        </label>
        {!! Form::file('picture', ['class' => 'form-input']) !!}
      </div>
    </div>
  </div>
</div>
