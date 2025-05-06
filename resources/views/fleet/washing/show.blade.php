@extends('layouts.fleet')

@section('title')
    <div class="flex justify-between items-center">
        <div class="mr-20">{{ $washing->vehicle->plate }} - {{ $washing->created_at->format('d/m/Y H:i') }}</div>
    </div>
@endsection

@section('content')
    @component('components.card')
        @slot('title', __('Lavados realizados'))
        <div class="flex flex-col justify-start items-start gap-2">
            <div class="flex flex-col gap-3">
                @foreach ($vehicle_washing_types as $type)
                    <div class="text-sm">
                        <label>
                            {!! Form::hidden("vehicle_washing_types[$type->id]", 0) !!}

                            {!! Form::checkbox("vehicle_washing_types[$type->id]", 1, optional($washing->vehicleWashingChecklists->firstWhere('vehicle_washing_type_id', $type->id))->is_checked == 1 ? true : false, ['disabled' => true]) !!}
                            {{ __($type->name) }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
    @endcomponent
@endsection
