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
          <x-trix name="incidence" />
        </div>
        <div class="sm:w-1/5 px-3 mb-6 md:mb-0">
          <label class="form-label form-required">
            {{ __('Matrícula') }}
          </label>
          {!! Form::select('plate', auth()->user()->fleet->vehicles()->orderBy('plate')->pluck('plate', 'plate'), null, ['class' => 'form-input js-select-search']) !!}
        </div>
        <div class="sm:w-1/5 px-3 mb-6 md:mb-0">
          <label class="form-label form-required">
            {{ __('Fecha') }}
          </label>
          {!! Form::date('created_at', now()->format('Y-m-d'), ['class' => 'form-input datepicker']) !!}
        </div>
      </div>

      <div class="flex justify-end">
        <button class="btn-indigo">{{ __('Guardar') }}</button>
      </div>

      {!! Form::close() !!}
  @endcomponent

@endsection

