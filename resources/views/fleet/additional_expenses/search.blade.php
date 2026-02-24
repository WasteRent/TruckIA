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
      <label class="form-label">{{ __('Ubicación') }}</label>
      {!! Form::select('location_id', $allowed_customers->pluck('name', 'id')->prepend('', ''), null, ['class' => 'form-select']) !!}
    </div>
    <div class="lg:px-3 lg:mb-0 mb-3">
      <label class="form-label">
        {{ __('Fecha desde') }}
      </label>
      {!! Form::text('date_from', null, ['class' => 'datepicker form-input']) !!}
    </div>
    <div class="lg:px-3 lg:mb-0 mb-3">
      <label class="form-label">
        {{ __('Fecha hasta') }}
      </label>
      {!! Form::text('date_to', null, ['class' => 'datepicker form-input']) !!}
    </div>
    <div class="lg:px-3 lg:mb-0 mb-3 w-1/12">
      <label class="form-label">
        {{ __('Gasto taller') }}
      </label>
      {!! Form::select('is_workshop', [1 => 'Si', 0 => 'No'], null, ['placeholder' => '', 'class' => 'form-select']) !!}
    </div>
    <div class="text-right">
        <button class="btn-search">
          <i class="fas fa-search"></i>
        </button>
    </div>
{!! Form::close() !!}
