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
      <label class="form-label">{{ __('Centro') }}</label>
      {!! Form::select('customer_id', $allowed_customers->pluck('name', 'id')->prepend('', ''), null, ['class' => 'form-select']) !!}
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
    <div class="text-right">
        <button class="btn-search">
          <i class="fas fa-search"></i>
        </button>
    </div>
{!! Form::close() !!}
