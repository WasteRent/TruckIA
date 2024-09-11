@extends('layouts.customer')

@section('title', 'Checklist '.$vehicle_checklist->checklist->name . $vehicle_checklist->vehicle->plate)

@section('content')

    <div class="flex justify-end">
        
        <a class="text-red-800" href="{{ route('customer.vehicle-checklists.pdf', $vehicle_checklist) }}">
            <i class="fas fa-print mr-1"></i> Imprimir
        </a>
    </div>

    <br>
	
	@component('components.card')
		@slot('title', 'Checklist '.$vehicle_checklist->checklist->name . $vehicle_checklist->vehicle->plate)

        {!! Form::model($vehicle_checklist, [
            'route' => ['customer.vehicle-checklists.update', $vehicle_checklist],
            'method' => 'PUT',
            'files' => true,
            'class' => 'w-full auto_submit'
        ]) !!}  

        <input type="hidden" name="signature">

		@include('customer.vehicles.checklist.form')

        <div>
            <label class="text-base font-medium text-gray-900">Observaciones</label>
            <x-trix class="mb-8" name="notes">
                {{ $vehicle_checklist->notes }}
            </x-trix>
        </div>

        @if ($vehicle_checklist->positions)
		    <div class="grid grid-cols-1 gap-x-4 ">
                @include('shared.grid', [
                    'grid_x' => explode('x', $vehicle_checklist->grid)[0],
                    'grid_y' => explode('x', $vehicle_checklist->grid)[1],
                    'select_positions' => $vehicle_checklist->positions,
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

	@if(!$vehicle_checklist->signature)
    @include('sign', [
        'saveRoute' => route('customer.vehicle-checklists.update', $vehicle_checklist),
        'redirectRoute' => route('customer.vehicle-checklists.pdf', $vehicle_checklist)
    ])
	@endif

@endsection

