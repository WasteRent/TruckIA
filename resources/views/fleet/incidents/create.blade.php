@extends('layouts.fleet')

@section('title', __('Incidencias'))

@section('content')

  @component('components.card')
    @slot('title', __('Nueva incidencia'))


    {!! Form::open([
        'route' => ['fleet.incidents.store'],
        'method' => 'POST',
        'class' => 'w-full'
      ]) !!}

      <div class="flex flex-wrap -mx-3 mb-6">
        <div class="w-full px-3 mb-6">
          <label class="form-label form-required">
            {{ __('Incidencia') }}
          </label>
          <textarea name="incidence" rows="5" class="form-input"></textarea>
        </div>
        <div class="sm:w-1/3 px-3 mb-6 md:mb-0">
          <label class="form-label form-required">
            {{ __('Identificador') }}
          </label>
          {!! Form::select('plate', \App\Models\Vehicle::allowForUser()->orderBy('plate')->get()->mapWithKeys(function($vehicle) {
            return [$vehicle->plate => "{$vehicle->internal_id} - {$vehicle->plate}"];
          }), null, ['class' => 'form-input js-select-search', 'placeholder' => '']) !!}
        </div>
        <div class="sm:w-1/5 px-3 mb-6 md:mb-0">
          <label class="form-label form-required">
            {{ __('Fecha') }}
          </label>
          {!! Form::datetime('created_at', now()->format('Y-m-d H:i:s'), ['class' => 'form-input datetimepicker']) !!}
        </div>
      </div>

      <div class="flex justify-end">
        <button class="btn-indigo">{{ __('Guardar') }}</button>
      </div>

      {!! Form::close() !!}
  @endcomponent

@endsection

