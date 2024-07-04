@extends('layouts.fleet')

@include('fleet.repair_orders.tabs', ['active_summary' => true])

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

        @if ($repair_order_checklist->positions)
		    <div class="grid grid-cols-1 gap-x-4 ">
                @include('shared.grid', [
                    'grid_x' => explode('x', $repair_order_checklist->grid)[0],
                    'grid_y' => explode('x', $repair_order_checklist->grid)[1],
                    'select_positions' => $repair_order_checklist->positions,
                ])
            </div>
        @else
            <div class="grid grid-cols-1 gap-x-4 ">
                <input type="hidden" name="grid" value="{{ $grid_x }}x{{ $grid_y }}">
                <input type="hidden" name="grid-position" value="">
                @include('shared.grid', ['edit_mode' => true])
            </div>	
        @endif

        {!! Form::close() !!}

	@endcomponent

	@if(!$repair_order_checklist->signature)
    @include('sign', [
        'saveRoute' => route('fleet.repair-order-checklists.update', $repair_order_checklist),
        'redirectRoute' => route('fleet.repair-order-checklists.pdf', $repair_order_checklist)
    ])
	@endif

@endsection

