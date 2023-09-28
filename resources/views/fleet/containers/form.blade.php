<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
    <label class="form-label form-required">
      {{ __('ID') }}
    </label>
    {!! Form::text('reference', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-3/12 px-3 mb-6 md:mb-0">
    <label class="form-label">
      {{ __('Marca') }}
    </label>
    {!! Form::text('maker', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-3/12 px-3 mb-6 md:mb-0">
    <label class="form-label">
      {{ __('Modelo') }}
    </label>
    {!! Form::text('model', null, ['class' => 'form-input']) !!}
  </div>
  <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0">
    <div class="flex">
      <label class="form-label">
        {{ __('Estado') }}
      </label>
    </div>
    {!! Form::select('state_id', $states->pluck('name', 'id')->prepend('','')->mapWithKeys(function($value, $key) {
      return [$key => __($value)];
    }), null, ['class' => 'form-select']) !!}
  </div>
</div>

<div class="flex flex-wrap -mx-3 mb-6">
  <div class="w-full md:w-6/12 px-3 mb-6">
    <label class="form-label">
      {{ __('Cliente') }}
    </label>
    {!! Form::select('customer_id', $customers->pluck('name', 'id'), null, ['class' => 'form-select', 'placeholder' => '']) !!}
  </div>

</div>

@if(in_array(auth()->user()->fleet->id, [1, 6]))
  <div class="flex flex-wrap -mx-3 mb-6">

    <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0 md:mt-6">
      <label class="form-label" >
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
    <div class="w-full md:w-2/12 px-3 mb-6 md:mb-0 md:mt-6">
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

  </div>
@endif
