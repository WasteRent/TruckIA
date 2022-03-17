{!! 
	Form::model(count(request()->all()) > 0 ? request()->all() : session('filters'), [
		'route' => $route, 
		'method' => 'GET',
		'class' => ['sm:flex flex-wrap']
	])
!!}
    <div class="lg:px-3 sm:w-2/12 lg:mb-0 mb-3">
      	<label class="form-label">{{ __('Matrícula') }}</label>
    	{!! Form::text('plate', null, ['placeholder' => 'Ej: 9820JVP', 'class' => 'form-input']) !!}
    </div>
    <div class="lg:px-3 sm:w-2/12 lg:mb-0 mb-3">
      <label class="form-label">
        {{ __('Marca Chasis') }}
      </label>
        {!! Form::select('chassis_maker_id', $chassis_manufacturers->pluck('name', 'id')->prepend('', ''), null, ['class' => 'form-select', 'onchange' => "ajaxSelect('chassis_maker_id', 'chassis_model_id', '/api/manufacturer/{id}/models')"]) !!}
    </div>
    <div class="lg:px-3 sm:w-2/12 lg:mb-0 mb-3">
      <label class="form-label">
        {{ __('Modelo Chasis') }}
      </label>
        {!! Form::select('chassis_model_id', $chassis_models->pluck('name', 'id')->prepend('', ''), null, ['class' => 'form-select']) !!}
    </div>
    <div class="lg:px-3 sm:w-2/12 lg:mb-0 mb-3">
      <label class="form-label">
        {{ __('Marca Equipo') }}
      </label>
        {!! Form::select('equipment_maker_id', $equipment_manufacturers->pluck('name', 'id')->prepend('', ''), null, ['class' => 'form-select', 'onchange' => "ajaxSelect('equipment_maker_id', 'equipment_model_id', '/api/manufacturer/{id}/models')"]) !!}
    </div>
    <div class="lg:px-3 sm:w-2/12 lg:mb-0 mb-3">
      <label class="form-label">
        {{ __('Modelo Equipo') }}
      </label>
        {!! Form::select('equipment_model_id', $equipment_models->pluck('name', 'id')->prepend('', ''), null, ['class' => 'form-select']) !!}
    </div>
    <div class="lg:px-3 sm:w-2/12 lg:mb-0 mb-3">
      <label class="form-label">
        {{ __('Estado') }}
      </label>
        {!! Form::select('state_id', $states->pluck('name', 'id')->prepend('', ''), null, ['class' => 'form-select']) !!}
    </div>
    <div class="lg:px-3 sm:w-3/12 lg:mb-0 mb-3">
      <label class="form-label">
        {{ __('Cliente') }}
      </label>
        {!! Form::select('assigned_customer_id', $customers->pluck('name', 'id')->prepend('', ''), null, ['class' => 'form-select']) !!}
    </div>
    <div class="text-right">
        <button class="lg:mt-6 bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
          <i class="fas fa-search"></i>
        </button>
    </div>
{!! Form::close() !!}
