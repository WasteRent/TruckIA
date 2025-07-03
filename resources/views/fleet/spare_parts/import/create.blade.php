@extends('layouts.fleet')

@section('title', 'Importador de recambios ')

@section('content')

  @component('components.card')
    @slot('title', 'Importador de recambios')

    {!! Form::open([
        'route' => ['fleet.import-spare-parts.store'],
        'method' => 'POST',
        'class' => 'w-full',
			  'files' => true,
    ]) !!}

    <div class="flex flex-wrap -mx-3 mb-6">
      <div class="w-full md:w-5/12 px-3 mb-6 md:mb-0">
        Descargar plantilla
        <a class="mr-4 text-green-600" href="{{ asset('excel/PLANTILLA_RECAMBIOS.xlsx') }}"><i class="fas fa-lg fa-file-excel"></i></a>
      </div>
    </div>

    <div class="flex flex-wrap -mx-3 mb-6">
      <div class="w-full md:w-4/12 px-3 mb-6 md:mb-0">
        <label class="form-label">
          Adjunto
        </label>
        {!! Form::file('attachment', ['class' => 'form-input', 'accept' => '.xlsx']) !!}
      </div>


      <div class="w-full md:w-4/12 px-3 mb-6 md:mb-0">
        <label class="form-label">
          Cliente
        </label>
        {!! Form::select('customer_id', $allowed_customers->pluck('name', 'id'), null, ['class' => 'form-input']) !!}
      </div>
    </div>

    <div class="flex justify-end">
      <button class="btn-indigo">Importar</button>
    </div>
    {!! Form::close() !!}
  @endcomponent

@endsection
