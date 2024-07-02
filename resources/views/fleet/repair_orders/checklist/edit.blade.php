@extends('layouts.fleet')

@section('title', __('Ordenes de Reparación'))

@section('content')

    <div class="flex justify-end">
        
        <a target="_blank" class="text-red-800" href="{{ route('fleet.repair-order-checklists.pdf', $repair_order_checklist) }}">
            <i class="fas fa-print mr-1"></i> Imprimir
        </a>
    </div>

    <br>
	
	@component('components.card')
		@slot('title', 'Checklist '.$repair_order_checklist->checklist->name.' de orden de reparación #' . $repair_order_checklist->repairOrder->id)

        {!! Form::model($repair_order_checklist, [
            'route' => ['fleet.repair-order-checklists.update', $repair_order_checklist],
            'method' => 'PUT',
            'files' => true,
            'class' => 'w-full auto_submit'
        ]) !!}  

        <input type="hidden" name="signature">

		@include('fleet.repair_orders.checklist.form')

        <div>
            <label class="text-base font-medium text-gray-900">Observaciones</label>
            <x-trix class="mb-8" name="notes">
                {{ $repair_order_checklist->notes }}
            </x-trix>
        </div>

        {!! Form::close() !!}

	@endcomponent

	@if(!$repair_order_checklist->signature)
    @include('sign', [
        'saveRoute' => route('fleet.repair-order-checklists.update', $repair_order_checklist),
        'redirectRoute' => route('fleet.repair-order-checklists.pdf', $repair_order_checklist)
    ])
	@endif

@endsection

