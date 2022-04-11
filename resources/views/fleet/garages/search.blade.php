{!! 
	Form::model(request()->all(), [
		'route' => $route, 
		'method' => 'GET',
		'class' => ['md:flex items-center']
	])
!!}
    <div class="lg:px-3 lg:mb-0 mb-3">
      	<label class="form-label">{{ __('Nombre') }}</label>
    	{!! Form::text('name', null, ['placeholder' => 'Ej: Urban Trucks', 'class' => 'form-input']) !!}
    </div>
    <div class="lg:px-3 lg:mb-0 mb-3">
        <label class="form-label">{{ __('Localidad') }}</label>
      {!! Form::text('state', null, ['class' => 'form-input']) !!}
    </div>
    <div class="lg:px-3 lg:mb-0 mb-3">
        <label class="form-label">{{ __('Provincia') }}</label>
      {!! Form::text('province', null, ['class' => 'form-input']) !!}
    </div>
    <div class="lg:px-3 lg:mb-0 mb-3">
      <label class="form-label">
        {{ __('Servicio oficial') }}
      </label>
        {!! Form::select('official_service_id', $manufacturers->pluck('name', 'id')->prepend('', ''), null, ['class' => 'form-select']) !!}
    </div>
    <div class="text-right">
        <button class="lg:mt-6 bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
          <i class="fas fa-search"></i>
        </button>
    </div>
{!! Form::close() !!}
