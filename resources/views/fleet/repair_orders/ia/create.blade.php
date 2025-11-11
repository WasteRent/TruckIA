@extends('layouts.fleet')

@section('title', __('Completar orden de reparación con OCR'))

@section('content')

@component('components.card')
    @slot('title', __('Completar orden de reparación con OCR'))
    @slot('corner')
        <a href="{{ route('fleet.repair-orders.show', $repair_order) }}" class="btn-outline-gray">
            <i class="fas fa-arrow-left mr-2"></i>
            {{ __('Volver') }}
        </a>
    @endslot

    {!! Form::open([
        'route' => ['fleet.repair-orders.ia.store', $repair_order],
        'method' => 'POST',
        'enctype' => 'multipart/form-data',
        'class' => 'w-full'
    ]) !!}

    <div class="flex flex-wrap -mx-3 mb-6">
        <div class="w-full px-3 mb-6 md:mb-0">
            <label class="form-label form-required">
                {{ __('Seleccionar archivo') }}
            </label>
            {!! Form::file('file', [
                'class' => 'form-input',
                'accept' => '.pdf,.jpg,.jpeg,.png',
                'required' => true
            ]) !!}
            <p class="text-sm text-gray-500 mt-2">
                {{ __('Formatos soportados: PDF, JPG, JPEG, PNG. Tamaño máximo: 10MB') }}
            </p>
        </div>
    </div>

    <div class="flex justify-end">
        <button class="btn-indigo">
            {{ __('Añadir OCR') }}
        </button>
    </div>

    {!! Form::close() !!}
@endcomponent

@endsection
