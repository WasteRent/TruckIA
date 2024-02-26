{!! 
	Form::model(request()->all(), [
		'method' => 'GET',
		'class' => ['md:flex items-center']
	])
!!}
    <div class="lg:px-3 lg:mb-0 mb-3">
      <label class="form-label">{{ __('Vehículo') }}</label>
    	{!! Form::text('vehicle_reference', null, ['placeholder' => '', 'class' => 'form-input']) !!}
    </div>
    <div class="lg:px-3 lg:mb-0 mb-3">
      <label class="form-label">{{__('Descripción')}}</label>
      {!! Form::text('description', null, ['placeholder' => '', 'class' => 'form-input']) !!}
    </div>
    <div class="lg:px-3 lg:mb-0 mb-3">
      <label class="form-label">Fecha</label>
        {!! Form::date('date', null, ['class' => 'form-select', 'placeholder' => '']) !!}
    </div>
    <div class="text-right">
        <button class="btn-search">
          <i class="fas fa-search"></i>
        </button>
    </div>
{!! Form::close() !!}
