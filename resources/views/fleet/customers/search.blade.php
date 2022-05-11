{!! 
	Form::model(request()->all(), [
		'route' => $route, 
		'method' => 'GET',
		'class' => ['md:flex items-center']
	])
!!}
    <div class="lg:px-3 lg:mb-0 mb-3">
      <label class="form-label">{{ __('Nombre') }}</label>
    	{!! Form::text('name', null, ['placeholder' => '', 'class' => 'form-input']) !!}
    </div>
    <div class="lg:px-3 lg:mb-0 mb-3">
      <label class="form-label">{{ __('Matrícula') }}</label>
      {!! Form::text('plate', null, ['placeholder' => '', 'class' => 'form-input']) !!}
    </div>
    <div class="lg:px-3 lg:mb-0 mb-3">
      <label class="form-label">
        {{ __('Grupo Empresarial') }}
      </label>
        {!! Form::select('enterprise_group_id', $enterprises->pluck('name', 'id')->prepend('', ''), null, ['class' => 'form-select']) !!}
    </div>
    <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
      <label class="form-label">
        {{ __('Con vehículos') }}
      </label>
      {!!  Form::checkbox('with_vehicles', 1)  !!}
    </div>
    <div class="text-right">
        <button class="btn-search">
          <i class="fas fa-search"></i>
        </button>
    </div>
{!! Form::close() !!}
