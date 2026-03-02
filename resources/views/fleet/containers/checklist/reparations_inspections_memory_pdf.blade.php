@extends('layouts.pdf')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-semibold text-gray-900 mb-4">
        {{ __('Memoria de inspecciones y reparaciones de contenedores') }}
    </h1>
    <p class="text-sm text-gray-600 mb-6">
        {{ __('Periodo') }}: {{ $date_from }} - {{ $date_to }}
    </p>

    <h2 class="text-lg font-semibold text-gray-900 mb-2">1. {{ __('Memoria semestral de inspección') }}</h2>
    <p class="text-sm text-gray-700 mb-2">
        {{ __('El adjudicatario emitirá el correspondiente informe semestral de inspección, en la que se dará cuenta de las siguientes cuestiones:') }}
    </p>
    <ul class="list-disc list-inside text-sm text-gray-700 mb-4">
        <li>{{ __('Informe de comprobación de las actuaciones de mantenimiento preventivo de cada contenedor conforme a lo exigido en el presente pliego') }}</li>
        <li>{{ __('Incidencias detectadas') }}</li>
        <li>{{ __('Dictamen motivado de la necesidad o no de mantenimiento correctivo') }}</li>
    </ul>
    <p class="text-sm text-gray-700 mb-6">
        {{ __('La memoria se debe presentar en los 15 días posteriores a la finalización del correspondiente semestre.') }}
    </p>

    <h2 class="text-lg font-semibold text-gray-900 mb-2">2. {{ __('Certificación de reparación') }}</h2>
    <p class="text-sm text-gray-700 mb-2">
        {{ __('Después de cada reparación se emitirá la correspondiente certificación en la que se recojan los siguientes datos:') }}
    </p>
    <ul class="list-disc list-inside text-sm text-gray-700 mb-4">
        <li>{{ __('Descripción de los trabajos realizados') }}</li>
        <li>{{ __('Fecha de comienzo y finalización de la reparación') }}</li>
        <li>{{ __('Desglose de piezas y elementos sustituidos') }}</li>
        <li>{{ __('Observaciones que a juicio del adjudicatario se deban considerar') }}</li>
    </ul>
    <p class="text-sm text-gray-700 mb-6">
        {{ __('La certificación de reparación se debe presentar en los 15 días posteriores a la finalización de la reparación.') }}
    </p>

    <h2 class="text-lg font-semibold text-gray-900 mb-2">3. {{ __('Memoria anual de reparaciones') }}</h2>
    <p class="text-sm text-gray-700 mb-2">
        {{ __('La memoria anual deberá aportar el siguiente contenido:') }}
    </p>
    <ul class="list-disc list-inside text-sm text-gray-700 mb-4">
        <li>{{ __('Listado de las reparaciones realizadas') }}</li>
        <li>{{ __('Listado de piezas y elementos sustituidos') }}</li>
        <li>{{ __('Estadísticas de las averías, reparaciones y piezas y elementos de sustitución') }}</li>
        <li>{{ __('Dictamen del estado general del parque de contenedores') }}</li>
    </ul>
</div>

@if($container_checklists->count() > 0)
    <div style="page-break-after: always;"></div>
@endif

@foreach ($container_checklists as $index => $container_checklist)
    @if($index > 0)
        <div style="page-break-after: always;"></div>
    @endif

    @include('fleet.containers.checklist.pdf_single', ['container_checklist' => $container_checklist])
@endforeach
@endsection

