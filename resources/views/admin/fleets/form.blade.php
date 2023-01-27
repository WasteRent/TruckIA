<div class="container">
  <div class="row">
    <div class="flex flex-wrap -mx-3 mb-6">
      <div class="w-full md:w-3/4 px-3 mb-6 md:mb-0">
        <label class="form-label">
          {{ __('Nombre') }}
        </label>
        {!! Form::text('name', null, ['class' => 'form-input']) !!}
      </div>
      <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
        <label class="form-label">
          {{ __('Límite de vehículos') }}
        </label>
        {!! Form::number('vehicles_limit', null, ['class' => 'form-input']) !!}
      </div>
    </div>

    <div class="flex flex-wrap -mx-3 mb-6">
      <div class="w-full px-3 mb-6 md:mb-0">
        <label class="form-label">
          {{ __('Logo') }}
        </label>
        {!! Form::text('logo', null, ['class' => 'form-input']) !!}
      </div>
    </div>

    <div class="flex flex-wrap -mx-3 mb-6">
      <div class="w-full px-3 mb-6 md:mb-0">
        <label class="form-label">
          {{ __('Email notificaciones') }}
        </label>
        {!! Form::email('notifications_email', null, ['class' => 'form-input']) !!}
      </div>
    </div>


    <div class="flex flex-wrap -mx-3 mb-6">
      <div class="w-full px-3 mb-6 md:mb-0">
        <label class="form-label">
          {{ __('Horario grua') }}
        </label>
        {!! Form::text('crane_opening_hours', null, ['class' => 'form-input']) !!}
      </div>
    </div>
  </div>

  @if(Auth::user()->role === 'admin')
  <fieldset>
    <legend>Módulos Tiempo y Ratio</legend>
    <div class="flex flex-wrap -mx-3 mb-6">
      <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
        <label class="form-label">
          Módulo Horas Can Chasis
        </label>
        {!! Form::select('module_can_hours', ['0' => 'Desactivado', '1' => 'Activado'], null, ['class' => 'form-select']) !!}
      </div>
    

      <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
        <label class="form-label">
          Módulo Horas TDF Equipo
        </label>
        {!! Form::select('module_tdf_hours', ['0' => 'Desactivado', '1' => 'Activado'], null, ['class' => 'form-select']) !!}
      </div>
      <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
        <label class="form-label">
          Módulo Horas GPS Chasis
        </label>
        {!! Form::select('module_gps_chassis_hours', ['0' => 'Desactivado', '1' => 'Activado'], null, ['class' => 'form-select']) !!}
      </div>
      <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
        <label class="form-label">
          Módulo KM
        </label>
        {!! Form::select('module_km', ['0' => 'Desactivado', '1' => 'Activado'], null, ['class' => 'form-select']) !!}
      </div>
      <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
        <label class="form-label">
          Módulo Horas Trabajo Grua
        </label>
        {!! Form::select('module_crane_work_hours', ['0' => 'Desactivado', '1' => 'Activado'], null, ['class' => 'form-select']) !!}
      </div>
      <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
        <label class="form-label">
          Módulo R.C. GPS/CAN
        </label>
        {!! Form::select('module_rc_gps_can', ['0' => 'Desactivado', '1' => 'Activado'], null, ['class' => 'form-select']) !!}
      </div>
      <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
        <label class="form-label">
          Módulo R.C. CHASIS/CAJA
        </label>
        {!! Form::select('module_rc_chassis_box', ['0' => 'Desactivado', '1' => 'Activado'], null, ['class' => 'form-select']) !!}
      </div>
      <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
        <label class="form-label">
          Módulo R.C. GRUA
        </label>
        {!! Form::select('module_rc_crane', ['0' => 'Desactivado', '1' => 'Activado'], null, ['class' => 'form-select']) !!}
      </div>
      <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
        <label class="form-label">
          Módulo Fuente
        </label>
        {!! Form::select('module_source', ['0' => 'Desactivado', '1' => 'Activado'], null, ['class' => 'form-select']) !!}
      </div>
    </div>
  </fieldset>

  <fieldset>

    <legend>Módulos Funciones Avanzadas</legend>

    <div class="flex flex-wrap -mx-3 mb-6">
      <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
        <label class="form-label">
          Módulo O.R. Detallado
        </label>
        {!! Form::select('module_OR', ['0' => 'Desactivado', '1' => 'Activado'], null, ['class' => 'form-select']) !!}
      </div>
      
      <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
        <label class="form-label">
          Módulo ITV
        </label>
        {!! Form::select('module_ITV', ['0' => 'Desactivado', '1' => 'Activado'], null, ['class' => 'form-select']) !!}
      </div>
      
      <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
        <label class="form-label">
          Módulo Clientes
        </label>
        {!! Form::select('module_customers', ['0' => 'Desactivado', '1' => 'Activado'], null, ['class' => 'form-select']) !!}
      </div>
    </div>

  </fieldset>
  @endif
</div>