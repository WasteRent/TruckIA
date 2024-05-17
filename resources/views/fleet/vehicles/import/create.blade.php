@extends('layouts.fleet')

@section('title', 'Importador de vehículos ')

@section('content')

  @component('components.card')
    @slot('title', 'Importador de vehículos')

    {!! Form::open([
        'route' => ['fleet.import-vehicles.store'],
        'method' => 'POST',
        'class' => 'w-full',
			  'files' => true,
    ]) !!}

    <div class="flex flex-wrap -mx-3 mb-6">
      <div class="w-full md:w-5/12 px-3 mb-6 md:mb-0">
        Descargar plantilla
        <a class="mr-4 text-green-600" href="{{ route('fleet.export.vehicles', ['plate' => auth()->user()->fleet->vehicles->first()->plate]) }}"><i
            class="fas fa-lg fa-file-excel"></i></a>
      </div>
    </div>

    <div class="flex flex-wrap -mx-3 mb-6">
      <div class="w-full md:w-4/12 px-3 mb-6 md:mb-0">
        <label class="form-label">
          Adjunto
        </label>
        {!! Form::file('attachment', ['class' => 'form-input', 'accept' => '.xlsx']) !!}
      </div>
    </div>


    <div class="flex justify-end">
      <button class="btn-indigo">Importar</button>
    </div>
    {!! Form::close() !!}
  @endcomponent

@endsection
