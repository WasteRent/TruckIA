@extends('layouts.fleet')

@section('title', __('Lavados'))

@section('content')

  @component('components.card')
    @slot('title', __('Nuevo lavado'))


    {!! Form::open([
      'route' => ['fleet.washing.store'],
      'method' => 'POST',
      'class' => 'w-full'
    ]) !!}
  
  <div class="flex flex-wrap -mx-3 mb-6">
    <div class="sm:w-1/3 px-3 mb-6 md:mb-0">
      <label class="form-label form-required">
        {{ __('Identificador') }}
      </label>
      {!! Form::select('vehicle_id', \App\Models\Vehicle::allowForUser()->orderBy('plate')->get()->mapWithKeys(function($vehicle) {
        return [$vehicle->id => "{$vehicle->internal_id} - {$vehicle->plate}"];
      }), null, ['class' => 'form-input js-select-search', 'placeholder' => '']) !!}
    </div>

    <div class="sm:w-1/5 px-3 mb-6 md:mb-0">
      <label class="form-label form-required">
        {{ __('Fecha Inicio') }}
      </label>
      {!! Form::datetimeLocal('start_date', now()->format('Y-m-d\TH:i'), ['class' => 'form-input datetimepicker']) !!}
    </div>

    <div class="sm:w-1/5 px-3 mb-6 md:mb-0">
      <label class="form-label form-required">
        {{ __('Fecha Fin') }}
      </label>
      {!! Form::datetimeLocal('end_date', now()->format('Y-m-d\TH:i'), ['class' => 'form-input datetimepicker']) !!}
    </div>
  </div>
  
  <div class="flex justify-end">
    <button class="btn-indigo">{{ __('Guardar') }}</button>
  </div>
  
  {!! Form::close() !!}


  @endcomponent

  @component('components.card')
    <div class="flex flex-col gap-3">
      @foreach ($vehicle_washing_types as $type)
          <div class="text-sm">
              <label>
                  {!! Form::checkbox("vehicle_washing_types[$type->id]", 0, false, ['disabled' => true]) !!}
                  {{ __($type->name) }}
              </label>
          </div>
      @endforeach
   </div>

  @endcomponent

@endsection