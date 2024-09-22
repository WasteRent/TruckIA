{!! 
	Form::model(request()->all(), [
		'route' => $route, 
		'method' => 'GET',
		'class' => ['sm:flex flex-wrap']
	])
!!}
    @if(request()->show == 'discharged')
    <input type="hidden" name="show" value="discharged"> 
    @endif

    <div class="lg:px-3 sm:w-2/12 lg:mb-0 mb-3 mt-2">
      	<label class="form-label">{{ __('Matrícula') }}</label>
    	{!! Form::text('plate', null, ['placeholder' => 'Ej: 9820JVP', 'class' => 'form-input']) !!}
    </div>
    <div class="lg:px-3 sm:w-1/12 lg:mb-0 mb-3 mt-2">
        <label class="form-label">{{ __('ID') }}</label>
      {!! Form::text('internal_id', null, ['class' => 'form-input']) !!}
    </div>
    <div class="lg:px-3 sm:w-2/12 lg:mb-0 mb-3 mt-2">
      <label class="form-label">
        {{ __('Estado') }}
      </label>
        {!! Form::select('state_id', $states->pluck('name', 'id')->prepend('', ''), null, ['class' => 'form-select']) !!}
    </div>
    <div class="lg:px-3 sm:w-2/12 lg:mb-0 mb-3 mt-2">
      <label class="form-label">
        {{ __('Marca chasis') }}
      </label>
        {!! Form::select('chassis_maker_id', $chassis_manufacturers->pluck('name', 'id')->prepend('', ''), null, ['class' => 'form-select', 'onchange' => "ajaxSelect('chassis_maker_id', 'chassis_model_id', '/api/manufacturer/{id}/models')"]) !!}
    </div>
    <div class="lg:px-3 sm:w-2/12 lg:mb-0 mb-3 mt-2">
      <label class="form-label">
        {{ __('Modelo chasis') }}
      </label>
        {!! Form::select('chassis_model_id', $chassis_models->pluck('name', 'id')->prepend('', ''), null, ['class' => 'form-select']) !!}
    </div>
    <div class="lg:px-3 sm:w-2/12 lg:mb-0 mb-3 mt-2">
      <label class="form-label">
        {{ __('Marca equipo') }}
      </label>
        {!! Form::select('equipment_maker_id', $equipment_manufacturers->pluck('name', 'id')->prepend('', ''), null, ['class' => 'form-select', 'onchange' => "ajaxSelect('equipment_maker_id', 'equipment_model_id', '/api/manufacturer/{id}/models')"]) !!}
    </div>
    <div class="lg:px-3 sm:w-2/12 lg:mb-0 mb-3 mt-2">
      <label class="form-label">
        {{ __('Modelo equipo') }}
      </label>
        {!! Form::select('equipment_model_id', $equipment_models->pluck('name', 'id')->prepend('', ''), null, ['class' => 'form-select']) !!}
    </div>
    <div class="lg:px-3 sm:w-2/12 lg:mb-0 mb-3 mt-2">
        <label class="form-label">
          {{ __('Bastidor') }}
        </label>
      {!! Form::text('vin', null, ['class' => 'form-input']) !!}
    </div>
    <div class="lg:px-3 sm:w-2/12 lg:mb-0 mb-3 mt-2">
      <label class="form-label">
        Tacógrafo Exento
      </label>
        {!! Form::select('tachograph_exempt', ['' => '', '1' => 'Si', '0' => 'No'], null, ['class' => 'form-select']) !!}
    </div>
    <div class="lg:px-3 sm:w-2/12 lg:mb-0 mb-3 mt-2">
      <label class="form-label">
        {{ __('Cliente') }}
      </label>
        {!! Form::select('assigned_customer_id', $customers->pluck('name', 'id')->prepend('Sin Cliente Asignado','-1')->prepend('', ''), null, ['class' => 'form-select']) !!}
    </div>
    <div class="lg:px-3 sm:w-2/12 lg:mb-0 mb-3 mt-2">
      <label class="form-label">
        {{ __('Tipo de vehículo') }}
      </label>
        {!! Form::select('vehicle_type_id', \App\Models\VehicleType::orderBy('name')->pluck('name', 'id')->prepend('', ''), null, ['class' => 'form-select']) !!}
    </div>

    <div class="lg:px-3 sm:w-2/12 lg:mb-0 mb-3 mt-2">
      <label class="form-label">
        {{ __('Ubicación') }}
      </label>
        {!! Form::select('location_id', App\Models\Customer::where('fleet_id', auth()->user()->fleet->id)->orderBy('name')->pluck('name', 'id'), null, ['class' => 'form-select', 'placeholder' => '']) !!}
    </div>
    @if(in_array(auth()->user()->fleet->id, [1, 6]))
    <div class="lg:px-3 sm:w-2/12 lg:mb-0 mb-3 mt-2">
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
    <div class="lg:px-3 sm:w-2/12 lg:mb-0 mb-3 mt-2">
      <label class="form-label" >
        {{ __('Mecanico asignado') }}
      </label>
      {!! Form::select('mechanic_user_id', auth()->user()->fleet->users()->where('job', 'mechanic')->pluck('name', 'id')->prepend('Sin Mecánico Asignado','-1')->prepend('',''), null, ['class' => 'form-select']) !!}
    </div>
    @endif
    <div class="flex justify-end w-full">
        <button class="btn-search">
          <i class="fas fa-search"></i>
        </button>
    </div>
{!! Form::close() !!}
