{!! 
	Form::model(request()->all(), [
		'method' => 'GET',
		'class' => ['sm:flex flex-wrap']
	])
!!}
    <div class="lg:px-3 sm:w-2/12 lg:mb-0 mb-3 mt-2">
      	<label class="form-label">{{ __('ID') }}</label>
    	{!! Form::text('reference', null, ['class' => 'form-input']) !!}
    </div>
    <div class="lg:px-3 sm:w-2/12 lg:mb-0 mb-3 mt-2">
      <label class="form-label">
        {{ __('Estado') }}
      </label>
        {!! Form::select('state_id', $states->pluck('name', 'id')->prepend('', ''), null, ['class' => 'form-select']) !!}
    </div>
    <div class="lg:px-3 sm:w-2/12 lg:mb-0 mb-3 mt-2">
      <label class="form-label">
        {{ __('Marca') }}
      </label>
      {!! Form::text('maker', null, ['class' => 'form-input']) !!}
    </div>
    <div class="lg:px-3 sm:w-2/12 lg:mb-0 mb-3 mt-2">
      <label class="form-label">
        {{ __('Modelo') }}
      </label>
      {!! Form::text('model', null, ['class' => 'form-input']) !!}
    </div>
    <div class="lg:px-3 sm:w-2/12 lg:mb-0 mb-3 mt-2">
      <label class="form-label">
        {{ __('Cliente') }}
      </label>
        {!! Form::select('assigned_customer_id', $customers->pluck('name', 'id')->prepend('Sin Cliente Asignado','-1')->prepend('', ''), null, ['class' => 'form-select']) !!}
    </div>
    @if(in_array(auth()->user()->fleet->id, [1, 6]))
    <div class="lg:px-3 sm:w-2/12 lg:mb-0 mb-3 mt-2">
      <label class="form-label">
        {{ __('Ubicación') }}
      </label>
        {!! Form::select('location', [
          '' => null,
          'EXIM' => 'EXIM',
          'CAMPA' => 'CAMPA',
          'NAVE NUEVA' => 'NAVE NUEVA',
          'URBAN TRUCKS' => 'URBAN TRUCKS',
          'WASTERENT' => 'WASTERENT',
          'TALLER EXTERNO' => 'TALLER EXTERNO',
          'CLIENTE' => 'CLIENTE',
        ], null, ['class' => 'form-select']) !!}
    </div>
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
    @endif
    <div class="text-right">
        <button class="btn-search">
          <i class="fas fa-search"></i>
        </button>
    </div>
{!! Form::close() !!}
