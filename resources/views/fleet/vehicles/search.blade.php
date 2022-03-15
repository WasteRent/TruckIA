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
      	<label class="form-label">Matrícula</label>
    	{!! Form::text('plate', null, ['placeholder' => 'Ej: 9820JVP', 'class' => 'form-input']) !!}
    </div>
    <div class="lg:px-3 sm:w-2/12 lg:mb-0 mb-3 mt-2">
      <label class="form-label">
        Estado
      </label>
        {!! Form::select('state_id', $states->pluck('name', 'id')->prepend('', ''), null, ['class' => 'form-select']) !!}
    </div>
    <div class="lg:px-3 sm:w-2/12 lg:mb-0 mb-3 mt-2">
      <label class="form-label">
        Marca Chasis
      </label>
        {!! Form::select('chassis_maker_id', $chassis_manufacturers->pluck('name', 'id')->prepend('', ''), null, ['class' => 'form-select', 'onchange' => "ajaxSelect('chassis_maker_id', 'chassis_model_id', '/api/manufacturer/{id}/models')"]) !!}
    </div>
    <div class="lg:px-3 sm:w-2/12 lg:mb-0 mb-3 mt-2">
      <label class="form-label">
        Modelo Chasis
      </label>
        {!! Form::select('chassis_model_id', $chassis_models->pluck('name', 'id')->prepend('', ''), null, ['class' => 'form-select']) !!}
    </div>
    <div class="lg:px-3 sm:w-2/12 lg:mb-0 mb-3 mt-2">
      <label class="form-label">
        Marca Equipo
      </label>
        {!! Form::select('equipment_maker_id', $equipment_manufacturers->pluck('name', 'id')->prepend('', ''), null, ['class' => 'form-select', 'onchange' => "ajaxSelect('equipment_maker_id', 'equipment_model_id', '/api/manufacturer/{id}/models')"]) !!}
    </div>
    <div class="lg:px-3 sm:w-2/12 lg:mb-0 mb-3 mt-2">
      <label class="form-label">
        Modelo Equipo
      </label>
        {!! Form::select('equipment_model_id', $equipment_models->pluck('name', 'id')->prepend('', ''), null, ['class' => 'form-select']) !!}
    </div>
    <div class="lg:px-3 sm:w-2/12 lg:mb-0 mb-3 mt-2">
        <label class="form-label">
          Bastidor
        </label>
      {!! Form::text('vin', null, ['class' => 'form-input']) !!}
    </div>
    <div class="lg:px-3 sm:w-2/12 lg:mb-0 mb-3 mt-2">
      <label class="form-label">
        Contiene Datos ITV
      </label>
        {!! Form::select('with_itv_date', ['' => '', '1' => 'Si', '0' => 'No'], null, ['class' => 'form-select']) !!}
    </div>
    <div class="lg:px-3 sm:w-2/12 lg:mb-0 mb-3 mt-2">
      <label class="form-label">
        Tacógrafo Exento
      </label>
        {!! Form::select('tachograph_exempt', ['' => '', '1' => 'Si', '0' => 'No'], null, ['class' => 'form-select']) !!}
    </div>
    <div class="lg:px-3 sm:w-2/12 lg:mb-0 mb-3 mt-2">
      <label class="form-label">
        Cliente
      </label>
        {!! Form::select('assigned_customer_id', $customers->pluck('name', 'id')->prepend('Sin Cliente Asignado','-1')->prepend('', ''), null, ['class' => 'form-select']) !!}
    </div>
    <div class="text-right">
        <button class="lg:mt-6 bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
          <i class="fas fa-search"></i>
        </button>
    </div>
{!! Form::close() !!}
